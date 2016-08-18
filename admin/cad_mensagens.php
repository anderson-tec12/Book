<?php

require_once("persist/Parameters.php");
require_once("inc_profissional.php");
require_once("inc_usuario.php");

$acao  = request("acao");
$codigo  = request("codigo");
$email  = request("email");

$G_email_path = ".";

if ( $acao == "testar" && $email != "" && $codigo != ""){
    
    if ( $codigo == "msg_cadastro_email"){
        
        $usuario = Usuario::getUserByEmail($oConn, $email); // connAccess::fastOne($oConn, "usuario", " id = " . $id);

        $nomeUsuario = Util::acento_para_html($usuario["nome"]);
        $emailUsuario = $usuario["email"];
        $codigoVerificacao = $usuario["codigo_verificacao"];
        $urlBase = constant("url_base") . "";
        $idUsuario = $usuario["id"];
        
        $msConfirmacaoCadastro = new MSConfirmacaoCadastro($nomeUsuario, 
                $emailUsuario, $codigoVerificacao, $idUsuario, $urlBase);

        $enviadorNewsletter = new EnviadorNewsletter($emailUsuario, $msConfirmacaoCadastro);
        
        $enviadorNewsletter->setaCodigoMensagemPadrao("msg_cadastro_email", 
                "Você já pode começar a usar o 1Acordo.");
        
        $enviadorNewsletter->enviar();
        
        echo("Enviado email de teste");
        
    }
    
}
if ( $acao == "padrao"){
    
      
                    $corpo_email = profissional::getMensagemPadrao("msg_profissional_email_aprovado","Entretando, para começar a usar será necessário"
                            . " verificar seu e-mail clicando no botão abaixo.");
                    
                    
                     $corpo_email = profissional::getMensagemPadrao("msg_profissional_email_aprovado_completo","Como este e-mail já havia sido verificado antes, "
                            . " você já pode acessar o painel de profissional imediatamente.");
                    
    
                     $corpo_email = profissional::getMensagemPadrao("msg_profissional_email","Seu cadastro foi recebido com sucesso. Por favor aguarde até a sua aprovação, você será avisado por e-mail.");
    
                  $corpo_email = profissional::getMensagemPadrao("msg_cadastro_email", 
                                                  "Você já pode começar a usar o 1Acordo." );
    
                   //  $corpo_email = profissional::getMensagemPadrao("msg_profissional_email","Seu cadastro foi recebido com sucesso. Por favor aguarde até a sua aprovação, você será avisado por e-mail.");
    
    
                     echo 'indicado o padrão..';
}

if ( $acao == Util::$SAVE ){
	
	foreach($_POST as $key=>$value){
		
            if ( strpos(" ".$key,"prop_")) {
                
                $arp = explode("prop_", $key);
                
		Parameters::setValue($arp[1],$value, $oConn);
            }
	}
	
        if ( false ){
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
        }
        
        
	$_SESSION["st_Mensagem"] = "Mensagens salvas com sucesso!";
	
}
Util::mensagemCadastro(85);

$arrTexts = new ArrayList();

function showTitulo($titulo ){
      ?>
    <tr> 
        <td colspan="2">
            <h3><?=$titulo?></h3>
        </td>
    </tr> 
   <? 
}

function showTextArea($code, $titulo, $style="width: 99%; height: 120px", $add_editor = true ){
    global $arrTexts;
    global $oConn;
    
    if ( $add_editor ){
    $arrTexts->add($code);
    }
    ?>
    <tr> 
        <td colspan="2">
            
            
        
	   <label><?=$titulo?></label><br>
           <textarea name="prop_<?=$code?>" id="prop_<?=$code?>"  style="<?=$style?>" ><?= Parameters::getValue($code, $oConn) ?></textarea>
           
        </td>
    </tr>
	

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
    <h3>Email do Administrador do Um Acordo</h3>
    <input type="text" name="prop_email_administrador"
               value="<?= Parameters::getValue("email_administrador", $oConn) ?>" 
               maxlength="300"
               style="width: 300px;" >
    
    <br>
    <h2>Mensagens dos emails</h2>
    
    <i>{nome} - Nome do usuário</i>
        <? showTitulo("Cadastro próprio do Usuário") ?>
    <tr>
	
	   <td colspan="2" align="right">
	   <input type="button" class="botao" onclick="salvar()" value="Salvar" >
	
	   </td>
	</tr>
    
        <?  showTextArea("msg_cadastro_email", "Ao criar o cadastro"); ?>
	<?  showTextArea("msg_cadastro_ativado_email", "Após o usuário validar o cadastro"); ?>
    
        <? showTitulo("Redes Sociais") ?>
        <?  showTextArea("msg_cadastro_alterar_senha", "Mensagem que o usuário deve receber ao alterar senha"); ?>
	
        
	<? showTitulo("Convidado") ?>
        <?  showTextArea("msg_convidado_email", "Mensagem que o convidado deve receber por e-mail"); ?>
	
	<? showTitulo("Profissional") ?>
        <?  showTextArea("msg_profissional_email", "Mensagem que o profissional deve receber após se cadastrar"); ?>
       <?  showTextArea("msg_profissional_email_aprovado", "Quando o profissional for aprovado - Mas ainda não está com seu e-mail validado."); ?>
       <?  showTextArea("msg_profissional_email_aprovado_completo", "Quando o profissional for aprovado e já possuia um email validado."); ?>
    
    
    
	<? showTitulo("Guia") ?>
        <?  showTextArea("msg_guia_download", "Mensagem para download do guia"); ?>
    
	<tr>
	
	   <td colspan="2" align="right">
	   <input type="button" class="botao" onclick="salvar()" value="Salvar" >
	
	   </td>
	</tr>
        <tr>
            <td>
                <input type="text" name="email" placeholder="Informe um email de usuário para testare" 
                       value="<?=Util::request("email")?>" style="width: 200px">
                <select name="codigo">
                         <?Util::populaCombo("msg_cadastro_email", "Ao criar o cadastro", Util::request("codigo")); ?>
                         <?//Util::populaCombo("msg_cadastro_ativado_email", "Após o usuário validar o cadastro", Util::request("codigo")); ?>
                </select>
                <input type="button" value="Testar" class="botao"  onclick="testar_email()">
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
   // toggleArea1();
    }catch(Exp){
        
    }
    f.submit();
}    
    
    
    function testar_email(){
        
        
    var f = document.forms[0];
    f.acao.value = "testar";
        f.submit();
    }
   
</script>
