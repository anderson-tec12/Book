<?php

/**
 * Classe responsável por montar o modal ação do tipo falácia
 *
 * @author Rodrigo Augusto Benedicto - 05/11/2014
 */
include_once 'interface_modal_acao.php';

include_once '../survay/inc_resposta.php';
include_once '../library/select_textarea/StringHelper.php';
include_once '../library/acao_ticket/acao_ticket.php';
include_once '../painel/comp_chave_pesquisa.php';

class modal_acao_falacia implements interface_modal_acao {

    private $acao = null;
    private $resp = null;

    public function __construct($acao) {
        if ($acao != null) {
            $this->acao = $acao;
        } else {
            $this->acao = acao_ticket::getAcaoTicketById(Util::request("id"));
        }

        if ($this->acao["nome_acao"] == "Falacia") {
            $this->resp = resposta::buscaRespostaById($this->acao["id_registro"]);
        }
    }

    public function printComponente() {
        $chave_pesquisa = new chave_pesquisa();
        $chave_pesquisa->printHTMLContadorFalacias($this->resp["id"]);
    }

    public function printConteudo() {
        echo "<p>" . StringHelper::destacarTexto($this->acao["texto"], $this->acao["texto_selecionado"], "texto_selecionado") . "</p>";
    }

    public function printSubTitulo() {
        echo "<div class = \"titulo_abcd\"><span>" . $this->resp["componente_campo"] . "</span>" . acao_ticket::getNomeAmigavelPorLetra($this->resp["componente_campo"]) . "</div>";
    }

    public function printTitulo() {
        echo "<div class=\"titulo\"><h2>" . $this->acao["nome_componente"] . "</h2></div>";
    }

}
