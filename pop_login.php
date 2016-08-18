<?
 $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

 $acao = Util::request("acao");  //style='color: red; font-size: 14px'
 $fragmento_obrigatorio = ""; //" <span class='aviso'>*</span> ";

 
 $login_email = Util::request("login_email"); 
 $login_senha = Util::request("login_senha");

 $prefixo_login_cad_nome =""; $prefixo_login_cad_sobrenome = "";
 $prefixo_login_cad_email = ""; $prefixo_login_cad_senha = "";
 $prefixo_login_cad_confirmar_senha = "";

 $prefixo_login_email = "";
 $prefixo_login_senha = "";
  

 function testaLogin(&$bl_ok){
            global $login_email;
            global $login_senha;
            global $prefixo_login_email;
            global $prefixo_login_senha;
            global $fragmento_obrigatorio;
            global $msg;


            if ( trim($login_email) == ""){ 
                $prefixo_login_email = $fragmento_obrigatorio;    $msg = "Informe o seu email!";                
                $bl_ok = false; return "";
            }

            if ( trim($login_senha) == ""){ 
                $prefixo_login_senha = $fragmento_obrigatorio;    $msg = "Informe sua senha!";                
                $bl_ok = false; return "";
            }

            $bl_ok =true;
 }
        
$msg = "";      
if ( $acao == "login" ){
         $bl_ok = false;
         testaLogin($bl_ok);
         
         if ( $bl_ok ){
             
             
               $usuario = Usuario::getUserByEmail($oConn, trim($login_email));
                                //print_r( $usuario);
                        if (! $usuario["id"]){

                            $prefixo_login_email = $fragmento_obrigatorio;
                            $msg = "Não há um usuário cadastrado para este e-mail!";
                        }else{

                                     //echo ( $usuario["senha"] . " ------- ");
                          if (! $usuario["verificado_email"] ){
                                                    Usuario::enviaEmailVerificacao($oConn, $usuario["id"]);

                                                    $prefixo_login_email = $fragmento_obrigatorio;
                                                    $msg = "Já existe um usuário cadastrado com o e-mail ". 
                                                    $login_email. ", porém não está ativo. É necessário clicar no link enviado no e-mail de confirmação. ";
                                                    
                                      }else{//Ele existe e já está validado.. vamos testar a senha dele.

                                          $bol_sub_ok = true;

                                          if ( $usuario["senha"] == "" ){

                                            $bol_sub_ok = false;
                                            $prefixo_login_email = $fragmento_obrigatorio;
                                            $msg = "Já existe um usuário cadastrado com o e-mail ". 
                                            $login_email. ", porém não possui senha. É necessário logar com o botão \"Login ";

                                            if ( $usuario["identificacao_facebook"] != "" )
                                             $msg .= " através do Facebook\"";
                                         else  if ( $usuario["identificacao_google"] != "" )
                                             $msg .= " através do Google\"";

                                         else if ( $usuario["identificacao_microsoft"] != "" )
                                             $msg .= " através do Hotmail\"";
                                     }
                                     if ( $bol_sub_ok && $usuario["senha"] != md5($login_senha) ){

                                       $msg = "Senha inválida!";
                                       $bol_sub_ok = false;
                                       $prefixo_login_senha = $fragmento_obrigatorio;

                                   }

                                              if ( $bol_sub_ok ){ //Login Correto.

                                                  //session_start();
                                                  SessionFacade::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"], "cliente",
                                                      "");

                                                 // $_SESSION["st_Mensagem"] = "Login realizado com sucesso!|Clique abaixo para acessar o portal do Poss&iacute;vel Acordo";

                                                 // SessionCliente::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"],"cliente", 
                                                  // $usuario["imagem"]);

                                                 // SessionCliente::setMensagem( "Login realizado com sucesso!|Clique abaixo para acessar o portal do Poss&iacute;vel Acordo");
                                                  //die("pare");
                                                  //header("Location: mensagem.php");
                                                  die("<script>"
                                                      . "if ( parent != null ) { "
                                                      . "parent.document.location.href='".K_URL_PAINEL."'; } else {  document.location.href='../mensagem/mensagem.php';   } </script> ");

                                              }





                                          }               

                                      }
             
             
         }
         if ( $msg != "" ){
                                      $_SESSION["st_Mensagem"] = $msg;
                                      $_SESSION["st_MensagemClass"] = "alert-warning";
         }
}
        

?>        


<div class="container">
    <form method="post" name="frmLogin">
        
        <input type="hidden" name="acao" >
        
	<div class="cboxIframe pop_login">
               <? Util::mensagemCadastro(); ?>
		<div class="column6">
			<h1>Login</h1>
			<div class="form-group">
				<label>Entre com sua rede social</label>
			</div>
			<button class="btn-facebook">Login com o Facebook</button>
			<button class="btn-google">Login com o Google</button>

			<div class="form-group">
				<label>Ou com seus dados cadastrados</label>
				<input type="text" name="login_email" placeHolder="E-mail" value="<?= Util::request("login_email") ?>" class="form-control email" ><?= $prefixo_login_email ?>
				<input type="password" class="form-control senha"  name="login_senha" placeHolder="Senha" autocomplete="off" ><?= $prefixo_login_senha ?><?= $prefixo_login_senha ?>
				
                               <input type="button" name="btLogin_Login" value="Entrar" class="btn btn-full" onclick="fn_chamalogin(this)"/>
			</div>

                        <p>Não tem uma conta? <a  href="pop_index.php?pag=cadastro">Cadastre-se</a></p>
		</div>

	</div><!-- /cboxIframe -->
    </form>
</div><!-- /container -->
<?
    $oConn->disconnect();
?>
<script type="text/javascript">
	$(document).ready(function () {
		parent.$.fn.colorbox.resize( {
			innerWidth: 490,
			innerHeight: 510 
		});
	});
        
  function fn_chamalogin( obj ){

        var f = document.frmLogin;
    
    
        f.acao.value = "login";
        f.submit();    
    
    }
        
</script>