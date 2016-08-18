<?php

require_once("persist/Parameters.php");
require_once("inc_profissional.php");
require_once("inc_usuario.php");
require_once("painel/newsletter/mensagem_sistema/ms_cabecalho.php");
require_once("painel/newsletter/mensagem_sistema/ms_rodape.php");

$acao  = request("acao");
$codigo  = request("codigo");
$email  = request("email");

$G_email_path = "."; 

if ( $acao == "testar" && $email != "" && $codigo != ""){
    echo("<b>Código: </b>". $codigo );
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
        
        $enviadorNewsletter->titulo_email = utf8_decode("Confirmação de e-mail");
        $enviadorNewsletter->setaCodigoMensagemPadrao("msg_cadastro_email", 
                "Você já pode começar a usar o 1Acordo.");
        
        $enviadorNewsletter->enviar();
        
        echo("Enviado email de teste");
        
    }
    if ( $codigo == "msg_profissional_email" ||
            $codigo == "msg_profissional_email_aprovado_completo" ||
            $codigo == "msg_profissional_email_aprovado"
            ){
        
             $profissional = profissional::getIDByEmail($email);
                if ( $codigo == "msg_profissional_email" ){
                            profissional::enviaEmailCadastroRealizado($oConn, $profissional["id"],
                                    "", "", "");
                }
          
                 if ( $codigo == "msg_profissional_email_aprovado_completo"  ){  
                    profissional::enviaEmailStatus(1, $profissional["id"], 1);
                 }
                 
                 if ( $codigo == "msg_profissional_email_aprovado"){
                     
                    profissional::enviaEmailStatus(1, $profissional["id"], 0);
                     
                 }
        
        
        
        echo("Enviado email de teste para o profissional: ". $profissional["nome"]);
    }
    
    
    if ( $codigo == "msg_guia_download"){
        
        
        $caminho = realpath("."). DIRECTORY_SEPARATOR."template_email".
               DIRECTORY_SEPARATOR. "html_guia_home.html";
    
                            //

                            //echo($caminho);
                            if (file_exists($caminho)){
                                $cabecalho = "";
                                  ob_start();
                             $o_ms_cabecalho = new MSCabecalho("1Acordo");
                             $o_ms_cabecalho->printEmail();
                             //ob_clean();

                                 echo("{msg_html}");
                                 $rodape = "";
                                 $o_ms_rodape = new MSRodape();
                                 $o_ms_rodape->printEmail();
                                // $rodape = utf8_decode(  ob_get_contents());
                                // ob_clean();


                                $msg_html =   ob_get_contents() ;
                                ob_end_clean();

                                $msg_html = Util::devolve_acentos( $msg_html );
                                 $msg_arquivo = Util::lerArquivo($caminho);

                                 $mensagem_email = Usuario::getMensagemPadrao("msg_guia_download", "Junto com seu Guia, "
                                         . "segue um link de acesso para um teste gratuito.");

                                 $msg_html = str_replace("{mensagem_email}", 
                                         Util::acento_para_html(  $mensagem_email ),
                                         $msg_html);
                                 
                                 
                                 $msg_arquivo = str_replace("{mensagem_email}", 
                                         Util::acento_para_html(  $mensagem_email ),
                                         $msg_arquivo);

                                 $msg = str_replace("{msg_html}", $msg_arquivo , $msg_html);
                                 $msg = str_replace("{dominio}", K_DOMINIO, $msg);


                                 // die("EMAIL==> " .  $msg );



                                 $hash = md5("1acordo.lnk.".$email);

                                 $link = K_DOMINIO."/sistema/login/verifica.php?em=".$email."&cod=".$hash."&tp=guia_link";

                                 $msg = str_replace("{link}", $link, $msg);
                                 $msg = str_replace("{K_DOMINIO}", K_DOMINIO, $msg);

                                  $msg .= $rodape;
                                  $msg_retorno = Util::enviarEmail($email,
                                          utf8_decode("Receba o guia de Ambiente & Ferramentas 1ACORDO"), $msg, "1Acordo");
       
                                  echo("Enviado email com Guia");

                            }
    }
}
if ( $acao == "padrao"){
    
      
                    $corpo_email = profissional::getMensagemPadrao("msg_profissional_email_aprovado",
                            "Entretando, para começar a usar será necessário"
                            . " verificar seu e-mail clicando no botão abaixo.");
                    
                    
                     $corpo_email = profissional::getMensagemPadrao("msg_profissional_email_aprovado_completo",
                             "Como este e-mail já havia sido verificado antes, "
                            . " você já pode acessar o painel de profissional imediatamente.");
                    
    
                     $corpo_email = profissional::getMensagemPadrao("msg_profissional_email","Seu cadastro foi recebido com sucesso. Por favor aguarde até a sua aprovação, você será avisado por e-mail.");
    
                  $corpo_email = profissional::getMensagemPadrao("msg_cadastro_email", 
                                                  "Você já pode começar a usar o 1Acordo." );
    
                  
                  $corpo_email = profissional::getMensagemPadrao("msg_guia_download", "Junto com seu Guia, "
                 . "segue um link de acesso para um teste gratuito.");
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
    
    
    <i>{nome} - Nome do usuário</i>
        <? showTitulo("Cadastro próprio do Usuário") ?>
    <tr>
	
	   <td colspan="2" align="right">
	   <input type="button" class="botao" onclick="salvar()" value="Salvar" >
	
	   </td>
	</tr>
    
        <?  showTextArea("msg_cadastro_email", "Ao criar o cadastro (Email)"); ?>
	<?  showTextArea("msg_cadastro_ativado_email", 
                "Após o usuário validar o cadastro (Retorno do Email)"); ?>
    
        <? showTitulo("Redes Sociais") ?>
        <?  showTextArea("msg_cadastro_alterar_senha", "Mensagem que o usuário deve receber ao alterar senha (Via Email)"); ?>
	
        
	<? showTitulo("Convidado") ?>
        <?  showTextArea("msg_convidado_email", "Mensagem que o convidado deve receber por e-mail (Via Email)"); ?>
	
	<? showTitulo("Profissional") ?>
        <?  showTextArea("msg_profissional_email", "Mensagem que o profissional deve receber após se cadastrar (Via Email)"); ?>
       <?  showTextArea("msg_profissional_email_aprovado", "Quando esta aprovado porém aguardando verificação do usuário (Via Email)"); ?>
       <?  showTextArea("msg_profissional_email_aprovado_completo", "Quando o profissional for aprovado e já possuia um usuário validado (Via Email)"); ?>
    
    
    
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
                         <?Util::populaCombo("msg_profissional_email", "Cadastro do profissional - Iniciado", Util::request("codigo")); ?>
                         <?Util::populaCombo("msg_profissional_email_aprovado", "Cadastro do profissional - Aprovado porém aguardando verificação do usuário", Util::request("codigo")); ?>
                         <?Util::populaCombo("msg_profissional_email_aprovado_completo", "Cadastro do profissional - Aprovado e completo", Util::request("codigo")); ?>
                                  <?Util::populaCombo("msg_guia_download", "Guia do UmAcordo - Download", Util::request("codigo")); ?>
    
                    
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
