<?php
require_once("ap_padrao.php");
require_once("library/SessionFacade.php");
require_once("persist/IDbPersist.php");
require_once("persist/connAccess.php");
require_once("persist/FactoryConn.php");
require_once("persist/resumo.php");
require_once("persist/Parameters.php");
require_once("itens_menu.php");
require_once("inc_comboempresa.php");

if ( request("acao")=="change_path" ){
  //$_SESSION["GrupoMenu"] =  request("GrupoMenu");   
  $_SESSION["CurPasta"] =  request("CurPasta");
  $_SESSION["esteModulo"] = request("GrupoMenu");  
}

if (!array_key_exists("CurPasta", $_SESSION)){
  $_SESSION["CurPasta"] ="";    
}

$G_SCHEMA_DB = "";
$pasta_include = "";

if ( @$_SESSION["CurPasta"] != ""){
    
  if (strtolower($_SESSION["CurPasta"]) != "ModCadastros" && strtolower($_SESSION["CurPasta"]) != "ticket"){
  $pasta_include .= $_SESSION["CurPasta"]."/";
            
  $G_SCHEMA_DB = strtolower ( @$_SESSION["CurPasta"] ).".";
  }
}

if (!array_key_exists("esteModulo", $_SESSION)){
    $_SESSION["esteModulo"] = "ModCadastros"; 
}

$esteModulo = $_SESSION["esteModulo"];
//echo $esteModulo;
//$esteModulo = @$_SESSION["CurPasta"];

//Esta tela esta sendo exportada para o excel..
if ( Util::request("exp_excel") == "1" && Util::request("format") == "") {
  header("Content-type: application/vnd.ms-excel; name='excel'");
  header("Content-Disposition: filename=arquivoExcel.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
}
$pag = Util::request("pag");
$mod = Util::request("mod");

if ( $pag == "" && $mod == "" ){
  
  getFirstMenu($esteModulo, $mod, $pag);
  
  $_GET["pag"] = $pag;
  $_GET["mod"] = $mod;
}

if ( ! SessionFacade::usuarioLogado() ){
  die("<script>document.location.href='login.php'; </script>");
}

  $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

  if ( false ){
    if (  ! SessionFacade::temAcessoAModulo( $esteModulo ) ){
      $_SESSION["st_login"] = "Seu perfil não tem acesso ao Módulo:" . $esteModulo;
      die("<script>document.location.href='index.php'; </script>");
    }
  }

if ( Util::request("exp_excel") == "" ) { ?>
<!doctype html>
<html lang="pt-br" class="no-js">
<head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administração | Possível Acordo</title>
    <!-- Javascript -->
    <script src="js/modernizr.2.6.2.min.js"></script>
    <!-- Bootstrap -->
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fonts/icon-fonts.css" rel="stylesheet">
    <link href="fonts/styletype.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="<?= K_RAIZ ?>javascript/jquery/style/jquery.ui.css" rel="stylesheet" type="text/css">
    <link href="<?= K_RAIZ ?>javascript/jquery/style/jquery.ui.ext.css" rel="stylesheet" type="text/css" >
    <link href="<?= K_RAIZ ?>javascript/jquery/jquery-ui-1.9.2.custom/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript">
      function exporta_excel(){
        if ( document.frm.exp_excel != undefined ){
          document.frm.exp_excel.value = '1'; 
          document.frm.target="_blank";
          document.frm.submit();
      
          document.frm.exp_excel.value = ''; 
          document.frm.target="_self";
        }
      }

      function openPagina(mod, entidade, extra ){
        if ( extra == null )
          extra = "";
          pag = "?mod="+mod+"&pag="+entidade+extra.replace("?","&");
          document.location.href='index.php'+pag;
      }

      function openNewPagina(mod, entidade, extra ){
        if ( extra == null )
          extra = "";
          pag = "?mod="+mod+"&pag="+entidade+extra.replace("?","&")+"&mn=no";
          window.open('index.php'+pag,'editcad');
      }

      function openPrint(mod, entidade, extra, formato){
        var f = document.forms[0];
        var old_action = f.action;

        if ( extra == null )
          extra = ""; 
          pag = "?mod="+mod+"&pag="+entidade+extra.replace("?","&");
          var str = 'index.php'+pag;
          str += '&exp_excel=1&format='+formato;
    
        f.action = str;
        f.target="_blank";
        f.submit();
    
        f.target = "_self";
        f.action = old_action;
      }    
    </script>
  </head>
<body>
    <header id="header-sistem">
      <div class="container content">
        <div class="row">
          <div class="col-xs-3">
            <img src="/sistema/images/logo_possivel_acordo.png" alt="Possível Acordo Logotipo">
          </div>
          <div class="col-xs-6">
            <h1 class="header-title"><?= getTituloModuloSistema($esteModulo)?></h1>
          </div>
          <div class="col-xs-3 menu-top">
            <ul class="list-inline">
              <li class="menu-top-item"><?=SessionFacade::getProp("login")?></li>
              <li class="menu-top-item"><a href='<?= K_RAIZ ?>sair.php'>Sair</a></li>
            </ul>
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group pull-right"> 
                  <? mostraComboModuloSistemas(); ?>
                </div> 
              </div><!-- End Col 11 -->
            </div><!-- End Row -->
          </div><!-- End Col -->
        </div><!-- End Row -->
      </div><!-- End Container -->
    </header><!-- End Header -->

    <nav id="menu-sistem">
      <div class="container-fluid content">
        <div class="row">
          <div class="col-xs-12">
            <ul class="menu">
              <?= getEscreveMenuModuloSistema($esteModulo);?>
            </ul>
          </div><!-- End Col -->
        </div><!-- End Row -->
      </div><!-- End Container -->
    </nav><!-- End Nav -->

    <div class="container-fluid content">
        <? } //fim do Se, é excel ou não.. ?>    
        <?
          if ( $pag != "" ){ 
            require_once($pasta_include. $mod."_".$pag.".php");
          }else{
            if ( $mod == "config" ){
              require_once("configurations.php");
            }
          }

          if ( Util::request("exp_excel") == "1" && Util::request("format") == "html") {
            echo("\n <script>window.print();</script>");
          }        
        ?>

        <? if ( Util::request("exp_excel") == "" ) { ?>
        <script src="<?= K_RAIZ ?>javascript/validacampos.js" type="text/javascript"></script>
        <div id="divFormRodape">
    
        </div>
    </div><!-- End Container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/jquery.click-calendario-1.0.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/jquery/query.datepick-pt-BR.js"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/validacampos.js?t=2"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/selectbox.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
      $('.action').tooltip(true);
    </script>
    <script>
      try{
      $(function() {
        $(".temData").datepicker({ changeYear: true });
       //$( "#accordion" ).accordion();
      });
	  }catch(Exp){}
    </script>
</body>
</html>
<?
  $oConn->disconnect();
?>

<? } //fim do Se, é excel ou não.. ?>