<?

require_once("../library/Util.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>Execute a querie:</p>
<p>&nbsp;</p>
<form method="post" name="frm" action="<?= $_SERVER['SCRIPT_NAME'] ?>">
<textarea name="querie" id="queria"  style="height: 420px; width: 550px"><?= @$_POST["querie"] ?></textarea>

<input type="submit" value="Executar" name="btQuerie" />

<input type="submit" value="Corrige Sequences" name="btCorrige"  />

<br />
<? if ( @$_POST["btCorrige"] != ""){
    
    	
        $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
	$oConn->connect();
        
        $sql = " SELECT * FROM pg_catalog.pg_tables
               where schemaname in ( 'public','survay','geral','custom')   ";

        	$arr = connAccess::fetchData($oConn, $sql) ;


     if ( count($arr) > 0 ){
          for ( $i = 0; $i < count($arr); $i++ ){
              
              $item = $arr[$i];
              
              $tabela = $item["tablename"];
              $schema = $item["schemaname"];
              
              
                if ( $tabela == "analise_usuario")
                    continue;
                
                if ( $tabela == "analise_componentetemplate")
                    continue;
                
                
                
                $old_id = @connAccess::executeScalar($oConn, " select max(id) from ". $schema.".".$tabela );
              
                
                if ( trim($old_id) != ""){
               $sql = "SELECT setval(pg_get_serial_sequence('".$schema.".".$tabela."','id'), (select max(id) from ". $schema.".".$tabela.")) ";
               
               $id_max = connAccess::executeScalar($oConn, $sql);
               
               echo("<br>Executado, último ID: ". $id_max . " ID antes de atualizar: ". $old_id . " -- Querie: ". $sql . ( $old_id != $id_max ? " <b>(CHECAR)</b>":"") );
                }
          }
          
          echo("<b>FIM!</b>");
     }

}
     if ( @$_POST["querie"] != "" ) { 

  
	
        $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
	$oConn->connect();
	echo("<br>Encoding: ". pg_client_encoding($GLOBALS[PostGreSQLConnection::$_nomeConn]));
	$arr = connAccess::fetchData($oConn, @$_POST["querie"]) ;


     if ( count($arr) > 0 ){
         
         echo( constant("pg_host"));
         echo(" - ". pg_database);
         echo(" - ". pg_user);
         
	     echo '<table><tr>';
		  
		  $item = $arr[0];
		  
		  foreach( $item as $key=>$value){
		  
		     if (! is_numeric($key) ){
		           echo '<th>'.$key.'</th>';
			 }
		  }
		   
		 echo '</tr>';
		 for ( $z = 0; $z < count($arr); $z++ ){
		        echo ("<tr>");
				
		       $item = $arr[$z];
				 foreach( $item as $key=>$value){
				  
					 if (! is_numeric($key) ){
						   echo '<td>'.$value.'</td>';
					 }
				  }
				echo ("</tr>");
		 
		 }
		 
		 
		 echo '</tr>';
		 
	 
	 }else{
	 
	     echo ("nenhum registro retornado!");
	 }

   $oConn->disconnect();
 }
?>
<br />
</form>
</body>
</html>
