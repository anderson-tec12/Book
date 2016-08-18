<?php

require_once ("../../../config.php");
require_once (K_DIR . "library/interfaces/interface_component.php");
require_once (K_DIR . "library/Util.php");
require_once (K_DIR . "persist/IDbPersist.php");
require_once (K_DIR . "persist/connAccess.php");
require_once (K_DIR . "persist/FactoryConn.php");
require_once (K_DIR . "custom/inc_componente_template.php");
require_once (K_DIR . "inc_usuario.php");
require_once (K_DIR . "painel/inc_usuario_load.php");
require_once (K_DIR . "library/kappa/kappa_rounds/bd_avaliacao_kappa.php");
require_once (K_DIR . "library/kappa/kappa_rounds/avaliacao_kappa.php");
require_once (K_DIR . "library/kappa/kappa_rounds/component_nova_avaliacao_kappa.php");

/*
 * Implementar verificacao de seguranca
 */

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$idPai = $_REQUEST["id_pai"];
$tipo = $_REQUEST["tipo"];
$nomeKappa = $_REQUEST["nome_kappa"];

$idRegistro = $_REQUEST["id_registro"];
$nomeTabela = $_REQUEST["nome_tabela"];
$idUsuarioAvaliado = $_REQUEST["id_usuario_avaliado"];

global $id_usuario_logado;

$novaAvaliacaoKappa = new NovaAvaliacaoKappa($idPai, $idRegistro, $nomeTabela, $idUsuarioAvaliado, $tipo, $nomeKappa);
if ($tipo == AvaliacaoKappa::TIPO_AVALIACAO_FINAL) {
    $novaAvaliacaoKappa->desabilitarNotas(array(2, 3, 4));
}
$novaAvaliacaoKappa->printHTML();
