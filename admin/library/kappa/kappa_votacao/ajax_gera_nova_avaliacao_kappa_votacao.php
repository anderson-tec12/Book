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
require_once (K_DIR . "library/kappa/kappa_votacao/bd_avaliacao_kappa.php");
require_once (K_DIR . "library/kappa/kappa_votacao/avaliacao_kappa.php");
require_once (K_DIR . "library/kappa/kappa_votacao/component_nova_avaliacao_kappa.php");

/*
 * Implementar verificacao de seguranca
 */

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$idPai = $_REQUEST["id_pai"];
$tipo = $_REQUEST["tipo"];

global $id_usuario_logado;

#Autor
$autor = Usuario::getUser($id_usuario_logado);
$imagemAutor = Usuario::mostraImagemUser($autor['imagem'], $autor['id']);
if (empty($imagemAutor) || substr($imagemAutor, -1) == "/") {
    $imagemAutor = K_RAIZ_DOMINIO . "sistema/painel/images/box_img_user.jpg";
}

$desabilitaNota2 = true;
$desabilitaNota3 = true;
$desabilitaNota4 = true;

if ($tipo == AvaliacaoKappa::TIPO_AVALIACAO_FINAL) {
    $novaAvaliacaoKappa = new NovaAvaliacaoKappa($idPai, false, true, true, true, false, $tipo);
    $novaAvaliacaoKappa->printHTML();
} else {
    $novaAvaliacaoKappa = new NovaAvaliacaoKappa($idPai, false, false, false, false, false, $tipo);
    $novaAvaliacaoKappa->printHTML();
}

