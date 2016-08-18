
<?
function mostraItemParaPerfil( array $perfis ){
	
	return "";
	for ( $y = 0; $y < count($perfis); $y++){
		
		if ( SessionFacade::temPerfil( $perfis[$y] ) ){
			return "";	
		}	
	}
	
	echo ( " style='display:none' " );
	
}



?>
<!--
<a href="sair.php" style="text-decoration: none">Sair do Sistema</a>

-->

<table style="width: 100%; height: 40px; background: #<?= Parameters::getValue("color_submenu", $oConn) ?>">
   <tr
<?
if ( $mod =="config" ){ echo ' style="display:none" '; };
	?>

>
       <td style="font-size: 20px; padding-left: 10px; color: #<?= Parameters::getValue("color_fontsubmenu", $oConn) ?>; text-align: left" align="left">
	
	           <? //=  getTituloModulo($mod, $pag, Util::request("tipo"),  1) ?>
	  
			&nbsp;&nbsp;&nbsp;
		    <? //if ( Util::request("pag") == "cliente" && Util::request("tipo") ==2 ){ ?>
			<a href="#" onclick="openPagina('listar','<?= Util::request("pag") ?>','&tipo=<?=Util::request("tipo")?>');"><img width="24" height="24" src="<?= K_RAIZ ?>images/icon_list.png" title="Listagem"  /></a>
			&nbsp;
			<? //} else { ?>
			<a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','&tipo=<?=Util::request("tipo")?>');"><img width="24" height="24" src="<?= K_RAIZ ?>images/icon_add.png" title="Cadastrar Novo"  /></a>
				&nbsp;
			<? //} ?>
			
			
			<? if ( $mod == "cad" && Util::request("id") != "" ){ ?>		
		
			<a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','&acao=LOAD&id=<?=Util::request("id")?>&tipo=<?= Util::request("tipo")?>');"><img width="24" height="24" src="<?= K_RAIZ ?>images/icon_refresh.png" title="Atualizar este registro"  /></a>
				&nbsp;
			<? } ?>
	
	<? if ( $mod == "listar" && $mostrarBotaoExportar ){ ?>
	<a href="#" onclick="openPrint('listar','<?= Util::request("pag") ?>','','html');"><img width="24" height="24" src="<?= K_RAIZ ?>images/icon_print.png" title="Imprimir" /></a>
	&nbsp;
	<a href="#" onclick="openPrint('listar','<?= Util::request("pag") ?>','','');"><img width="24" height="24" src="<?= K_RAIZ ?>images/icon_excel.png" title="Exportar" /></a>
&nbsp;
	<? } ?>
		
		</td>
		<td style="width: 180px; text-align: left" align="right">
		<? 
if ( false ) { 
		if ( Util::request("pag")== "cliente" || Util::request("pag")== "contrato" || Util::request("pag")== "estabelecimento" ) { ?>
		<a href="#" onclick="openPagina('listar','cliente','&tipo=1');"><img  src="<?= K_RAIZ ?>images/icon_communication.png" width="24" height="24" title="Cadastro de Prospecção"  /></a>
		&nbsp;
		<a href="#" onclick="openPagina('listar','cliente','&tipo=2');"><img  src="<?= K_RAIZ ?>images/icon_my-account.png" width="24" height="24" title="Cadastro de Ficha do Cliente"  /></a>
		&nbsp;
			<a href="#" onclick="openPagina('listar','estabelecimento','');"><img  src="<?= K_RAIZ ?>images/icon_unidade.png" width="24" height="24" title="Cadastro de Unidades (Cliente)"  /></a>
		&nbsp;
		
		
		
		<a href="#" onclick="openPagina('listar','contrato','');"><img  src="<?= K_RAIZ ?>images/icon_featured.png"  title="Cadastro de Contrato" width="24" height="24" /></a>
		&nbsp;
		<a href="#" ><img  src="<?= K_RAIZ ?>images/icon_zoom.png" title=""  width="24" height="24" /></a>
		
	<? } 
		}?>
		</td>
   </tr>
</table>






		




		
