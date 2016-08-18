<?php

require_once("persist/Parameters.php");

$acao  = request("acao");

if ( $acao == Util::$SAVE ){
	
	foreach($_POST as $key=>$value){
		
            if ( strpos(" ".$key,"prop_")) {
                
                $arp = explode("prop_", $key);
                
		Parameters::setValue($arp[1],$value, $oConn);
            }
	}
	
        if ( count($_FILES) > 0 && @$_FILES["file_logo"]["tmp_name"] != "" ){
				
				$arquivo = $_FILES["file_logo"];
				
				$pasta = realpath("../").DIRECTORY_SEPARATOR ."files".DIRECTORY_SEPARATOR."config";
				
                                
                                if ( !file_exists($pasta) ){
                                    @mkdir($pasta); 
                                }
                                
                                // print_r( $_FILES ); die(" -- ". $pasta );
				$sep = DIRECTORY_SEPARATOR;
				
				move_uploaded_file( $arquivo["tmp_name"], $pasta .$sep. $arquivo["name"]);
				
		                Parameters::setValue("termo_contrato_imagem", $arquivo["name"], $oConn);
                                
                                
			}
        
        
	$_SESSION["st_Mensagem"] = "Termo de uso salvo com sucesso!";
	
}
Util::mensagemCadastro(85);

$arrTexts = new ArrayList();

function showTextArea($code, $titulo, $style="width: 99%; height: 90px", $add_editor = true ){
    global $arrTexts;
    global $oConn;
    
    if ( $add_editor ){
    $arrTexts->add($code);
    }
    ?>
  
	   <label><?=$titulo?></label><br>
           <textarea name="prop_<?=$code?>" id="prop_<?=$code?>"  style="<?=$style?>" ><?= Parameters::getValue($code, $oConn) ?></textarea>
           
	

    <?
    
}
Util::mensagemCadastro();

?>
<form method="post" name="frm" enctype="multipart/form-data"
action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">

	  <input type="hidden" name="acao" value="<?php echo Util::$SAVE  ?>">
	  
	<input type="hidden" name="ispostback" value="1">

<div class="fieldBox">
<table cellpadding="0" cellspacing="0" style="width: 96%" class="tbcadastro">
    <tr> 
    <td colspan="2">
        <?  showTextArea("termo_contrato_preludio", "Termos de Uso - Introdução"); ?>
	    
	  </td>
	</tr>
        <tr>
              <td>
		       <label>Imagem</label>
			   <?php
                           $str_imagem = Parameters::getValue("termo_contrato_imagem", $oConn);
                           $src_imagem = constant("K_RAIZ_DOMINIO")."files/config/".$str_imagem;
                           if ( trim($str_imagem) != "" ){ ?>
	
                                        <img src="<?= K_RAIZ ?>images/delete.png"  border="0" title ="Remover Logo"  style="border:none; cursor:pointer" onclick="removeLogo(this)">
                                        <br>
                                        <img src="<?=$src_imagem?>" width="120" border="0"  style="border:none" id="mylogo">


                                                                <?php } ?>
                                        <input type="hidden" name="imagem1" value="<?= $str_imagem?>" ><br>
                                        <input type="file" name="file_logo" style="width: 300px" >

                                        <script type="text/javascript">
                                        function removeLogo( obj ){

                                                obj.style.display = "none";
                                                document.getElementById("mylogo").style.display = "none";
                                            document.forms[0].imagem1.value = "";

                                                alert("Salve o cadastro para confirmar a remoção da imagem!");
                                        }


                                        </script>
				
			
				</td>
              <td style="width: 48%">
        <?  showTextArea("termo_contrato_video", "URL do Vídeo / YouTube", "width: 99%; height: 50px", false); ?>
	  </td>
            
        </tr>
        
          <tr> 
    <td colspan="2">
        <?  showTextArea("termo_contrato_utilizacao", "A utilização do serviço"); ?>
	  
	  </td>
	</tr>
         <tr> 
    <td colspan="2">
        <?  showTextArea("termo_contrato_conteudo_usuario", "Conteúdo do Usuário"); ?>
	  
	  </td>
	</tr>
        
         <tr> 
    <td colspan="2">
        <?  showTextArea("termo_contrato_privacidade", "Privacidade"); ?>
	  
	  </td>
	</tr>
	<tr>
	
	   <td colspan="2" align="right">
	   <input type="button" class="botao" onclick="salvar()" value="Salvar" >
	
	   </td>
	</tr>
        
</table>
</div>
</form>
           
<script src="nicEdit.js" language="JavaScript" type="text/javascript"></script>
<script type="text/javascript">
function salvar(){
    
    var f = document.forms[0];
    f.acao.value = "SAVE";
    
    try{
    toggleArea1();
    }catch(Exp){
        
    }
    f.submit();
}    
    
    
 <?
 for( $i = 0; $i < $arrTexts->size(); $i++ ) { 
     
     $variavel = $arrTexts->get($i);
     ?>       
    var <?=$variavel?> = null;     
 <? } ?>    
function toggleArea1() {
    
     <?
 for( $i = 0; $i < $arrTexts->size(); $i++ ) { 
     
     $variavel = $arrTexts->get($i);
     ?>  
	if(!<?=$variavel?>) {
		<?=$variavel?> = new nicEditor({fullPanel : true}).panelInstance('prop_<?=$variavel?>',{hasPanel : true});
	} else {
		<?=$variavel?>.removeInstance('prop_<?=$variavel?>');
		<?=$variavel?> = null;
	}
 <? } ?>	
	
}

bkLib.onDomLoaded(function() { toggleArea1(); });
</script>
