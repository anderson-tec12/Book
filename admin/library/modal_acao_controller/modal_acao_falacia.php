<?php
include_once 'interface_modal_acao.php';

include_once '../survay/inc_resposta.php';
include_once '../library/select_textarea/StringHelper.php';
include_once '../library/acao_ticket/acao_ticket.php';
include_once '../painel/comp_chave_pesquisa.php';

/**
 * Classe responsável por montar o modal ação do tipo falácia
 *
 * @author Rodrigo Augusto Benedicto - 05/11/2014
 */
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

    //Função responsável por imprimir a página
    public function printPagina() {
        $this->printTitulo();
        ?><div class="ferramenta_abcd"><?
        $this->printNomeCampo();
        $this->printTexto();
        $this->printButtons();
        $this->printComponente();
        ?></div><?
    }

    //Função responsável por imprimir o título
    private function printTitulo() {
        ?>
        <!--HTML-->
        <div class="cabecalho_centro">
            <div class="titulo"><h2><? echo $this->acao["nome_componente"] ?></h2></div>
        </div>
        <?
    }

    //Função responsável por o nome do campo onde o texto foi selecionado
    private function printNomeCampo() {
        ?>
        <!--HTML-->
        <div class = "titulo_abcd"><span> <? echo $this->resp["componente_campo"] ?></span> <? echo acao_ticket::getNomeAmigavelPorLetra($this->resp["componente_campo"]) ?></div><br>
        <?
    }

    //Função responsável por imprimir o texto e o texto em destaque
    private function printTexto() {
        ?>
        <!--HTML-->
        <p><? echo StringHelper::destacarTexto($this->acao["texto"], $this->acao["texto_selecionado"], "texto_selecionado") ?></p><br><br>
        <?
    }

    //Função responsável por imprimir o componente falácia
    private function printComponente() {
        $chave_pesquisa = new chave_pesquisa();
        $chave_pesquisa->printHTMLContadorFalacias($this->resp["id"]);
    }

    //Função responsável por imprimir os botões
    private function printButtons() {
        ?>
        <!--HTML-->
        <a href="pop_index.php?pag=resultado_kappa"><input class="iframe_modal button"type="button" value="Usou o Kappa"/></a><br>
        <?
    }

}
