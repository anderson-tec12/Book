<?php
require_once("../library/Util.php");
require_once("../library/interfaces/interface_component.php");
require_once("../config.php");
require_once("../inc_usuario.php");
require_once("../painel/inc_usuario_load.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("inc_grupo_componente_template.php");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$grupos = array();

if (isset($_REQUEST["id_ferramenta"])) {
    $id_ferramenta = $_REQUEST["id_ferramenta"];
    $grupos = inc_grupo_componente_template::buscaGruposPorFerramenta($id_ferramenta);
}

if (isset($_REQUEST["id_modulo"])) {
    $id_modulo = $_REQUEST["id_modulo"];
    $grupos = inc_grupo_componente_template::buscaGruposPorModulo($id_modulo);
}

if (!empty($grupos)) {
    foreach ($grupos as $key => $grupo) {
        ?>
        <option value="<?= $grupo['id'] ?>"><?= $grupo['nome'] ?></option>
        <?
    }
} else {
    ?>
    <option value="">Grupo Padrão</option>
    <?
}
