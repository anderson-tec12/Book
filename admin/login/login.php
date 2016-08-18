<?php
 //BootStrap
//session_start();
require_once  "ap_padrao.php";

function is_bot(){
  $botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
      "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
      "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
      "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
      "msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
      "Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
      "Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
      "Butterfly","Twitturls","Me.dium","Twiceler");
  
  foreach($botlist as $bot){
    if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false)
      return true;  // Is a bot
  }
  
  return false; // Not a bot
}
//session_destroy();
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN | Possível Acordo</title>
    <!-- Javascript -->
    <script src="javascript/validacampos.js"></script>

    <!-- Bootstrap -->
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,300italic,400italic,700italic,500italic' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <form method="post" action="nothing.php" name="frm">
    <?
    //echo("------>  EI EI EI EI EI EI ". Util::NVL(@$_SESSION["conta_logins_errados"] ,0));
    if ( Util::NVL(@$_SESSION["conta_logins_errados"] ,0) >= 10 ){
      $_SESSION["st_Mensagem"] = "Esta é a décima tentativa seguida de login que não obtêve êxito. Caso tenha esquecido sua senha entre em contato com o administrador do sistema.";
      Util::mensagemCadastro();
      echo ("<br><br>Para tentar novamente clique <a href='sair.php?red=login'> aqui </a>. "); 
    }else {
      Util::mensagemCadastro();
    ?>
    <header>
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-6 col-xs-offset-3">
            <div class="logo">
              <img src="images/login/possivel_acordo_logo.png" alt="Logotipo Possível Acordo">
            </div>
          </div>
        </div>
      </div>
    </header><!-- End Header -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
          <div class="form-signin">
            <h4 class="form-signin-heading">Faça seu login para acessar</h4>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-user"></span>
                  </div>
                  <input class="form-control" placeholder="Login" value="" type="text" name="login" onkeypress="enter(this, event, null)">
                </div>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="glyphicon glyphicon-asterisk"></span>
                  </div>
                  <input class="form-control" placeholder="Senha" value="" autocomplete="off" type="password" onkeypress="enter(this, event, null)">
              </div>
            </div><!-- form-group End -->
              <div style="display:none">
                <br><label>Base&nbsp&nbsp&nbsp</label> 
                <?
                  $lista_base = getConexoesList();
                ?>   
                <select name="sel_base">
                <?
                for ( $y = 0; $y < count($lista_base); $y++){ 
                   $arp = explode("\t",  $lista_base[$y]);  
                   Util::populaCombo($y, $arp[0], Util::request("sel_base")); 
                }
                //$lista_base = getConexoesList();
                ?>              
                </select>
            </div>
            <button class="btn btn-lg btn-primary btn-block" class="botao" type="submit" onclick="Login()">LOGIN</button>
          </div>
        </div><!-- End coluns -->
    </div><!-- End Row -->
    <? } ?>
  </div><!-- End Container -->
  </form>
    <script>
      function enter(obj, event,code) /*So aceita numeros*/{
        Tecla = event.which;
          if(Tecla == null)
            Tecla = event.keyCode;
    
          if ( Tecla == 13 && code == null)
            Login();
            return true;
    
          if ( obj.name == "login")
            return SoNumero(event);
          else
            return true;
      }
      function Login(){
        var f= document.forms[0];
        //alert("oi");
        if (isVazio(f.login,"Informe o login!"))
          return false;
        if (isVazio(f.senha,"Informe a senha!"))
          return false;
        <? if ( ! is_bot() ) { ?>    
          f.action = "appLogin.php?checkLogin=0";
          f.submit();
        <? } ?>
      }
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>