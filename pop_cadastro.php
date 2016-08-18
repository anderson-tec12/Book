<?php 



 $acao = Util::request("acao");  //style='color: red; font-size: 14px'
 $fragmento_obrigatorio = " <span class='aviso'>*</span> ";

 $login_cad_nome = Util::request("nome_completo"); 
 $login_cad_email = Util::request("email"); 
 $login_cad_senha = Util::request("senha"); 
 $login_cad_confirmar_senha = Util::request("confirmar_senha"); 
 
    $prefixo_login_cad_nome = ""; 
    $prefixo_login_cad_sobrenome  = ""; 
    $prefixo_login_cad_email = "";  
    $prefixo_login_cad_senha  = ""; 
    $prefixo_login_cad_confirmar_senha = ""; 
 
    $msg = "";
 
 
 if ( $acao == "cadastro" ){

    $bl_ok = true;

    testaCadastro( $bl_ok );

    if ( $bl_ok ){

        $usuario = Usuario::getUserByEmail($oConn, trim($login_cad_email));

        if (!$usuario["id"]){
            $usuario["nome"] = $login_cad_nome; 
           // $usuario["sobrenome"] = $login_cad_sobrenome; 
            $usuario["nome_completo"] = $login_cad_nome;
            $usuario["data_cadastro"] = date("Y-m-d");              
            $usuario["email"] = $login_cad_email;         
            $usuario["senha"] = md5($login_cad_senha);
            $usuario["verificado_email"] = 0;
            $usuario["perfil_acesso"] = "CLI";
            

            connAccess::nullBlankColumns($usuario);
            $usuario["id"] = connAccess::Insert($oConn, $usuario, "usuario", "id");

            
             $usuario["codigo_verificacao"] = Usuario::getCodigoVerificacaoUser( $usuario );
             connAccess::nullBlankColumns($usuario);
             connAccess::Update($oConn, $usuario, "usuario", "id");
            
            $G_email_path = realpath(".");
            
            $caminho = realpath(".") . DIRECTORY_SEPARATOR . "admin". DIRECTORY_SEPARATOR. "login";
            $GLOBALS["caminho_path_html"] = $caminho;
            Usuario::enviaEmailVerificacao($oConn, $usuario["id"], $caminho );

            $txt = "Um e-mail de confirmação foi enviado para " . $usuario["email"]. ", é necessário
            ativar a sua conta através do link enviado por e-mail.";
            
             $txt = "Enviamos uma mensagem para seu e-mail (".$usuario["email"].").
                 Basta clicar no botão de acesso seguro que vem nesta mensagem e pronto! Você já está cadastrado 
                 e pode usar. <br><br>
                 Se quiser voltar para nossa página inicial, clique no botão abaixo.";

            
            $msg_dados = "Obrigado por se cadastrar!|".$txt."";

            $_SESSION["st_Mensagem"] = $msg_dados;

            $oConn->disconnect();

                            //header("Location: ../mensagem/mensagem.php");


            die("<script>"
             . "if ( parent != null ) { "
             . "parent.document.location.href='mensagem/mensagem.php'; } else {  document.location.href='mensagem/mensagem.php';   } </script> ");

            die("");
        }else{

            if (! $usuario["verificado_email"] ){
               Usuario::enviaEmailVerificacao($oConn, $usuario["id"]);

               $prefixo_login_cad_email = $fragmento_obrigatorio;
               $msg = "Já existe um usuário cadastrado com o e-mail ". 
               $login_cad_email. " - porém não está ativo. É necessário clicar no link enviado no e-mail de confirmação. ";

           }else{
            $prefixo_login_cad_email = $fragmento_obrigatorio;
            $msg = "Já existe um usuário cadastrado com o e-mail ". 
            $login_cad_email. " - utilize a opção de \"Lembrar Senha\" ";
        }

    }
}

}




        function testaCadastro(&$bl_ok){
            global $login_cad_nome;
            global $login_cad_sobrenome;
            global $login_cad_email;
            global $login_cad_senha;
            global $login_cad_confirmar_senha;
            global $fragmento_obrigatorio;
            global $msg;

            global $prefixo_login_cad_nome ; 
            global $prefixo_login_cad_sobrenome;
            global $prefixo_login_cad_email; global $prefixo_login_cad_senha;
            global $prefixo_login_cad_confirmar_senha;


            if ( trim($login_cad_nome) == ""){ 
                $prefixo_login_cad_nome = $fragmento_obrigatorio;    $msg = "Informe o nome!";                
                $bl_ok = false; return "";
            }

            if ( trim($login_cad_email) == ""){
                $prefixo_login_cad_email = $fragmento_obrigatorio;  
                $msg = "Informe o e-mail!";      $bl_ok = false;      
                return "";
            }else{


            }

            if ( ! strpos( trim($login_cad_email), "@") || !strpos( trim($login_cad_email), ".")  ) {
                $prefixo_login_cad_email = $fragmento_obrigatorio;  
                $msg = "Email inválido!";      $bl_ok = false;      
                return "";
            }

            if ( trim($login_cad_senha) == ""){
                $login_cad_senha = $fragmento_obrigatorio; 
                $msg = "Informe a senha!";   $bl_ok = false;  
                return "";
            }
            if ( strlen( trim($login_cad_senha)) < 4){
                $login_cad_senha = $fragmento_obrigatorio; 
                $msg = "A senha deve ter pelo menos 4 caracteres!";    
                return "";
            }
            if ( trim($login_cad_confirmar_senha) == ""){
                $login_cad_confirmar_senha = $fragmento_obrigatorio; 
                $msg = "Informe a confirmação da senha!";  $bl_ok = false;  
                return "";
            }
            if ( trim($login_cad_confirmar_senha) !=trim($login_cad_senha)){
                $login_cad_senha = $fragmento_obrigatorio; 
                $msg = "Senha e confirmação não conferem!";  $bl_ok = false; 
                return "";
            }


        }

?>
<div class="container">
    <form method="post" name="frm" action="pop_index.php">
        
	<div class="cboxIframe pop_login">

		<div class="column6">
                    
                        <? if ( $msg != ""){ ?>
                                <div id="div_aviso_2"
                                class="mensagem_aviso">
                                * <?= $msg ?>
                            </div>
                            <? } ?> 
                    
			<h1>Cadastre-se</h1>
			<div class="form-group">
				<label>Com sua rede social</label>
			</div>
			<button class="btn-facebook">Criar com o Facebook</button>
			<button class="btn-google">Criar com o Google</button>

			<div class="form-group">
				<label>Ou preencha seus dados abaixo</label>
                                
				<input type="text" name="nome_completo" value="<?= $login_cad_nome ?>" class="form-control" placeholder="Nome completo"><?=$prefixo_login_cad_nome?>
				<input type="email" name="email" class="form-control" value="<?= $login_cad_email ?>" placeholder="E-mail"><?=$prefixo_login_cad_email?>
				<input type="password" name="senha" class="form-control" autocomplete="off" placeholder="Senha"><?=$prefixo_login_cad_senha?>
				<input type="password" name="confirmar_senha" class="form-control" autocomplete="off" placeholder="Confirmar senha"><?=$prefixo_login_cad_confirmar_senha?>

                                <input type="hidden" name="acao" id="acao" >
                                <input type="hidden" name="pag" id="pag" value="<?=Util::request("pag") ?>" >
				<div class="checkbox">
					<label>
						<input name="concorda" type="checkbox" value="1"
                                                       <?= Util::ischecked(Util::request("concorda") == "1") ?>
                                                       
                                                       >Ao efetuar o cadastro você concorda com os <a href="#" target="blank">Termos de Uso.</a>
					</label>
				</div>

                                <input type="button" class="btn btn-full" value="Cadastrar" onclick="cadastrar()">
			</div>

			<p>Já é cadastrado? <a class="iframe-modal-small" href="">Entre</a></p>
		</div>

	</div><!-- /cboxIframe -->
    </form>
</div><!-- /container -->

<script type="text/javascript">
	$(document).ready(function () {
		parent.$.fn.colorbox.resize( {
			innerWidth: 490,
			innerHeight: 670 
		});
	});
        
        
function isVazio(obj, mensagem, testaZero ){
        if (obj != undefined){

          if (obj.value=='' || ( testaZero!= null && obj.value=='0'  ) ){
              alert(mensagem);  
              try
              {
                obj.focus();
            } catch (ex) { }

            return true;
        }
    }
    return false;
}

function cadastrar(){
     var f = document.forms[0];

        if ( isVazio( f.nome_completo,"Informe o seu nome!"))
            return;                

     

        if ( isVazio( f.email,"Informe o seu e-mail!"))
            return;

        if ( isVazio( f.senha,"Informe uma senha!"))
            return;

        if ( isVazio( f.confirmar_senha,"Confirme a senha!"))
            return;
        
        
         if ( f.senha.value != f.confirmar_senha.value){

            alert("Senha e confirmação não conferem!");
            f.confirmar_senha.value = "";
            f.confirmar_senha.focus();
            return;
        }
        
        if (! f.concorda.checked ){
            
            alert("É necessário concordar com os termos de uso.");
            return;
        }

        f.acao.value = "cadastro";
        f.submit();
        

    }  
    
    
    
    
</script>