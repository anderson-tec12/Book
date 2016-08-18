<?php

require_once K_DIR . "library/kappa/kappa_rounds/bd_avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_rounds/interfaces/interface_regra_kappa_rounds.php";

class RegrasKappaRoundsPadrao implements IRegraKappaRounds {

    protected $conexao;
    protected $numeroCiclosKappa;
    protected $idTicket;

    public function __construct($conexao, $idTicket) {
        $this->conexao = $conexao;
        $this->idTicket = $idTicket;
        $this->numeroCiclosKappa = 2;
    }

    public function verificaUsuarioPodeAvaliarRegistro($idUsuario, $idRegistro, $nomeTabela) {

        if (!empty($idUsuario) && !empty($idRegistro) && !empty($nomeTabela)) {

            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

            #Verifica se é autor
            $registro = $bdAvaliacaoKappa->buscaRegistroAvaliado($idRegistro, $nomeTabela);

            if (!empty($registro) && isset($registro['id_usuario'])) {
                if ($registro['id_usuario'] === $idUsuario) {
                    #return false;
                }
            }

            #Verifica se ja avaliou
            $avaliacoesRealizadasRegistro = $bdAvaliacaoKappa->buscaKappaRaizPorRegistroEUsuario($idRegistro, $nomeTabela, $idUsuario);

            if (count($avaliacoesRealizadasRegistro) > 0) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function ehHoraDaAvaliacaoFinal($idUsuario, $idAvaliacaoKappaPai) {
        
        if (!empty($idUsuario) && !empty($idAvaliacaoKappaPai)) {

            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
            $avaliacaoKappaPai = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappaPai);

            $idKappaPai = $avaliacaoKappaPai->getIdKappaRaiz();
            
            if(empty($idKappaPai)){
                return false;
            }
            
            $avaliacaoKappaRaiz = $bdAvaliacaoKappa->buscaPorId($avaliacaoKappaPai->getIdKappaRaiz());

            #Recupera o id do autor do registro
            $id_autor_registro = null;

            $arrayNomes = explode(":", $avaliacaoKappaPai->getNomeTabela());
            $nomeTabela = $arrayNomes[0];
            $registro = $bdAvaliacaoKappa->buscaRegistroAvaliado($avaliacaoKappaRaiz->getIdRegistro(), $nomeTabela);

            if (!empty($registro) && isset($registro['id_usuario'])) {
                $id_autor_registro = $registro['id_usuario'];
            }

            #A avaliação final deve ser feita por quem deu o primeiro kappa
            if ($avaliacaoKappaPai->getIdUsuario() !== $avaliacaoKappaRaiz->getIdUsuario()) {
                return false;
            }

            #Verifica o numero de treplicas com o numero de ciclos
            $treplicasRealizadasRegistro = $bdAvaliacaoKappa->buscaPorIdKappaRaiz($avaliacaoKappaRaiz->getId(), $idUsuario);

            #Conta o numero de treplicas realizadas a que avaliou inicialmente
            $countTreplica = 0;
            if (count($treplicasRealizadasRegistro) > 0) {
                foreach ($treplicasRealizadasRegistro as $treplica) {
                    if ($treplica->getIdAvaliacaoKappaPaiUsuario() == $id_autor_registro) {
                        $countTreplica++;
                    }
                }
            }
            if ($countTreplica < ($this->numeroCiclosKappa)) {
                return false;
            }

            #Verifica se é autor do kappa raiz
            $idUsuario = $avaliacaoKappaRaiz->getIdUsuario();
            if (!empty($idUsuario)) {
                if ($avaliacaoKappaRaiz->getIdUsuario() !== $idUsuario) {
                    return false;
                }
            }

            #Verifica se já tem avaliacao final
            $avaliacaoFinal = $bdAvaliacaoKappa->buscaPorTipo($avaliacaoKappaRaiz->getId(), AvaliacaoKappa::TIPO_AVALIACAO_FINAL);
            if (!empty($avaliacaoFinal)) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function ehHoraDoApeloFinal($idUsuario, $idAvaliacaoKappaPai) {

        if (!empty($idUsuario) && !empty($idAvaliacaoKappaPai)) {
            
            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
            $avaliacaoKappaPai = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappaPai);
            
            $idKappaRaiz = $avaliacaoKappaPai->getIdKappaRaiz();
            if(empty($idKappaRaiz)){
                return false;
            }
            
            $avaliacaoKappaRaiz = $bdAvaliacaoKappa->buscaPorId($avaliacaoKappaPai->getIdKappaRaiz());

            #É preciso ter avaliacao final
            $avaliacaoFinal = $bdAvaliacaoKappa->buscaPorTipo($avaliacaoKappaRaiz->getId(), AvaliacaoKappa::TIPO_AVALIACAO_FINAL);

            if (empty($avaliacaoFinal)) {
                return false;
            }

            #Verifica se já tem avaliacao apelo
            $comentarioFinal = $bdAvaliacaoKappa->buscaPorTipo($avaliacaoKappaRaiz->getId(), AvaliacaoKappa::TIPO_APELO);

            if (!empty($comentarioFinal)) {
                return false;
            }

            #Verifica se ele é autor da avaliação raiz
            if ($avaliacaoKappaRaiz->getIdUsuario() == $idUsuario) {
                return false;
            }



            return true;
        }

        return false;
    }

    public function verificaUsuarioPodeAdiantarAvaliacaoFinal($idUsuario, $idAvaliacaoKappa) {
        if (!empty($idUsuario) && !empty($idAvaliacaoKappa)) {
            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

            $avaliacaoKappa = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappa);

            if ($avaliacaoKappa->getTipoAvaliacao() == AvaliacaoKappa::TIPO_AVALIACAO_BASE) {
                $avaliacaoKappaRaiz = $avaliacaoKappa;
            } else {
                $avaliacaoKappaRaiz = $bdAvaliacaoKappa->buscaPorId($avaliacaoKappa->getIdKappaRaiz());
            }

            #A avaliação final deve ser feita por quem deu o primeiro kappa
            if ($idUsuario !== $avaliacaoKappaRaiz->getIdUsuario()) {
                return false;
            }

            #Verifica se já tem avaliacao final
            $avaliacaoFinal = $bdAvaliacaoKappa->buscaPorTipo($avaliacaoKappaRaiz->getId(), AvaliacaoKappa::TIPO_AVALIACAO_FINAL);
            if (!empty($avaliacaoFinal)) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function verificaUsuarioPodeReplicarAvaliacao($idUsuario, $idAvaliacaoKappa) {
        if (!empty($idUsuario) && !empty($idAvaliacaoKappa)) {

            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

            $avaliacaoKappa = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappa);

            #Verifica se sou autor da avaliação em questão
            if ($avaliacaoKappa->getIdUsuario() == $idUsuario) {
                return false;
            }

            #Verifica se o usuario ja teve respostas nas replicas anteriores
            $replicasAnteriores = $bdAvaliacaoKappa->buscaPorIdKappaPai($idAvaliacaoKappa, $idUsuario);
            if (!empty($replicasAnteriores) && count($replicasAnteriores) > 0) {
                foreach ($replicasAnteriores as $replicaAnterior) {
                    $respostas = $bdAvaliacaoKappa->buscaPorIdKappaPai($replicaAnterior->getId(), $replicaAnterior->getIdAvaliacaoKappaPaiUsuario());
                    if (empty($respostas) || count($respostas) == 0) {
                        return false;
                    }
                }
            }

            #Verifica se já tem avaliacao final
            if ($avaliacaoKappa->getIdKappaRaiz() !== null) {
                $avaliacaoKappaRaiz = $bdAvaliacaoKappa->buscaPorId($avaliacaoKappa->getIdKappaRaiz());
            } else {
                $avaliacaoKappaRaiz = $bdAvaliacaoKappa->buscaPorId($avaliacaoKappa->getId());
            }

            $avaliacaoFinal = $bdAvaliacaoKappa->buscaPorTipo($avaliacaoKappaRaiz->getId(), AvaliacaoKappa::TIPO_AVALIACAO_FINAL);

            if (!empty($avaliacaoFinal)) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function verificaUsuarioPodeTreplicarAvaliacao($idUsuario, $idAvaliacaoKappa) {
        if (!empty($idUsuario) && !empty($idAvaliacaoKappa)) {

            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
            $avaliacaoKappa = $bdAvaliacaoKappa->buscaPorId($idAvaliacaoKappa);

            #Verifica se sou autor da avaliação em questão
            if ($avaliacaoKappa->getIdUsuario() == $idUsuario) {
                return false;
            }

            #Verifica se kappa pai é uma Réplica
            if ($avaliacaoKappa->getTipoAvaliacao() != AvaliacaoKappa::TIPO_REPLICA) {
                return false;
            }

            #Verifica se ja treplicou
            $treplicasRealizadasRegistro = $bdAvaliacaoKappa->buscaPorIdKappaPai($idAvaliacaoKappa, $idUsuario);

            if (count($treplicasRealizadasRegistro) > 0) {
                return false;
            }

            #Verifica se a replica foi destinada ao usuario
            if ($avaliacaoKappa->getIdAvaliacaoKappaPaiUsuario() != $idUsuario) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function setNumeroCiclosKappa($numeroCiclos) {
        $this->numeroCiclosKappa = $numeroCiclos;
    }

}
