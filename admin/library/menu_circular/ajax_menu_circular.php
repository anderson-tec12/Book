<?php

require_once ("../../config.php");
require_once (K_DIR . "library/interfaces/interface_component.php");
require_once (K_DIR . "library/Util.php");
require_once (K_DIR . "inc_usuario.php");
require_once (K_DIR . "painel/inc_usuario_load.php");
require_once (K_DIR . "persist/IDbPersist.php");
require_once (K_DIR . "persist/connAccess.php");
require_once (K_DIR . "persist/FactoryConn.php");
require_once (K_DIR . "custom/inc_componente_template_item.php");
require_once (K_DIR . "custom/inc_componente_template.php");
require_once (K_DIR . "library/menu_circular/menu_circular.php");
require_once (K_DIR . "library/menu_circular/menu_circular_item.php");
require_once (K_DIR . "library/menu_circular/menu_circular_item_multselect.php");
require_once (K_DIR . "custom/inc_ferramenta.php");

if ($id_usuario_logado == "") {
    die();
}

$oConn = FactoryConn::getConn(K_CONN_TYPE);

$id_ferramenta = $_REQUEST["id"];

$tipo = "";

if (isset($_REQUEST["tipo"])) {
    $tipo = $_REQUEST["tipo"];
}


$ferramenta = inc_ferramenta::findFerramentaById($id_ferramenta, $tipo);

if ($ferramenta != null) {
    //echo(print_r($ferramenta));
    $menuCircular = new MenuCircularNovo($id_ferramenta, $ferramenta['multselect'], $tipo);
    $menuCircular->printHTML();
} else {
    echo 'Ferramenta n�o Encontrada!';
}
?>
