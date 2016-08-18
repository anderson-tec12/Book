<?php
include_once 'interface_modal_acao.php';

include_once '../library/acao_ticket/acao_ticket.php';

/**
 * Classe responsável por montar o modal ação do tipo kappa
 *
 * @author Rodrigo Augusto Benedicto - 07/11/2014
 */
class modal_acao_generico implements interface_modal_acao {

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
        ?>        
        <div class="cabecalho_centro">
            <div class="titulo"><h2><? echo $this->acao["nome_componente"] ?></h2></div>
        </div>

        <? if (!empty($this->acao["data"])) { ?>
            <p>Data: <? echo $this->acao["data"] ?> </p>
        <? } if (!empty($this->acao["nome_cad"])) { ?>
            <p>Usuário: <? echo $this->acao["nome_cad"] ?> </p>
        <? } if (!empty($this->acao["titulo"])) { ?>
            <p> Ação: <? echo acao_ticket::formataTitulo($this->acao["titulo"]) ?> </p>
            <?
        }
    }

}
