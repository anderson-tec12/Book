<?php

require_once K_DIR . "library/kappa/kappa_rounds/regras/regras_kappa_rounds_padrao.php";
require_once K_DIR . "library/kappa/kappa_rounds/bd_avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_rounds/interfaces/interface_regra_kappa_rounds.php";

class RegrasKappaRoundsRodadas extends RegrasKappaRoundsPadrao {

    public function verificaUsuarioPodeAvaliarRegistro($idUsuario, $idRegistro, $nomeTabela) {

        #Regras especificas do rodadas
        if (!empty($idUsuario) && !empty($idRegistro) && !empty($nomeTabela)) {
            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
            $registro = $bdAvaliacaoKappa->buscaRegistroAvaliado($idRegistro, $nomeTabela);

            #Tem que ser do outro time
            if (!empty($registro) && isset($registro['id_usuario'])) {

                $autorRegistroNoTicket = TicketParticipante::buscaTicketParticipante($registro['id_usuario'], $this->idTicket);
                $usuarioLogadoNoTicket = TicketParticipante::buscaTicketParticipante($idUsuario, $this->idTicket);

                if (empty($autorRegistroNoTicket) || empty($usuarioLogadoNoTicket) || !isset($autorRegistroNoTicket['tipo']) || !isset($usuarioLogadoNoTicket['tipo']) || $autorRegistroNoTicket['tipo'] == $usuarioLogadoNoTicket['tipo']) {
                    return false;
                }
            }
        }

        return parent::verificaUsuarioPodeAvaliarRegistro($idUsuario, $idRegistro, $nomeTabela);
    }

    public function verificaUsuarioPodeReplicarAvaliacao($idUsuario, $idAvaliacaoKappa) {

        #Regras especificas do rodadas
        if (!empty($idUsuario) && !empty($idAvaliacaoKappa)) {
            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
            $avaliacaoKappa = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappa);

            #Verifica a quantidade de replicas feitas com a qtde permitida
            $qtdeAvaliacoesFeitasAoUsuario = $bdAvaliacaoKappa->getQtdeDeAvaliacoesAoUsuario($avaliacaoKappa->getIdUsuario(), AvaliacaoKappa::TIPO_REPLICA, $idUsuario, $avaliacaoKappa->getIdRegistro(), $avaliacaoKappa->getNomeTabela());
            if ($qtdeAvaliacoesFeitasAoUsuario >= $this->numeroCiclosKappa) {
                return false;
            }
        }

        return parent::verificaUsuarioPodeReplicarAvaliacao($idUsuario, $idAvaliacaoKappa);
    }

}
