<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StringHelp
 *
 * @author Asus
 */
class StringHelper {

    public static function destacarTexto($texto = '', $destaque_texto = '', $classe = '') {
        $textoDestacado = str_replace($destaque_texto, "<span class ='" . $classe . "'>" . $destaque_texto . "</span>", $texto);
        return $textoDestacado;
    }

}

?>
