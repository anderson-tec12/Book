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


  $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
  
  
$pag = Util::request("pag");
$mod = Util::request("mod");
$pasta_include = "";
  ?>
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
    <!-- <link href="fonts/menu-fonts.css" rel="stylesheet"> -->
    <link href="fonts/styletype.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">

    <!-- Alert JS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
    <link href="<?= K_RAIZ ?>painel/css/alertajs.min.css" rel="stylesheet" type="text/css">
    <script src="<?= K_RAIZ ?>painel/js/alertajs.min.js" type="text/javascript"></script>



    <link href="<?= K_RAIZ ?>javascript/jquery/style/jquery.ui.css" rel="stylesheet" type="text/css">
    <link href="<?= K_RAIZ ?>javascript/jquery/style/jquery.ui.ext.css" rel="stylesheet" type="text/css" >
    <link href="<?= K_RAIZ ?>javascript/jquery/jquery-ui-1.9.2.custom/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
       </head>
<body>
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
       <script type="text/javascript" src="<?= K_RAIZ ?>javascript/validacampos.js?t=2"></script>
    <script type="text/javascript" src="<?= K_RAIZ ?>javascript/selectbox.js"></script>
        
</body>
</html>
<?
  $oConn->disconnect();
?>