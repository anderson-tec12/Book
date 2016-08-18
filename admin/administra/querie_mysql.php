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

<br />
<? if ( @$_POST["querie"] != "" ) { 

                $mysql_host = constant("mysql_host");
		$mysql_user = constant("mysql_user");
		$mysql_pass = constant("mysql_pass");
		$mysql_initialcommand = constant("mysql_initialcommand");
		$mysql_db = constant("mysql_db");
		$port = 3306;
	
	  $sql = $_POST["querie"];
         echo( constant("mysql_host"));
         echo(" - ". mysql_db);
         echo(" - ". mysql_user);
         
		$conn =   mysql_connect($mysql_host,$mysql_user,$mysql_pass);
			
                mysql_select_db(mysql_db, $conn);
	        $fet = mysql_query($sql, $conn);					 
	
                
                if ( !$fet ){
                    
		     mysql_close( $conn);
                    die("Deu problema". $sql);
                }
                
                print_r( $fet );
                 $arr = array();
			
			while ( $subr = mysql_fetch_array($fet)){
			
			    $arr[ count($arr) ] = $subr;
			}   
                
                
		   
          //  print_r( $conn );

          //  print_r( $oConn ); die(" -- ");

          //  $arr = connAccess::fetchData($oConn, @$_POST["querie"]) ;

        //print_r( $arr );

     if ( count($arr) > 0 ){
         
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

		   mysql_close( $conn);
     //$oConn->disconnect();
 }
?>
<br />
<input type="submit" value="Executar"  />
</form>
</body>
</html>
