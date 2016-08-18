<? 

$qtde_registro_max = 10;

function setaFiltroTemporario($text, IDbPersist $oConn){
	
	$registro = $oConn->describleTable("filtro_temporario");
	
	$registro["filtro"]	= $text;
	$registro["data_cadastro"]	= Util::getCurrentBDdate();
	
	
	$registro["usuario"]	= SessionFacade::getNome();
	$registro["url"]	= $_SERVER["SCRIPT_NAME"];
	
	connAccess::nullBlankColumns($registro);
	return connAccess::Insert($oConn,$registro,"filtro_temporario","id",true);
}

function getFiltroTemporario($id , IDbPersist $oConn){
	
	$arr = connAccess::fastOne($oConn,"filtro_temporario"," id = " . $id,"");
	
	return $arr["filtro"];	
}

function limpaFiltro(IDbPersist $oConn){
	
	connAccess::executeCommand($oConn, " delete from filtro_temporario where data_cadastro <= date_add(sysdate(), interval -20 day) ");
}

function getHtmlColorRandom($id){
	
	$cores = array(
		 "3366CC","DC3912",
		"FF9900","109618",
		"990099","0099C6",
		"DD4477","66AA00","B82E2E",
		
			
			"73171C",
			"E5D1F0",
			"4D6E70",
			"AD6F72",
			"DFE5EB",
			"EBA9AC",
			"483C8C",
		
		"D4D29F",
			"F0D1D4",
			"D1F0EA",
			"F0E0D1",
			"F0F0D1",
		     "0000CD",
			"689396",
			"FAE19D",
			"68ADF2",
			
			"29234D",
			
			"E8AC07",
			
			"5691CC",
			
			"F29268",
			"C0A7CC",
			"502A63",
			
			
			"#282E33", "#327480", "#63851B","#9E9B99", "#B5A084", "#164852","#A6B584",
			"#A384B5","#B5AF84","#40A8A7","#BAA218","#BA4118"
			
			);
			
	if ( $id > count($cores) -1 ){
		
		$id = 0;	
	}
	
	return "#".$cores[ $id ];
	
}


	
function getIDS($prefixo){
	
	$str = "";
	
	foreach($_REQUEST as $key=>$value){
	         
		if ( strpos(" ".$key,$prefixo."_")){
			$str = Util::AdicionaStr($str,$value,",");
		} 	
		
	}
	
	return $str;	
}	


function mostraTabela( array $arr , $style = ""){
	
	$str = "";
	
	$str = "<table " . $style. ">";
	
	$estilo1 = " bgcolor='#EEEEEE' ";
	$estilo2 = " bgcolor='#F7F4F2' ";
	
    for ( $y = 0; $y < count( $arr); $y++){
		
		$item = $arr[ $y ];
		$str .= "<tr";
		
		if ( $y > 0){
		if ( $y % 2 ){
			 $str .= " ".$estilo1; 
			}else{
				
			 $str .= " ".$estilo2;
				}
		}else{
		
			 $str .= " bgcolor='#FFB951'  "; 
		
			
		}
		
		$str.=">";
         for ( $yy = 0; $yy < count( $item); $yy++){
		      
			$classe = "td";
			
			if ( $y > 0 )
			   $classe = "td";
			
			if ( $yy > 0 )
			   $classe .= " align='center' ";
			
			$str .= "<".$classe.">";
			
			if ( is_numeric($item[$yy]) ){
				
				$str .=  Util::NVL(Util::numeroTela( $item[$yy], 1 ),"0");
				}else{
			
			    $str .= Util::NVL( $item[$yy],"-");
			}
			$str .= "</".$classe.">";
		 }
		$str .= "</tr>";
		
		
	}
	
	
	$str .= "</table>";
	
	return $str;
}

function getArrTipoRel(){
    
	$arr = array();
	
	//$arr[ count($arr) ] = array("id"=>"1","desc"=>"Auditoria x Categoria");
	//$arr[ count($arr) ] = array("id"=>"2","desc"=>"Auditoria x Unidade");
	//$arr[ count($arr) ] = array("id"=>"3","desc"=>"Unidade x Categoria");
	//$arr[ count($arr) ] = array("id"=>"4","desc"=>"Item x Unidade");
	
	
	$arr[ count($arr) ] = array("id"=>"3","desc"=>"Gráfico  de  comparação  de  notas  de  Categorias  entre  Unidades");
	$arr[ count($arr) ] = array("id"=>"4","desc"=>"Gráfico  de  comparação  da  pontuação  de  Itens  de Categorias  entre  Unidades");


   return $arr;
	
}
function getArrTipoRel2(){
    
	$arr = array();
	
	$arr[ count($arr) ] = array("id"=>"1","desc"=>"Cliente/Unidades");
	$arr[ count($arr) ] = array("id"=>"2","desc"=>"Categorias");


   return $arr;
	
}

	


function mostraChecks($lista, $prefixo = "", $campo_id = "", $campo_txt = "", $titulo = "", $change = true,
	 $tem_lista = false, $lista_se_tem = "", $marca_todos = false, $height="250px", $campo_de_grupo = "", $bot_final = ""){
    ?>
	<div style="height: <?=$height?>; width: 100%; overflow: scroll"><label><?=$titulo?></label>
	<table style="width: 100%">
	
	<?
	
	$listaAr = new ArrayList();
	
	if ( $tem_lista && $lista_se_tem != "" ){
		$listaAr = new ArrayList( explode(",", $lista_se_tem));	
	}
	
	$ultimo_grupo = "";
	 for ( $i = 0; $i < count($lista); $i++){	
		
		$item = $lista[$i];
		
		$id = $item[$campo_id];
		$text = $item[$campo_txt];
		
		if ( $campo_de_grupo != "" && $ultimo_grupo != $item[$campo_de_grupo]){
			?>
			<tr>
			<td style="background: #CCCCCC" colspan="2">
			<b><?= $item[$campo_de_grupo]; ?></b>
			</td>
			</tr>
			
			<?			
		}
		if ( $campo_de_grupo != "" ){
			$ultimo_grupo = $item[$campo_de_grupo];
		}
	?>	
	    
		<tr class="<?php if ( $i%2){ echo "f-tabela-texto-alt"; } else { echo "f-tabela-texto";} ?>">
		  <td style="width: 20px">
		
		<input type="checkbox" name="<?= $prefixo?>_<?=$i?>" <? if ( $change ) { ?> onclick="att_marcacao(this)" <? } ?> value="<?= $id ?>"
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
	
	<?=$bot_final?>
<? 
}








function mostraItemToRemove($lista, $prefixo = "", $campo_id = "", $campo_txt = "", $titulo = "", $change = true,
	$tem_lista = false, $lista_se_tem = "", $marca_todos = false, $height="250px", $campo_de_grupo = "", $acao = "", $campo_de_grupo_val = ""){
	?>
	<div style="height: <?=$height?>; width: 100%; overflow: scroll"><label><?=$titulo?></label>
	<table style="width: 100%">
	
	<?
	
	$listaAr = new ArrayList();
	
	if ( $tem_lista && $lista_se_tem != "" ){
		$listaAr = new ArrayList( explode(",", $lista_se_tem));	
	}
	
	$ultimo_grupo = "";
	for ( $i = 0; $i < count($lista); $i++){	
		
		$item = $lista[$i];
		
		$id = $item[$campo_id];
		$text = $item[$campo_txt];
		
		if ( $campo_de_grupo != "" && $ultimo_grupo != $item[$campo_de_grupo]){
			?>
			<tr>
			<td style="background: #CCCCCC" style="width: 24px" width="24px">
			<img src="images/delete.png"  style="cursor: pointer" onclick="<?= $acao ?>('<?=$item[$campo_de_grupo_val]?>','grupo');">
			</td>
			<td style="background: #CCCCCC" >
			<b><?= Util::acento_para_html($item[$campo_de_grupo]); ?></b>
			</td>
			</tr>
			
			<?			
		}
		
		$ultimo_grupo = $item[$campo_de_grupo];
		?>	
		
		<tr class="<?php if ( $i%2){ echo "f-tabela-texto-alt"; } else { echo "f-tabela-texto";} ?>">
		
		<td  style="padding-left: 25px" colspan="2">
		
		<img src="images/delete.png"  style="cursor: pointer" onclick="<?= $acao ?>('<?=$item[$campo_id]?>','item');"> -
		<?= Util::acento_para_html( $text ) ?></td>
		</tr>
	<?	}  ?>
	</table>
	</div>
	<? 
}
?>