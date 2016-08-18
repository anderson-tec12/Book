<?php

/**
 * Classe responsável por armazenar os dados de cada item da breadcrumb (Navegacao Estruturada)
 *
 * @author Rodrigo Augusto Benedicto - 02/04/2015
 */
class ItemBreadCrumb {

    private $titulo;
    private $link;

    public function __construct($titulo, $link = "") {
        $this->titulo = $titulo;
        $this->link = $link;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getLink() {
        return $this->link;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setLink($link) {
        $this->link = $link;
    }

}
?>
