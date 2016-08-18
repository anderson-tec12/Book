<?php

/**
 * Classe povisória responsável por montar o modal de ação teste
 *
 * @author Rodrigo Augusto Benedicto - 05/11/2014
 */
include_once 'interface_modal_acao.php';

class modal_acao_teste implements interface_modal_acao {

    public function __construct($acao) {
        
    }

    public function printPagina() {
        $this->printTitulo();
        $this->printSubTitulo();
        $this->printConteudo();
        $this->printButtons();
        $this->printComponente();
    }

    public function printTitulo() {
        echo("Título Teste <br>");
    }

    public function printSubTitulo() {
        echo("Sub Título Teste <br>");
    }

    public function printConteudo() {
        echo("Conteúdo Teste <br>");
    }

    public function printButtons() {
        echo("Conteúdo Teste <br>");
    }

    public function printComponente() {
        echo("Componente Teste <br>");
    }

}
