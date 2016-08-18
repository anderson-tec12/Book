<?php

require_once ("../../../config.php");
require_once (K_DIR . "library/interfaces/interface_component.php");
require_once (K_DIR . "library/Util.php");
require_once (K_DIR . "persist/IDbPersist.php");
require_once (K_DIR . "persist/connAccess.php");
require_once (K_DIR . "persist/FactoryConn.php");
require_once (K_DIR . "custom/inc_componente_template.php");
require_once (K_DIR . "library/kappa/kappa_rounds/avaliacao_kappa.php");
require_once (K_DIR . "library/kappa/kappa_rounds/bd_avaliacao_kappa.php");
require_once (K_DIR . "inc_usuario.php");
require_once (K_DIR . "painel/inc_usuario_load.php");
require_once (K_DIR . "library/SessionCliente.php");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

global $id_usuario_logado;

$id_ticket = SessionCliente::getValorSessao('ticket_id');

$id_pai = $_REQUEST['id_pai'];
$id_registro = $_REQUEST['id_registro'];
$nome_tabela = $_REQUEST['tabela'];
$nota = $_REQUEST['nota'];
$ressalva = $_REQUEST['ressalva'];
$tipo_avaliacao = $_REQUEST['tipo'];
$id_usuario_avaliado = $_REQUEST['id_usuario_avaliado'];

$bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

$avaliacaoKappa = new AvaliacaoKappa();
$avaliacaoKappa->setIdRegistro($id_registro);
$avaliacaoKappa->setNomeTabela($nome_tabela);
$avaliacaoKappa->setIdUsuario($id_usuario_logado);
$avaliacaoKappa->setNota($nota);
$avaliacaoKappa->setRessalva($ressalva);
$avaliacaoKappa->setData(Util::getCurrentBDdate());
$avaliacaoKappa->setIdTicket($id_ticket);
$avaliacaoKappa->setTipoAvaliacao($tipo_avaliacao);
$avaliacaoKappa->setIdUsuarioAvaliado($id_usuario_avaliado);

//$avaliacaoKappa->setIdKappaRaiz();
#
# Caso seja avaliação base de concordo plenamente já deve ser considerada a avaliação final
#
if ($tipo_avaliacao == AvaliacaoKappa::TIPO_AVALIACAO_BASE && $nota == 1) {

    #$avaliacaoKappaPai = $bdAvaliacaoKappa->buscaPorId($avaliacaoKappaId);

    $avaliacaoKappaFinal = new AvaliacaoKappa();
    $avaliacaoKappaFinal->setIdRegistro($id_registro);
    $avaliacaoKappaFinal->setNomeTabela($nome_tabela);
    #$avaliacaoKappaFinal->setIdKappaRaiz($avaliacaoKappaPai->getId());
    $avaliacaoKappaFinal->setIdUsuario($id_usuario_logado);
    $avaliacaoKappaFinal->setNota($nota);
    $avaliacaoKappaFinal->setRessalva($ressalva);
    $avaliacaoKappaFinal->setData(Util::getCurrentBDdate());
    $avaliacaoKappaFinal->setIdTicket($id_ticket);
    $avaliacaoKappaFinal->setTipoAvaliacao(AvaliacaoKappa::TIPO_AVALIACAO_FINAL);
    $avaliacaoKappaFinal->setIdUsuarioAvaliado($id_usuario_avaliado);

    $bdAvaliacaoKappa->salvar($avaliacaoKappaFinal);
} else {
    if (!empty($id_pai)) {
        $avaliacaoKappaPai = $bdAvaliacaoKappa->buscaPorId($id_pai);

        $avaliacaoKappa->setIdAvaliacaoKappaPai($avaliacaoKappaPai->getId());
        $avaliacaoKappa->setIdAvaliacaoKappaPaiUsuario($avaliacaoKappaPai->getIdUsuario());

        $idKappaRaiz = $avaliacaoKappaPai->getIdKappaRaiz();
        if (!empty($idKappaRaiz)) {
            #Treplica
            $avaliacaoKappa->setIdKappaRaiz($avaliacaoKappaPai->getIdKappaRaiz());
            #Atualiza a contagem de acordo com a avaliação pai - Replica
            $numeroTreplicasFeitasAoUsuario = $avaliacaoKappaPai->getContador();
            $avaliacaoKappa->setContador($numeroTreplicasFeitasAoUsuario);
        } else {
            #Replica direto na avaliacao raiz
            $avaliacaoKappa->setIdKappaRaiz($avaliacaoKappaPai->getId());
            #Atualiza a contagem das replicas
            $numeroReplicasFeitasAoUsuario = $bdAvaliacaoKappa->getQtdeDeAvaliacoesAoUsuario($avaliacaoKappaPai->getIdUsuario(), $tipo_avaliacao, $id_usuario_logado, $avaliacaoKappaPai->getIdRegistro(), $avaliacaoKappaPai->getNomeTabela());
            $avaliacaoKappa->setContador($numeroReplicasFeitasAoUsuario + 1);
        }
    }

    $avaliacaoKappaId = $bdAvaliacaoKappa->salvar($avaliacaoKappa);
}

