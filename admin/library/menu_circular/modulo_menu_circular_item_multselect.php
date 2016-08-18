﻿<?php

/**
 * Classe responsável por montar o item de menu circular de selecao multipla
 *
 * @author Rodrigo Augusto Benedicto - 03/01/2015
 */
class ModuloMenuCircularItemMultselect implements IComponent {

    private $titulo;
    private $icone;
    private $cor;
    private $descricao;
    private $idTemplate;
    private $id;

    public function __construct($idTemplate, $titulo = "", $icone = "", $cor = "", $descricao = "") {
        $this->idTemplate = $idTemplate;
        $this->titulo = $titulo;
        $this->icone = $icone;
        $this->cor = $cor;
        $this->descricao = $descricao;
    }

    public function printHTML() {
        ?>
        <li>
            <div class="menu_componente_relato">
                <img class="icon_menu_relato" src= <?= $this->icone ?>>
                <div class="nome_menu_relato" style="color: #<?= $this->cor ?>"><?= $this->titulo ?></div>
                <p><?= $this->descricao ?></p>
                <p><input id="option_<?= $this->id ?>" onclick="selecionarItemMultselect(id, <?= $this->idTemplate ?>)" type="checkbox"><label class="checkbox" for="option_<?= $this->id ?>">Adicionar este item</label></p>
            </div>
        </li>
        <?
    }

    public function getIdTemplate() {
        return $this->idTemplate;
    }

    public function setIdTemplate($idTemplate) {
        $this->idTemplate = $idTemplate;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getIcone() {
        return $this->icone;
    }

    public function setIcone($icone) {
        $this->icone = $icone;
    }

    public function getCor() {
        return $this->cor;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

}
?>
