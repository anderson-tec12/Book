<?php

require_once (K_DIR . "library/kappa/kappa_votacao/interfaces/interface_gerenciador_alerta_kappa_votacao.php");
require_once (K_DIR . "painel/modulos/rodadas_negociacao/rodadas_negociacao_gerenciador_alertas.php");

class BDAvaliacaoKappa {

    private $conexao;
    private static $bdAvaliacaoKappa = null;

    private function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public static function getInstance() {
        if (self::$bdAvaliacaoKappa == null) {
            global $oConn;
            self::$bdAvaliacaoKappa = new BDAvaliacaoKappa($oConn);
        }
        return self::$bdAvaliacaoKappa;
    }

    public function salvar(AvaliacaoKappa $avaliacaoKappa) {

        #Mapeamento Objeto Relacional    
        $registro = $avaliacaoKappa->getArrayProBanco();

        if (is_null($registro["id"])) {
            $registro["id"] = connAccess::Insert($this->conexao, $registro, "avaliacao_kappa", "id", true);
        } else {
            connAccess::Update($this->conexao, $registro, "avaliacao_kappa", "id");
        }

        $this->geraAlertaDaAvaliacaoKappa($registro["id"]);

        return $registro["id"];
    }

    public function buscaPorId($id) {

        $sql = " select * from avaliacao_kappa where id = " . $id;

        $result = connAccess::fetchData($this->conexao, $sql);

        if (count($result) > 0) {
            return $this->geraObjetoAvaliacaoKappa($result[0]);
        }

        return null;
    }

    public function buscaPorIdKappaRaiz($idKappaRaiz, $idUsuario = "") {

        $sql = " select * from avaliacao_kappa where id_avaliacao_kappa_raiz = " . $idKappaRaiz;

        if (!empty($idUsuario)) {
            $sql .= " and id_usuario = " . $idUsuario;
        }

        $sql .= " order by id";

        $result = connAccess::fetchData($this->conexao, $sql);

        if (count($result) > 0) {

            $listaAvaliacoesKappa = array();

            foreach ($result as $registro) {
                array_push($listaAvaliacoesKappa, $this->geraObjetoAvaliacaoKappa($registro));
            }

            return $listaAvaliacoesKappa;
        }

        return null;
    }

    public function contaAvaliacoesPorKappaRaiz($idKappaRaiz, $idUsuario = "") {

        if (!empty($idKappaRaiz)) {
            $sql = " select count(1) from avaliacao_kappa where id_avaliacao_kappa_raiz = " . $idKappaRaiz;

            if (!empty($idUsuario)) {
                $sql .= " and id_usuario = " . $idUsuario;
            }

            $qtdeAvaliacoesFilhas = connAccess::executeScalar($this->conexao, $sql);

            return $qtdeAvaliacoesFilhas;
        }

        return 0;
    }

    public function contaAvaliacoesPorRegistro($idRegistro, $nomeTabela, $tipoAvaliacao = AvaliacaoKappa::TIPO_AVALIACAO_BASE) {

        if (!empty($idRegistro) && !empty($nomeTabela)) {

            $listaAvaliacoesRaiz = $this->buscaPorRegistro($idRegistro, $nomeTabela, $tipoAvaliacao);

            if (count($listaAvaliacoesRaiz) > 0) {

                $contador = intval(count($listaAvaliacoesRaiz));

                foreach ($listaAvaliacoesRaiz as $avaliacaoKappaRaiz) {
                    $numeroAvaliacoesFilhas = $this->contaAvaliacoesPorKappaRaiz($avaliacaoKappaRaiz->getId());
                    $contador += $numeroAvaliacoesFilhas;
                }

                return $contador;
            }
        }

        return 0;
    }

    public function buscaPorTipo($idKappaRaiz, $tipoAvaliacao, $idUsuario = "") {

        if (!empty($idKappaRaiz) && !empty($tipoAvaliacao)) {

            $sql = " select * from avaliacao_kappa where id_avaliacao_kappa_raiz = " . $idKappaRaiz . " and tipo_avaliacao = '" . $tipoAvaliacao . "'";

            if (!empty($idUsuario)) {
                $sql .= " and id_usuario = " . $idUsuario;
            }

            $sql .= " order by id";

            $result = connAccess::fetchData($this->conexao, $sql);

            if (count($result) > 0) {

                $listaAvaliacoesKappa = array();

                foreach ($result as $registro) {
                    array_push($listaAvaliacoesKappa, $this->geraObjetoAvaliacaoKappa($registro));
                }

                return $listaAvaliacoesKappa;
            }
        }

        return null;
    }

    public function buscaPorIdKappaPai($idKappaPai, $idUsuario = "") {

        $sql = " select * from avaliacao_kappa where id_avaliacao_kappa_pai = " . $idKappaPai;

        if (!empty($idUsuario)) {
            $sql .= " and id_usuario = " . $idUsuario;
        }

        $sql .= " order by id";

        $result = connAccess::fetchData($this->conexao, $sql);

        if (count($result) > 0) {

            $listaAvaliacoesKappa = array();

            foreach ($result as $registro) {
                array_push($listaAvaliacoesKappa, $this->geraObjetoAvaliacaoKappa($registro));
            }

            return $listaAvaliacoesKappa;
        }

        return null;
    }

    public function buscaPorRegistro($idRegistro, $nomeTabela, $tipoAvaliacao = null, $nota = null) {

        if (!empty($idRegistro) && !empty($nomeTabela)) {

            $sql = " select * from avaliacao_kappa where id_registro = " . $idRegistro . " and nome_tabela = '" . $nomeTabela . "'";

            if (!empty($tipoAvaliacao)) {
                $sql .= " and tipo_avaliacao = '" . $tipoAvaliacao . "'";
            }

            if (!empty($nota)) {
                $sql .= " and nota = '" . $nota . "'";
            }

            $sql .= " order by id;";

            $result = connAccess::fetchData($this->conexao, $sql);

            if (count($result) > 0) {

                $listaAvaliacoesKappa = array();

                foreach ($result as $registro) {
                    array_push($listaAvaliacoesKappa, $this->geraObjetoAvaliacaoKappa($registro));
                }

                return $listaAvaliacoesKappa;
            }
        }

        return null;
    }

    public function buscaKappaRaizPorRegistroEUsuario($idRegistro, $nomeTabela, $idUsuario) {

        if (!empty($idRegistro) && !empty($nomeTabela) && !empty($idUsuario)) {

            $sql = " select * from avaliacao_kappa where id_registro = " . $idRegistro . " and nome_tabela = '" . $nomeTabela . "' and id_usuario = " . $idUsuario . "and id_avaliacao_kappa_pai IS NULL;";

            $result = connAccess::fetchData($this->conexao, $sql);

            if (count($result) > 0) {
                return $this->geraObjetoAvaliacaoKappa($result[0]);
            }
        }

        return null;
    }

    public function buscaRegistroAvaliado($idRegistro, $nomeTabela) {

        $sql = " select * from " . $nomeTabela . " where id = " . $idRegistro;

        $result = connAccess::fetchData($this->conexao, $sql);

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }

    public function buscaUltimaAvaliacaoDoKappaRaiz($idkappaRaiz) {

        if (!empty($idkappaRaiz)) {
            $todasAvaliacoes = $this->buscaPorIdKappaRaiz($idkappaRaiz);

            if (count($todasAvaliacoes) > 0) {
                $indiceUltimoElemento = count($todasAvaliacoes) - 1;
                return $todasAvaliacoes[$indiceUltimoElemento];
            }
        }

        return null;
    }

    public function buscaPessoasAvaliaramRegistro($id_registro, $nome_tabela) {
        if (!empty($id_registro) && !empty($nome_tabela)) {

            $sql = "select distinct u.* from avaliacao_kappa a left join usuario u on a.id_usuario = u.id where id_registro = " . $id_registro . " and nome_tabela = '" . $nome_tabela . "' and tipo_avaliacao = '" . AvaliacaoKappa::TIPO_AVALIACAO_FINAL . "'";

            return connAccess::fetchData($this->conexao, $sql);
        }

        return "";
    }

    public function getQtdeDeAvaliacoesAoUsuario($idUsuarioQueRecebeuAsAvaliacoes, $tipoAvaliacao = '', $idUsuarioQueFezAsAvaliacoes = '', $idRegistro = '', $nomeTabela = '') {
        if (!empty($idUsuarioQueRecebeuAsAvaliacoes)) {
            $sql = " select count(1) from avaliacao_kappa where id_avaliacao_kappa_pai_usuario = " . $idUsuarioQueRecebeuAsAvaliacoes;

            if (!empty($tipoAvaliacao)) {
                $sql .= " and tipo_avaliacao = '" . $tipoAvaliacao . "'";
            }

            if (!empty($idUsuarioQueFezAsAvaliacoes)) {
                $sql .= " and id_usuario = " . $idUsuarioQueFezAsAvaliacoes;
            }

            if (!empty($idRegistro)) {
                $sql .= " and id_registro = " . $idRegistro;
            }

            if (!empty($nomeTabela)) {
                $sql .= " and nome_tabela = '" . $nomeTabela . "'";
            }

            $qtdeAvaliacoes = connAccess::executeScalar($this->conexao, $sql);

            return $qtdeAvaliacoes;
        }

        return 0;
    }

    private function geraObjetoAvaliacaoKappa($registro) {

        $avaliacaoKappa = new AvaliacaoKappa();

        if (!empty($registro)) {

            #Mapeamento Objeto Relacional
            $avaliacaoKappa->setId($registro['id']);
            $avaliacaoKappa->setIdRegistro($registro['id_registro']);
            $avaliacaoKappa->setNomeTabela($registro['nome_tabela']);
            $avaliacaoKappa->setIdComponente($registro['id_componente_template']);
            $avaliacaoKappa->setIdUsuario($registro['id_usuario']);
            $avaliacaoKappa->setNota($registro['nota']);
            $avaliacaoKappa->setRessalva($registro['ressalva']);
            $avaliacaoKappa->setData($registro['data']);
            $avaliacaoKappa->setIdTicket($registro['id_ticket']);
            $avaliacaoKappa->setIdAvaliacaoKappaPai($registro['id_avaliacao_kappa_pai']);
            $avaliacaoKappa->setIdAvaliacaoKappaPaiUsuario($registro['id_avaliacao_kappa_pai_usuario']);
            $avaliacaoKappa->setIdUsuarioAvaliado($registro['id_usuario_avaliado']);
            $avaliacaoKappa->setIdKappaRaiz($registro['id_avaliacao_kappa_raiz']);
            $avaliacaoKappa->setTipoAvaliacao($registro['tipo_avaliacao']);
            $avaliacaoKappa->setContador($registro['contador']);
        }

        return $avaliacaoKappa;
    }

    private function geraAlertaDaAvaliacaoKappa($idAvaliacaoKappa) {
        if (!empty($idAvaliacaoKappa)) {

            $avaliacaoKappa = $this->buscaPorId($idAvaliacaoKappa);

            $gerenciadorAlerta = null;

            #Gera o disparador para o rodadas de negociacao
            if ($avaliacaoKappa->getNomeTabela() == "negociacao_item") {
                $gerenciadorAlerta = new RodadasNegociacaoGerenciadorAlertas();
            }

            #Gatilhos para alertas aos usuarios
            if (!empty($gerenciadorAlerta)) {
                $gerenciadorAlerta->enviarAlertaAoSalvarKappaVotacao($avaliacaoKappa);
            }
        }
    }

    public function buscaPorTicket($idTicket, $nomeTabela = '', $dataInicial = '', $dataFinal = '', $idUsuario = '') {
        if (!empty($idTicket)) {
            $sql = " select * from avaliacao_kappa where id_ticket = " . $idTicket;

            if (!empty($nomeTabela)) {
                $sql .= " and nome_tabela = '" . $nomeTabela . "'";
            }

            if (!empty($dataInicial) and ! empty($dataFinal)) {
                $sql .= " and data BETWEEN '" . $dataInicial . "' AND '" . $dataFinal . "'";
            }

            if (!empty($idUsuario)) {
                $sql .= " and id_usuario = " . $idUsuario;
            }

            //echo $sql;

            $result = connAccess::fetchData($this->conexao, $sql);

            if (count($result) > 0) {

                $listaAvaliacoesKappa = array();

                foreach ($result as $registro) {
                    array_push($listaAvaliacoesKappa, $this->geraObjetoAvaliacaoKappa($registro));
                }

                return $listaAvaliacoesKappa;
            }
        }
    }

}
