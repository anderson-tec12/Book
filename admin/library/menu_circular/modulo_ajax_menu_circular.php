<?php

require_once ("../../library/interfaces/interface_component.php");
require_once ("../../library/Util.php");
require_once ("../../config.php");
require_once ("../../persist/IDbPersist.php");
require_once ("../../persist/connAccess.php");
require_once ("../../persist/FactoryConn.php");
require_once ("../../custom/inc_componente_template_item.php");
require_once ("../../custom/inc_componente_template.php");
require_once ("../../library/menu_circular/modulo_menu_circular.php");
require_once ("../../library/menu_circular/modulo_menu_circular_item.php");
require_once '../../library/menu_circular/modulo_menu_circular_item_multselect.php';
require_once ("../../custom/inc_modulo.php");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$id_modulo = $_REQUEST["id"];

$tipo = "";

if (isset($_REQUEST["grupo"])) {
    $grupo = $_REQUEST["grupo"];
}

$modulo = inc_modulo::findModuloById($id_modulo);

if ($modulo != null) {
    $menuCircular = new ModuloMenuCircular($id_modulo, 'f', $grupo);
    $menuCircular->printHTML();
} else {
    echo 'Modulo não Encontrado!';
}
?>
