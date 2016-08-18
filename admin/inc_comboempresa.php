<?php

function mostraComboEmpresa( $id_empresa ){
	/* TODO: Add code here */
	
	global $oConn;
	
	if ( SessionFacade::getProp("nivel") == "1" ){
		?>
		<tr >
		<td><label>Empresa</label> <br>
		<select   name="id_empresa" id="id_empresa" > 
		<option value="">--</option>
		<? 
		$rslista = connAccess::fetchData($oConn, "select id, nome from empresa where 1 = 1  order by nome"); 
		Util::CarregaComboArray( $rslista, "id" , "nome",  $id_empresa ); ?>  
		</select> 
		</td>
		</tr>
	<? }else{ ?>
		
		<input type="hidden" name="id_empresa" value="<?= Util::NVL($id_empresa, SessionFacade::getProp("id_empresa")) ?>" ?>
		
		<?
		
	}
}


function testaEmpresa($registro ){
	
	if ( SessionFacade::getProp("nivel") != 1 ){
	     
		if ( array_key_exists( "id_empresa", $registro)){
			
			if ( $registro["id_empresa"]	 !=  SessionFacade::getProp("id_empresa") ){
				
				//die(" VOCÊ NÃO TEM ACESSO A ESTE REGISTRO! ");	
			}
		}	
		
	}	
}

function filtroSQLEmpresa($campo, $valor2 = ""){
	
	return "";
	if ( SessionFacade::getProp("nivel") != 1 ){
		return " and ifNull(". $campo . ",0) in ( " . Util::NVL($valor2, Util::NVL( SessionFacade::getProp("id_empresa"),"0") ) ." ) ";
	}
	
	if ( $valor2 != "" )
		return " and ifNull(". $campo . ",0) in ( " .$valor2.") ";
	
	
}


?>		