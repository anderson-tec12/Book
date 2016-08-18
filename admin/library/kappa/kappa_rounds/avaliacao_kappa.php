<?php

require_once K_DIR . "library/Util.php";

class AvaliacaoKappa {

    const TIPO_AVALIACAO_BASE = 'Avaliação Inicial';
    const TIPO_REPLICA = 'Réplica';
    const TIPO_TREPLICA = 'Tréplica';
    const TIPO_AVALIACAO_FINAL = 'Decisão Final';
    const TIPO_APELO = 'Comentário Final';

    private $id;
    private $idRegistro = "";
    private $nomeTabela = "";
    private $idComponente = null;
    private $idUsuario = null;
    private $nota = "";
    private $ressalva = "";
    private $data = "";
    private $idTicket = null;
    private $idAvaliacaoKappaPai = null;
    private $idAvaliacaoKappaPaiUsuario = null;
    private $idUsuarioAvaliado = null;
    private $idKappaRaiz = null;
    private $tipoAvaliacao = "";
    private $contador = null;

    public function __construct() {
        $this->data = Util::getCurrentBDdate();
    }

    function getId() {
        return $this->id;
    }

    function getIdRegistro() {
        return $this->idRegistro;
    }

    function getNomeTabela() {
        return $this->nomeTabela;
    }

    function getIdComponente() {
        return $this->idComponente;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getNota() {
        return $this->nota;
    }

    function getRessalva() {
        return $this->ressalva;
    }

    function getData() {
        return $this->data;
    }

    function getIdTicket() {
        return $this->idTicket;
    }

    function getIdAvaliacaoKappaPai() {
        return $this->idAvaliacaoKappaPai;
    }

    function getIdAvaliacaoKappaPaiUsuario() {
        return $this->idAvaliacaoKappaPaiUsuario;
    }

    function getIdUsuarioAvaliado() {
        return $this->idUsuarioAvaliado;
    }

    function getIdKappaRaiz() {
        return $this->idKappaRaiz;
    }

    function getTipoAvaliacao() {
        return $this->tipoAvaliacao;
    }

    function getContador() {
        return $this->contador;
    }

    function setTipoAvaliacao($tipoAvaliacao) {
        $this->tipoAvaliacao = $tipoAvaliacao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdRegistro($idRegistro) {
        $this->idRegistro = $idRegistro;
    }

    function setNomeTabela($nomeTabela) {
        $this->nomeTabela = $nomeTabela;
    }

    function setIdComponente($idComponente) {
        $this->idComponente = $idComponente;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

    function setRessalva($ressalva) {
        $this->ressalva = $ressalva;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setIdTicket($idTicket) {
        $this->idTicket = $idTicket;
    }

    function setIdAvaliacaoKappaPai($idAvaliacaoKappaPai) {
        $this->idAvaliacaoKappaPai = $idAvaliacaoKappaPai;
    }

    function setIdAvaliacaoKappaPaiUsuario($idAvaliacaoKappaPaiUsuario) {
        $this->idAvaliacaoKappaPaiUsuario = $idAvaliacaoKappaPaiUsuario;
    }

    function setIdUsuarioAvaliado($idUsuarioAvaliado) {
        $this->idUsuarioAvaliado = $idUsuarioAvaliado;
    }

    function setIdKappaRaiz($idKappaRaiz) {
        $this->idKappaRaiz = $idKappaRaiz;
    }

    function setContador($contador) {
        $this->contador = $contador;
    }

    function getArrayProBanco() {
        #Mapeamento objeto relacional

        $registro['id'] = $this->getId();
        $registro['id_registro'] = $this->getIdRegistro();
        $registro['nome_tabela'] = $this->getNomeTabela();
        $registro['id_componente_template'] = $this->getIdComponente();
        $registro['id_usuario'] = $this->getIdUsuario();
        $registro['nota'] = $this->getNota();
        $registro['ressalva'] = $this->getRessalva();
        $registro['data'] = $this->getData();
        $registro['id_ticket'] = $this->getIdTicket();
        $registro['id_avaliacao_kappa_pai'] = $this->getIdAvaliacaoKappaPai();
        $registro['id_avaliacao_kappa_pai_usuario'] = $this->getIdAvaliacaoKappaPaiUsuario();
        $registro['id_usuario_avaliado'] = $this->getIdUsuarioAvaliado();
        $registro['id_avaliacao_kappa_raiz'] = $this->getIdKappaRaiz();
        $registro['tipo_avaliacao'] = $this->getTipoAvaliacao();
        $registro['contador'] = $this->getContador();

        return $registro;
    }

}
