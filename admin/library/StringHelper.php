<?php

/**
 * Classe responsável por conter métodos que facilitem operações com Strings no sistema
 *
 * @author Rodrigo Augusto Benedicto - 11/12/2014
 */
class StringHelper {

    public static function destacarTexto($texto = '', $destaque_texto = '', $classe = '') {
        $textoDestacado = str_replace($destaque_texto, "<span class ='" . $classe . "'>" . $destaque_texto . "</span>", $texto);
        return $textoDestacado;
    }

    public static function removeHtml($texto = '') {
        return strip_tags($texto);
    }

    public static function destacarTextoPeloIndiceInicial($indice = "", $texto = "", $texto_destaque = "", $background = "", $link = "") {
        mb_internal_encoding("UTF-8");
        $inicio = mb_substr($texto, 0, $indice);
        $final = mb_substr($texto, $indice + strlen($texto_destaque), strlen($texto));
        $texto_destaque = "<span style='background:" . $background . "; color: #FFF;'>" . $texto_destaque . "</span>";

        if (!empty($link)) {
            $texto_destaque = "<a class='hint--bottom' data-hint='Clique e acesse o debate' href='" . $link . "'>" . $texto_destaque . "</a>";
        }
        //$texto_destaque = "*" . $texto_destaque . "*";
        return $inicio . $texto_destaque . $final;
    }

    public static function removeQuebraLinha($texto = '') {
        return preg_replace('/\s/', '', $texto);
    }

    /*
     * Rodrigo Augusto - 06/02/2015
     * Função responsável por imprimir no HTML os paragrafos de acordo com a quebra de linha /n
     */

    public static function alteraQuebraLinhaParaHTML($texto = '') {
        return str_replace("\n", "<br/>", $texto);
    }

    /*
     * Rodrigo Augusto - 12/02/2015
     * Função responsável alterar todas as ocorrencias de quebra de linha /n
     */

    public static function alteraQuebraLinhaParaCaractere($texto = '', $caractere = "|") {
        return str_replace("\n", $caractere, $texto);
    }

    /*
     * Rodrigo Augusto - 12/02/2015
     * Função responsável resgatar o numero de ocorrencias de uma substring em uma string
     */

    public static function numeroOcorrenciasSubstring($string = '', $substring = '') {
        return substr_count($string, $substring);
    }

}

?>
