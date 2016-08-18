<?php
/*
   Save and View configuration parameters to application
*/
class Parameters  {
	
	public static function setaSequencial($data, $id_cliente, $id_estabelecimento, IDbPersist $oConn){
		
		$dt = new DateTime($data);
		
		
		$sql = " select id from inspecao where id_cliente = " . $id_cliente . " and id_estabelecimento = " . $id_estabelecimento . "  and month(data) = ".
			$dt->format("m"). " and year(data) = ". $dt->format("Y") . " order by data asc ";
		
		$lista = connAccess::fetchData($oConn, $sql);
		
		
		for ( $y = 0 ; $y < count($lista); $y++){   
			
			$update = " update inspecao set seq_ano_mes_cliente = ". ($y+1) . 
				" where id = ".  $lista[$y]["id"];
			
			connAccess::executeCommand($oConn, $update);
		}
		
		
	}
	
	
         /// <summary>
         /// Set parameter value
         /// </summary>
         /// <param name="cod"></param>
         /// <param name="valor"></param>
         public static function setValue($cod, $value, IDbPersist $oConn)
         {
	
             //$sql = " select * from parametros_configuracao where codigo = '" . $cod ."' ";
			
			 $ar = connAccess::fastQuerie($oConn, "parameters", "code = '" . $cod ."' " );
			
             if (count($ar) > 0)
             {
				$item = $ar[0];

			    $item["value"] = $value;
				
				 $id =  $item["id"];
				
				
			
			    connAccess::nullBlankColumns( $item );
		     	connAccess::Update($oConn,$item,"parameters","id" );

                 //ConnAccess.Execute(" update parametros_configuracao set valor = '" + valor.Replace("'", "''") + "' where codigo = '" + cod + "' ");
             }
             else
             {
			  $sql = " insert into parameters ( code, value ) values ( '" . $cod . "','" . str_replace("'", "''", $value) . "') ";
			  connAccess::executeCommand( $oConn,  $sql ); 
				
             }
			
         }

	public static function getValue($cod, IDbPersist $oConn)
         {

		$sql = " select * from parameters where code = '" . $cod ."' ";
			
		$ar = connAccess::fetchData($oConn,  $sql );

             if (count($ar) > 0)
             {
				return  $ar[0]["value"];
				
             }
			
		return "";
         }
		
}