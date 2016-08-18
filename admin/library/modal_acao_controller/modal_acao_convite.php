<?php
include_once 'interface_modal_acao.php';

include_once '../library/acao_ticket/acao_ticket.php';

/**
 * Classe responsável por montar o modal ação do tipo convite
 *
 * @author Rodrigo Augusto Benedicto - 07/11/2014
 */
class modal_acao_convite implements interface_modal_acao {

    private $acao = null;

    public function __construct($acao) {
        if ($acao != null) {
            $this->acao = $acao;
        } else {
            $this->acao = acao_ticket::getAcaoTicketById(Util::request("id"));
        }
    }

    //Função responsável por imprimir a página
    public function printPagina() {
        $this->printTitulo();
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

}
