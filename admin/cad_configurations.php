<?php

require_once("persist/Parameters.php");

$acao  = request("acao");

if ( $acao == Util::$SAVE ){
	
	foreach($_POST as $key=>$value){
		
		Parameters::setValue($key,$value, $oConn);
		//echo("<input type='hidden' name='".$key."' value='<? =ParametroConfiguracao::getValor('".$key."')? >'>");
		//echo("<br>");
	}
	
	$_SESSION["st_Mensagem"] = "Parameters save successfully!";
	
}

if ( $acao == "email" && Parameters::getValue("applicationEmail", $oConn) != "" ){
    
    Util::enviarEmail(Parameters::getValue("applicationEmail", $oConn), "Teste de envio de email", "Teste", Parameters::getValue("applicationName", $oConn), 
            Parameters::getValue("applicationEmail", $oConn) );
    
    
	$_SESSION["st_Mensagem"] = "Verifique se chegou o email para " .  Parameters::getValue("applicationEmail", $oConn) ;
    
}
Util::mensagemCadastro(85);


?>

<link href="<?= K_RAIZ ?>library/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript src="<?= K_RAIZ ?>library/colorpicker/jscolor/jscolor.js"></SCRIPT>
<form method="post" name="frm" 
action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">

	  <input type="hidden" name="acao" value="<?php echo Util::$SAVE  ?>">
	  
	<input type="hidden" name="ispostback" value="1">
	

<div class="fieldBox">
<table cellpadding="0" cellspacing="0" style="width: 700px" class="tbcadastro">
    <tr> 
    <td colspan="2">
	   <label>Application's  Name</label><br>
	  <input type="text" name="applicationName" value="<?= Parameters::getValue("applicationName", $oConn) ?>" maxlength="300"   style="width: 200px;">
	   

	  
	  </td>
	</tr>
	
          <tr> 
    <td colspan="2">
	   <label>E-mail administrativo</label><br>
	  <input type="text" name="applicationEmail" value="<?= Parameters::getValue("applicationEmail", $oConn) ?>" maxlength="300"   style="width: 200px;">
	   

	  
	  </td>
	</tr>
        
	  <tr> 
    <td colspan="2">
	   <label>Your Corporation's Name</label><br>
	  <input type="text" name="corpName" value="<?= Parameters::getValue("corpName", $oConn) ?>" maxlength="300"  style="width: 200px;">
	   

	  
	  </td>
	</tr>
	
		  <tr> 
    <td colspan="2">
	   <label>Caminho da Logo do Sistema (topo)</label><br>
	  <input type="text" name="imageSystem" value="<?= Parameters::getValue("imageSystem", $oConn) ?>" maxlength="300"  style="width: 400px;">
	   

	  
	  </td>
	</tr>
	
	<tr>
	 <td>
	   <label>Cor do Topo</label><br>
		  <input type="text" class="color" name="color_main" value="<?= Parameters::getValue("color_main", $oConn) ?>" maxlength="8" style="width: 70px;"> 
		<i>Default: 185792</i>
	   

	  
	  </td>
	
		 <td>
	   <label>Cor do Texto do Topo (Nome do sistema)</label><br>
		  <input type="text" class="color" name="color_appname" value="<?= Parameters::getValue("color_appname", $oConn) ?>" maxlength="8" style="width: 70px;"> 
	   <i>Default: DABA73</i>

	  
	  </td>
	
    </tr>
	
	
	<tr>
	 <td>
	   <label>Cor de fundo, barra de sub-menu</label><br>
		  <input type="text" class="color" name="color_submenu" value="<?= Parameters::getValue("color_submenu", $oConn) ?>" maxlength="8" style="width: 70px;"> 
		<i>Default: 185792</i>
	   

	  
	  </td>
	
	
	
		 <td>
	   <label>Dor da fonte do sub-menu</label><br>
		  <input type="text" class="color" name="color_fontsubmenu" value="<?= Parameters::getValue("color_fontsubmenu", $oConn) ?>" maxlength="8" style="width: 70px;"> 
	   <i>Default: 0F385E</i>

	  </td>
	  </tr>
	<tr>
		 <td>
	   <label>Cor do cabeçalho das tabelas de listagem</label><br>
		  <input type="text" class="color" name="color_headertable" value="<?= Parameters::getValue("color_headertable", $oConn) ?>" maxlength="8" style="width: 70px;"> 
	   <i>Default: CAE1F7</i>

	  
	  </td>
		
		 <td>
	   <label>Cor de Fundo do sistema</label><br>
		  <input type="text" class="color" name="color_background" value="<?= Parameters::getValue("color_background", $oConn) ?>" maxlength="8" style="width: 70px;"> 
	   <i>Default: FFFFFF</i>

	  
	  </td>
	
    </tr>
	
	
	
	<tr>
	 <td>
	   <label>Altura do topo</label><br>
		  <input type="text" class="color" name="alturaTopo" value="<?= Parameters::getValue("alturaTopo", $oConn) ?>" maxlength="7" style="width: 50px;"> 
		<i>Default: 60px</i>
	   
	  </td>
	
    </tr>
	
	
		
	<tr>
	 <td>
	   <label>Cor do link de funcionalidades (Topo)</label><br>
		  <input type="text" class="color" name="linkTopoFuncCor" value="<?= Parameters::getValue("linkTopoFuncCor", $oConn) ?>" maxlength="7" style="width: 50px;"> 
		<i>Default: 60px</i>
	   
	  </td>
	
	 <td>
	   <label>Cor do link de funcionalidades (Topo) - Quanto estiver ativo</label><br>
		  <input type="text" class="color" name="linkTopoFuncCorAtivo" value="<?= Parameters::getValue("linkTopoFuncCorAtivo", $oConn) ?>" maxlength="7" style="width: 50px;"> 
		<i>Default: 60px</i>
	   
	  </td>
	
    </tr>
	<tr>
	 <td>
	   <label>Tamanho do Nome dos itens nos gráficos (quantidade de caracteres)</label><br>
		  <input type="text"  name="tamanhoNomeItens" value="<?= Parameters::getValue("tamanhoNomeItens", $oConn) ?>" 
		  maxlength="4" style="width: 50px;"> 
		<i>Default: 130</i>
	   
	  </td>
	
    </tr>
	<tr>
	
	   <td colspan="2" align="right">
	   <input type="submit" class="botao" value="Salvar" >
	
	   </td>
	</tr>
</table>


</form>
</div>