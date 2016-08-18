<?php

include_once 'modal_acao_falacia.php';
include_once 'modal_acao_generico.php';

/**
 * Classe responsável pela construção do modal adequado
 *
 * @author Rodrigo Augusto - 05/11/2014
 */
class modal_acao_factory {

    public static function getModalController($acao) {
        switch ($acao["nome_acao"]) {
            case "Falacia":
                return new modal_acao_falacia($acao);
            /* case "Kappa":
              return new modal_acao_kappa($acao);
              case "Convite":
              return new modal_acao_convite($acao);
              case "Enviar Convite":
              return new modal_acao_convite($acao);
              case "Comentario":
              return new modal_acao_convite($acao); */
            default:
                return new modal_acao_generico($acao);
                break;
        }
    }

}
