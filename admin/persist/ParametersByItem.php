<?
/*
   Save and View configuration parameters to application
*/
class ParametersByItem  {
	
	
	public static function saveAllParameters($id_registro, $nome_tabela, $prefixo="prop_" ){
		
            global $oConn;
                
            foreach ($_REQUEST as $key => $value) {
                
                if ( strpos(" ".$key,$prefixo)){
                    $ar = explode($prefixo, $key);
                    
                    //die( "---> ". $ar[1]);
                    if ( trim(@$ar[1]) != ""){
                              ParametersByItem::setValue($ar[1], $value, $id_registro, $nome_tabela, $oConn);
                    
                    }
                }
            }
            
	}
	
        
        public static function showRadioButton($name_radio, $rslista, $valueSel = "", $field_query_val="cod", $field_query_text = "descr"){
            
            
                        for ( $i = 0; $i< count($rslista); $i++){

                             $item = $rslista[ $i ];
                             ?>
                             <input type="radio" value="<?=$item[$field_query_val]?>" name="<?=$name_radio?>" id="<?=$name_radio?>" class="form-radio"
                                <? if ( $valueSel == $item[$field_query_val] ){ echo (" checked "); } ?>
                             ><?=$item[$field_query_text]?>
                             &nbsp;&nbsp;&nbsp;

                             <?        
                        }        
            
            
        }
        
             
        public static function showCheckBoxList($name_radio, $rslista, $valueSel = "", $field_query_val="cod", $field_query_text = "descr"){
            
            $arrVals = new ArrayList();
            
            if ( $valueSel != "")
                $arrVals = new ArrayList(explode(",", $valueSel));
            
                        for ( $i = 0; $i< count($rslista); $i++){

                             $item = $rslista[ $i ];
                             ?>
                             <input type="checkbox" value="<?=$item[$field_query_val]?>" name="<?=$name_radio?>_<?=$i?>" id="<?=$name_radio?>_<?=$i?>" class="form-checkbox"
                                <? if ( $arrVals->contains(  $item[$field_query_val] )  ){ echo (" checked "); } ?>
                             ><?=$item[$field_query_text]?>
                             &nbsp;&nbsp;&nbsp;

                             <?        
                        }        
            
            
        }
        
        public static function generateArrayByString($str = "", $lineSep=",", $colSep = "|"){
            
            
            $arr = array();
            
            $ar = explode($lineSep, $str);
            
                        for ( $i = 0; $i< count($ar); $i++){
                            
                             $item = $ar[ $i ];
                             
                             $cols = explode($colSep, $item);                             
                             $arr[ count($arr)] = array("cod"=>$cols[0],"descr"=>$cols[1]);
                            
                        }
            
            return $arr;
        }
        
	
         /// <summary>
         /// Set parameter value
         /// </summary>
         /// <param name="cod"></param>
         /// <param name="valor"></param>
         public static function setValue($cod, $value, $id_registro, $nome_tabela, IDbPersist $oConn)
         {
	
             //$sql = " select * from parametros_configuracao where codigo = '" . $cod ."' ";
			
			 $ar = connAccess::fastQuerie($oConn, "parameters_by_item", "code = '" . $cod ."' and id_registro = ". $id_registro . " and nome_tabela='".$nome_tabela."' " );
			
             if (count($ar) > 0)
             {
				$item = $ar[0];

			    $item["value"] = $value;
			    $item["id_registro"] = $id_registro;
			    $item["nome_tabela"] = $nome_tabela;
				
				 $id =  $item["id"];
				
				
			
			    connAccess::nullBlankColumns( $item );
		     	connAccess::Update($oConn,$item,"parameters_by_item","id" );

                 //ConnAccess.Execute(" update parametros_configuracao set valor = '" + valor.Replace("'", "''") + "' where codigo = '" + cod + "' ");
             }
             else
             {
			  $sql = " insert into parameters_by_item ( code, value, id_registro, nome_tabela ) values ( '" . $cod . "','" . str_replace("'", "''", $value) . "',".$id_registro.",'".
                              $nome_tabela."') ";
			  connAccess::executeCommand( $oConn,  $sql ); 
				
             }
			
         }

	public static function getValue($cod, $id_registro, $nome_tabela, IDbPersist $oConn)
         {

            if ( $id_registro == "")
                return "";
            
		$sql = " select * from parameters_by_item where code = '" . $cod ."'  and id_registro = ". $id_registro . " and nome_tabela='".$nome_tabela."' " ;
			
		$ar = connAccess::fetchData($oConn,  $sql );

             if (count($ar) > 0)
             {
				return  $ar[0]["value"];
				
             }
			
		return "";
         }
         
         
         static function mostraChecks($lista, $prefixo = "", $campo_id = "", $campo_txt = "", $titulo = "", $change = true,
	 $tem_lista = false, $lista_se_tem = "", $marca_todos = false, $height="250px"){
    ?>
	<div style="height: <?=$height?>; width: 100%; overflow: scroll"><label><?=$titulo?></label>
	<table style="width: 100%">
	
	<?
	
	$listaAr = new ArrayList();
	
	if ( $tem_lista && $lista_se_tem != "" ){
		$listaAr = new ArrayList( explode(",", $lista_se_tem));	
	}
	
	 for ( $i = 0; $i < count($lista); $i++){	
		
		$item = $lista[$i];
		
		$id = $item[$campo_id];
		$text = $item[$campo_txt];
		
	?>	
	    
		<tr class="<?php if ( $i%2){ echo "f-tabela-texto-alt"; } else { echo "f-tabela-texto";} ?>">
		  <td style="width: 20px">
		
		<input type="checkbox" name="<?= $prefixo?>_<?=$id?>" <? if ( $change ) { ?> onclick="att_marcacao(this)" <? } ?> value="<?= $id ?>"
		   <? 
		   if (! $tem_lista ){
		   	    if ( request($prefixo."_".$id) != "" ){ echo ( " checked "); } 
		   }else{
		   	if ( $listaAr->contains( $id ) ){  echo ( " checked ");   }
		   }			
		 ?>> 
		   </td>
		<td><?= Util::acento_para_html( $text ) ?></td>
		</tr>
	<?	}  ?>
     </table>
	</div>
	
	<input type="checkbox" name="g_marcatodos<?=$prefixo?>" value="1" 
	   <?  if (! $tem_lista ){ 
	   	if ( request("g_marcatodos".$prefixo) != "" ){ echo ( " checked "); }
	   } else {
	   	    if ( $marca_todos ){ echo ( " checked "); }
	   } ?> 
		 onclick="att_marcatodos(this,'<?= $prefixo?>_')"> <b>Marcar Todos</b>
<? 
}


static function getIDS($prefixo){
	
	$str = "";
	
	foreach($_REQUEST as $key=>$value){
	         
		if ( strpos(" ".$key,$prefixo."_")){
			$str = Util::AdicionaStr($str,$value,",");
		} 	
		
	}
	
	return $str;	
}	

		
}