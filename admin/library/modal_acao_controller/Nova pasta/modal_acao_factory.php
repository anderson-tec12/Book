<?php

/**
 * Classe responsável pela construção do modal adequado
 *
 * @author Rodrigo Augusto - 05/11/2014
 */
include_once 'modal_acao_falacia.php';
include_once 'modal_acao_teste.php';

class modal_acao_factory {

    public static function getModalController($acao) {
        switch ($acao["nome_acao"]) {
            case "Falacia":
                return new modal_acao_falacia($acao);
                break;
            case "Teste":
                return new modal_acao_teste($acao);
                break;
            default:
                break;
        }
    }

}
