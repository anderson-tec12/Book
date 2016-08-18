<?
require_once("../library/Util.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");
require_once("../library/SessionCliente.php");


$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>

<title>Painel de Controle</title>

<link href="../css/padrao.css?t=4" rel="stylesheet" type="text/css" media="all" />
<link href="css/painel_controle.css?t=5" rel="stylesheet" type="text/css" media="all" />

</head>

<? 
 
require_once 'inc_usuario_load.php'; ?>

<body>

<header id='header'>

	<div id="wrapper">
    
    	<!-- Cabeçalho -->
		<? require_once 'inc_header.php';  ?>
		
        <!-- Banner -->
		<? require_once 'inc_banner.php';  ?>
        
        <!-- Box Esquerdo -->
        <aside class="left">  
			<? require_once 'inc_box_user.php';  ?>
        </aside>
        
        <!-- Box Direito -->
        <aside class="right">
					<? 
                        $pag = Util::request("pag");
                        
        //                print_r( $_REQUEST );
        //                echo("<br>");
        //                print_r( $_SESSION );
        //                echo ( realpath(".").DIRECTORY_SEPARATOR. $pag.".php" );
        //                echo ( file_exists(realpath(".").DIRECTORY_SEPARATOR. $pag.".php"));
                        
                        if ( $pag != "" && file_exists(realpath(".").DIRECTORY_SEPARATOR. $pag.".php")){
							 
                            require_once $pag.'.php';
							 
                        } else {
                        
                            require_once 'inc_box_conteudo.php'; 
                        }
				?>
        </aside><!-- /right -->  
        
    </div><!-- /wrapper -->
</header>

</body>
</html>
