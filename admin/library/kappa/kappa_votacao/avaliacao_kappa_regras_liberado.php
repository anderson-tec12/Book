<?php

require_once K_DIR . "library/kappa/kappa_votacao/bd_avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_votacao/interfaces/interface_regra_kappa_votacao.php";

class AvaliacaoRegrasLiberado implements IRegraKappaVotacao {

    private $conexao;
    private $numeroCiclosKappa;
    private $idTicket;

    public function __construct($conexao, $idTicket) {
        $this->conexao = $conexao;
        $this->idTicket = $idTicket;
        $this->numeroCiclosKappa = 1;
    }

    public function verificaUsuarioPodeAvaliarRegistro($idUsuario, $idRegistro, $nomeTabela) {

        return true;
    }

    public function verificaUsuarioPodeReplicarAvaliacao($idUsuario, $idAvaliacaoKappa) {

      
        return true;
    }

    public function verificaUsuarioPodeTreplicarAvaliacao($idUsuario, $idAvaliacaoKappa) {

      
        return true;
    }

    public function verificaUsuarioPodeAdiantarAvaliacaoFinal($idUsuario, $idAvaliacaoKappa) {

        if (!empty($idUsuario) && !empty($idAvaliacaoKappa)) {
            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

            $avaliacaoKappa = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappa);

         

            return true;
        }

        return false;
    }

    public function ehHoraDaAvaliacaoFinal($idUsuario, $idAvaliacaoKappaPai) {

        if (!empty($idUsuario) && !empty($idAvaliacaoKappaPai)) {

            

            return true;
        }

        return false;
    }

    public function ehHoraDoApeloFinal($idUsuario, $idAvaliacaoKappaPai) {

      

            return true;
    
    }

}
