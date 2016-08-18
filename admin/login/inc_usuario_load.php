<?php


$g_path_sistema = "D:\\OpenServers\\apache_php5\\www\\possivelacordo\\sistema"; //infelizmente tenho que por o caminho direto por aqui..
$g_url_caminho = "/possivelacordo";

if (! stristr( PHP_OS, 'WIN')) { 
     $g_path_sistema = "/home/possivel/public_html/sistema/";
	 $g_url_caminho = "";
}

define("K_PATH_SISTEMA" ,  $g_path_sistema);

require_once( K_PATH_SISTEMA . DIRECTORY_SEPARATOR . "config.php");

if (! defined( 'JPATH_BASE' )  ){
       define("JPATH_BASE",  K_JOOMLABASE ); 
}

require_once(K_PATH_SISTEMA . DIRECTORY_SEPARATOR . "persist".DIRECTORY_SEPARATOR."IDbPersist.php");
require_once(K_PATH_SISTEMA . DIRECTORY_SEPARATOR . "persist".DIRECTORY_SEPARATOR."connAccess.php");
require_once(K_PATH_SISTEMA . DIRECTORY_SEPARATOR . "persist".DIRECTORY_SEPARATOR."FactoryConn.php");
require_once(K_PATH_SISTEMA . DIRECTORY_SEPARATOR . "library".DIRECTORY_SEPARATOR."SessionCliente.php");
require_once(K_PATH_SISTEMA . DIRECTORY_SEPARATOR . "library".DIRECTORY_SEPARATOR."Util.php");

?>
<ul>
<? 
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
//ini_set('error_log','script_errors.log');
ini_set('log_errors','On');


if ( @$_GET["sair"] == "1" ){
      SessionCliente::destroy();
      
      die("<script>parent.document.location.href='/portal'; </script>");
}

$id_usuario_logado = "";
$img_usuario = "/user_img.gif";
$nome_usuario = "";

$bl_usa = true;

//$bl_usa = false;

if ( $bl_usa  && SessionCliente::usuarioLogado() ) { 
    $id_usuario_logado = SessionCliente::getPropriedade("id");
}

//$id_usuario_logado = 1;
if ($id_usuario_logado ) { 
    

  $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
  $usuario = connAccess::fastOne( $oConn, "usuario", " id = " .  $id_usuario_logado);
	

        if ( @$usuario["imagem"] != "" ){

            $img_usuario = Usuario::mostraImagemUser($usuario["imagem"], $id_usuario_logado); 
        }
        
     $nome_usuario = $usuario["nome"];  
}
	
	

	
?>