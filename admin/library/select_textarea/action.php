<?php
/*
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);


require_once ( $_SERVER['DOCUMENT_ROOT'] . DS .'portal'. DS . 'includes' . DS . 'defines.php' );
require_once ( $_SERVER['DOCUMENT_ROOT'] . DS .'portal' . DS . 'includes' . DS . 'framework.php' );

$mainframe = JFactory::getApplication('site');

$mainframe->initialise();

$session = JFactory::getSession();

$session->set('custom_textarea_texto', $_POST['texto']);
$session->set('custom_textarea_texto_selecionado', $_POST['texto_selecionado']);
$session->set('custom_textarea_indice_inicial', $_POST['indice_inicial']);
$session->set('custom_textarea_indice_final', $_POST['indice_final']);
$session->set('custom_textarea_id_componente', $_POST['id_componente']);
 * */


require_once("../../config.php");
require_once("../../library/SessionCliente.php");

foreach ($_REQUEST as $key => $value) {
       echo("<br><b>".$key."</b> = ". $value );
       SessionCliente::setValorSessao("custom_textarea_".$key, $value);
}

echo ("<br>".  count($_REQUEST). " valores armazenados com sucesso! ");

?>
