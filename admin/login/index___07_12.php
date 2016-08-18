<?php 

session_start();

require_once("../library/Util.php");
require_once("../library/SessionFacade.php");
require_once("../library/SessionCliente.php");
require_once("../oAuth/config.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");


$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

 $acao = Util::request("acao");  //style='color: red; font-size: 14px'
 $fragmento_obrigatorio = " <span class='aviso'>*</span> ";

 $login_cad_nome = Util::request("login_cad_nome"); 
 $login_cad_sobrenome = Util::request("login_cad_sobrenome"); 
 $login_cad_email = Util::request("login_cad_email"); 
 $login_cad_senha = Util::request("login_cad_senha"); 
 $login_cad_confirmar_senha = Util::request("login_cad_confirmar_senha"); 
 $login_email = Util::request("login_email"); 
 $login_senha = Util::request("login_senha");

 $prefixo_login_cad_nome =""; $prefixo_login_cad_sobrenome = "";
 $prefixo_login_cad_email = ""; $prefixo_login_cad_senha = "";
 $prefixo_login_cad_confirmar_senha = "";

 $prefixo_login_email = "";
 $prefixo_login_senha = "";

 $msg = "";

 if ( $acao == "cadastro" ){

    $bl_ok = true;

    testaCadastro( $bl_ok );

    if ( $bl_ok ){

        $usuario = Usuario::getUserByEmail($oConn, trim($login_cad_email));

        if (!$usuario["id"]){
            $usuario["nome"] = $login_cad_nome; 
            $usuario["sobrenome"] = $login_cad_sobrenome; 
            $usuario["nome_completo"] = $login_cad_nome. " ". $login_cad_sobrenome;
            $usuario["data_cadastro"] = date("Y-m-d");              
            $usuario["email"] = $login_cad_email;         
            $usuario["senha"] = md5($login_cad_senha);
            $usuario["verificado_email"] = 0;

            connAccess::nullBlankColumns($usuario);
            $usuario["id"] = connAccess::Insert($oConn, $usuario, "usuario", "id");

            Usuario::enviaEmailVerificacao($oConn, $usuario["id"]);

            $msg_dados = "Obrigado por se cadastrar.|Um e-mail de confirmação foi enviado para " . $usuario["email"]. ", é necessário
            ativar a sua conta através do link enviado por e-mail.|Portal,/portal";

            $_SESSION["st_Mensagem"] = $msg_dados;

            $oConn->disconnect();

                            //header("Location: ../mensagem/mensagem.php");


            die("<script>"
               . "if ( parent != null ) { "
               . "parent.document.location.href='../mensagem/mensagem.php'; } else {  document.location.href='../mensagem/mensagem.php';   } </script> ");

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
if ( $acao == "login" ){

   testaLogin($bl_ok);

   SessionCliente::setValorSessao("include","");
   SessionCliente::setMensagem(""); 
   SessionCliente::setValorSessao("ticket_id","");


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
                        $msg .= " com o Facebook\"";
                    else  if ( $usuario["identificacao_google"] != "" )
                        $msg .= " com o Google\"";

                    else if ( $usuario["identificacao_microsoft"] != "" )
                        $msg .= " com o Hotmail\"";
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

                           SessionCliente::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"],"cliente", 
                              $usuario["imagem"]);

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

       }
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

        if ( trim($login_cad_sobrenome) == ""){
            $prefixo_login_cad_sobrenome = $fragmento_obrigatorio;  
            $msg = "Informe o sobrenome!";  $bl_ok = false;
            return "";
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
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta charset="UTF-8">

        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
        <link href="/sistema/css/padrao.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/cadastro_usuario.css?t=3" rel="stylesheet" type="text/css" media="all" />


    </head>
    <body>

        <form method="post" name="frmLogin"  action="index.php" id="tabela">
            <input type="hidden" name="acao" >

            
            <div id="div_login_botoes_grande">
                <ul>

                    <li>                
                        <input type="button" name="btLoginFacebookGrande" value="Criar conta com o Facebook" class="login_botao_facebook" onclick="fn_chamalogin(this)"/>
                    </li>

                    <li>                
                        <input type="button" name="btLoginGoogleGrande" value="Criar conta com o Google" class="login_botao_google" onclick="fn_chamalogin(this)"/>
                    </li>

                    <!--<li>                
                        <input type="button" name="btLoginMicrosoftGrande" value="Criar conta com o Hotmail" class="login_botao_microsoft" onclick="fn_chamalogin(this)"/>
                    </li>-->
                    <div class="txt">ou</div>

                    <li>                
                        <input type="button" name="btLoginEmailGrande" value="Criar conta usando Email" class="login_botao_email" onclick="fn_chamalogin(this)" />
                    </li>   

                    <li style="display:none">                
                        <input type="button" name="btLoginTwitterGrande" value="Criar conta com o Twitter" class="login_botao_twitter_grande" onclick="fn_chamalogin(this)"/>
                    </li>

                </ul>

            </div>

            <div id="div_login_cadastro" class="login_box_cadastro" > 

                <div class="login_botoes_pequeno" id="div_login_botoes_pequeno" style="display:none">
                   <ul>

                    <li>                
                        <input type="button" name="btLoginFacebookPequeno" value="Criar conta com o Facebook" class="login_botao_facebook" onclick="fn_chamalogin(this)"/>
                    </li>

                    <li>                
                        <input type="button" name="btLoginGooglePequeno" value="Criar conta com o Google" class="login_botao_google" onclick="fn_chamalogin(this)"/>
                    </li>

                    <!--<li>                
                        <input type="button" name="btLoginMicrosoftPequeno" value="Criar conta com o Hotmail" class="login_botao_microsoft" onclick="fn_chamalogin(this)"/>
                    </li>-->

                    <li  style="display:none">                
                        <input type="button" name="btLoginTwitterPequeno" value="Criar conta com o Twitter" class="login_botao_twitter" onclick="fn_chamalogin(this)"/>
                    </li>

                </ul>
            </div>


            <div class="login_box_cadastro_campos" id="div_login_campos_cadastro" style="display:none">
                
                <!--<div class="login_box_cadastro_titulo">Cadastrar usando Email</div>-->
                <? if ( $msg != ""){ ?>
                <div id="div_aviso_2"
                class="mensagem_aviso">
                * <?= $msg ?>
            </div>
            <? } ?>  
            <table>
                <tr>
                    <td>
                        <input type="text" name="login_cad_nome" placeHolder="Primeiro Nome"  class="input_text" value="<?=$login_cad_nome?>" /><?=$prefixo_login_cad_nome?>
                    </td>
                </tr>
                <tr>
                   <td>
                    <input type="text" name="login_cad_sobrenome" placeHolder="Sobrenome"  class="input_text" value="<?=$login_cad_sobrenome?>"/><?=$prefixo_login_cad_sobrenome?>
                </td>
            </tr>
            <tr>    

               <td>
                <input type="text" name="login_cad_email" placeHolder="E-mail"  class="input_text" value="<?=$login_cad_email?>"/>
                <?=$prefixo_login_cad_email?>
            </td>
        </tr>
        <tr>   
          <td>
            <input type="password" name="login_cad_senha" placeHolder="Senha" autocomplete="off"  class="input_text"  />
            <?=$prefixo_login_cad_senha?>
        </td>
    </tr>
    <tr>
      <td>
        <input type="password" name="login_cad_confirmar_senha" placeHolder="Confirmar Senha"  autocomplete="off" class="input_text" />
        <?=$prefixo_login_cad_confirmar_senha?>
    </td>
</tr>
<tr>
    <td>

        <input type="button" name="btLoginCadastroEmail" value="Cadastrar" class="button" onclick="fn_chamalogin(this)"/>
    </td>
</tr>

</table>




</div>

<div class="login_box_logon" id="div_login_logon" style="display:none">

    <div class="txt">ou</div>
    <? if ( $msg != ""){ ?>
    <div  id="div_aviso_1" class="mensagem_aviso">
     * <?= $msg ?>
 </div>
 <? } ?>  

 <table>

  <tr>    

   <td>
    <input type="text" name="login_email" placeHolder="E-mail"  class="input_text" 
    value="<?= Util::request("login_email") ?>"
    />
    <?= $prefixo_login_email ?>
</td>
</tr>

<tr>   
  <td>
    <input type="password" name="login_senha" placeHolder="Senha" autocomplete="off"  class="input_text"  />
    <?= $prefixo_login_senha ?>
</td>
</tr>
<tr>
  <td>

      <label class="lembrar_senha">
          <input type="checkbox" name="remember_me" value="true">Lembrar
      </label>

      <a href="#" class="esqueceu_senha">Esqueceu a senha?</a>

  </tr>



  <tr>
    <td>

        <input type="button" name="btLogin_Login" value="Entrar" class="button" onclick="fn_chamalogin(this)"/>
    </td>
</tr>
</table>

</div>
</div>


<div class="login_termo_uso">
    <p>Ao efetuar o cadastro você concorda com os <a href="#">Termos de Serviço</a> do possível acordo e a <a href="#">Política de Privacidade</a>.</p>   
</div>

<div class="linha"></div>
<div id="login_rodape_fazlogin" class="login_rodape">
    <p>Já tem o cadastro? <a id="a_faz_login"  name="a_faz_login" onclick="fn_chamalogin(this)" href="#">Faça o Login</a></p>

</div>
<div id="login_rodape_cadastro"  class="login_rodape" style="display:none">
    <p>Não tem uma conta? <a id="a_faz_login"  name="a_faz_cadastro" onclick="fn_chamalogin(this)" href="#">Cadastre-se</a></p>

</div>
<? if ( Util::request("resize") == "1"){ ?>   
<!-- Biblioteca -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- Modal -->
<script src="js/jquery.modal.colorbox.min.js"></script>
<? } ?>

<script type="text/javascript">

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
function fn_chamalogin( obj ){

    var f = document.frmLogin;

    var div_login_botoes_grande   = document.getElementById("div_login_botoes_grande");
    var div_login_botoes_pequeno        = document.getElementById("div_login_botoes_pequeno");
    var div_login_campos_cadastro = document.getElementById("div_login_campos_cadastro");
    var div_login_logon           = document.getElementById("div_login_logon");

    var login_rodape_fazlogin = document.getElementById("login_rodape_fazlogin"); 
    var login_rodape_cadastro = document.getElementById("login_rodape_cadastro"); 

    if ( obj.name.indexOf("btLoginCadastroEmail") > -1){


        if ( isVazio( f.login_cad_nome,"Informe o seu nome!"))
            return;                

        if ( isVazio( f.login_cad_sobrenome,"Informe o seu sobrenome!"))
            return;

        if ( isVazio( f.login_cad_email,"Informe o seu e-mail!"))
            return;

        if ( isVazio( f.login_cad_senha,"Informe uma senha!"))
            return;


        if ( isVazio( f.login_cad_confirmar_senha,"Confirme a senha!"))
            return;

        if ( f.login_cad_senha.value != f.login_cad_confirmar_senha.value){

            alert("Senha e confirmação não conferem!");
            f.login_cad_confirmar_senha.value = "";
            f.login_cad_confirmar_senha.focus();
            return;
        }

        f.acao.value = "cadastro";
        f.action="index.php";
        f.submit();
    }    


    if ( obj.name.indexOf("btLogin_Login") > -1){


        f.acao.value = "login";
        f.action="index.php";
        f.submit();            
    }

    if ( obj.name.indexOf("EmailGrande") > -1 || obj.name.indexOf("a_faz_cadastro") > -1 ){

                div_login_botoes_grande.style.display = "none"; //Escondo os botões grandes.
                div_login_botoes_pequeno.style.display = ""; //Mostro os botões pequenos.
                fn_setaNomesBotoesLogin(div_login_botoes_pequeno, true ); //Indicando os labels de criação de conta.
                div_login_campos_cadastro.style.display = "";
                div_login_logon.style.display = "none";
                login_rodape_fazlogin.style.display = "";
                login_rodape_cadastro.style.display = "none";
                if ( document.getElementById("div_aviso_1") != null )
                    document.getElementById("div_aviso_1").innerHTML = "";
            }
            if ( obj.name.indexOf("a_faz_login") > -1){

                div_login_botoes_grande.style.display = "none"; //Escondo os botões grandes.
                div_login_botoes_pequeno.style.display = ""; //Mostro os botões pequenos.
                div_login_campos_cadastro.style.display = "none";
                div_login_logon.style.display = "";
                fn_setaNomesBotoesLogin(div_login_botoes_pequeno, false ); //Indicando os labels de login.
                login_rodape_fazlogin.style.display = "none";
                login_rodape_cadastro.style.display = "";
                if ( document.getElementById("div_aviso_2") != null )
                   document.getElementById("div_aviso_2").innerHTML = ""; 
           }

           var redir = false; var url_redir = "";
           if ( obj.name.toLowerCase().indexOf("facebook") > -1){
            redir= true;
            url_redir = '<?= constant("url_base") ?>/oAuth/login_with_facebook.php';
        }

        if ( obj.name.toLowerCase().indexOf("microsoft") > -1){
          redir= true;
          url_redir = '<?= constant("url_base") ?>/oAuth/login_with_microsoft.php';             
      }

      if ( obj.name.toLowerCase().indexOf("google") > -1){
          redir= true;
          url_redir = '<?= constant("url_base") ?>/oAuth/login_with_google.php';  
      }

      if ( redir ){
        if ( parent!= null ){                   
         parent.document.location.href=url_redir;                    
     }else{
        document.location.href=url_redir; 
    }
}

}


function fn_setaNomesBotoesLogin(divPai, bl_criar ){

    var bts = divPai.getElementsByTagName("input");

    for ( var i =0; i < bts.length; i++){

     var botao = bts[i];

     if ( botao == undefined ||  botao.type == undefined ||  botao.type == null)
         continue;

     if ( botao.type != "button" )
         continue;

     if ( bl_criar ){
        if ( botao.name.toLowerCase().indexOf("google") > 1 ){
            botao.value = "Criar conta com o Google";
        }
        if ( botao.name.toLowerCase().indexOf("twitter") > 1 ){
            botao.value = "Criar conta com o Twitter";
        }
        if ( botao.name.toLowerCase().indexOf("microsoft") > 1 ){
            botao.value = "Criar conta com o Hotmail";
        }
        if ( botao.name.toLowerCase().indexOf("facebook") > 1 ){
            botao.value = "Criar conta com o Facebook";
        }
        if ( botao.name.toLowerCase().indexOf("email") > 1 ){
            botao.value = "Criar conta usando Email";
            botao.style.display = "";
        }
    }else{

     if ( botao.name.toLowerCase().indexOf("google") > 1 ){
        botao.value = "Login com o Google";
    }
    if ( botao.name.toLowerCase().indexOf("twitter") > 1 ){
        botao.value = "Login com o Twitter";
    }
    if ( botao.name.toLowerCase().indexOf("microsoft") > 1 ){
        botao.value = "Login com o Hotmail";
    }
    if ( botao.name.toLowerCase().indexOf("facebook") > 1 ){
        botao.value = "Login com o Facebook";
    }
    if ( botao.name.toLowerCase().indexOf("email") > 1 ){
        botao.value = "Criar conta usando Email";
        botao.style.display = "none";
    }
}

}

}

function listarTodasClassesUsadas(){


    var allTags = document.body.getElementsByTagName('*');
    var classNames = {};
    for (var tg = 0; tg< allTags.length; tg++) {
        var tag = allTags[tg];
        if (tag.className) {
          var classes = tag.className.split(" ");
          for (var cn = 0; cn < classes.length; cn++){
              var cName = classes[cn];
              if (! classNames[cName]) {
                classNames[cName] = true;
            }
        }
    }   
}
var classList = [];
for (var name in classNames){
    document.write( "<br>" + name );
               //classList.push(name);
           }



       }

       <? if ( Util::request("acao")== "cadastro"){ ?>
          fn_chamalogin( document.frmLogin.btLoginEmailGrande );
          <? } ?> 
          <? if ( Util::request("acao")== "login"){ ?>
              fn_chamalogin( document.getElementById("a_faz_login") );
              <? } ?> 
              <? if ( Util::request("acao")== "login-ini"){ ?>
                  fn_chamalogin( document.getElementById("a_faz_login") );
                  <? } ?> 
       //listarTodasClassesUsadas();
       
       <? if ( Util::request("resize") == "1"){ ?>   
        $(document).ready(function () {
         parent.$.fn.colorbox.resize({
             innerWidth: 380,
             innerHeight: 620
         });
     });
        <? } ?>


    </script>  
</form>
</body>
</html>
<? 
$oConn->disconnect(); 
?>