<?php

/**
 * Classe responsável por montar o breadcrumb (Navegacao Estruturada)
 *
 * @author Rodrigo Augusto Benedicto - 02/04/2015
 */
class BreadCrumb implements IComponent {

    private $itens = array();
    private $tituloAtual = "";
    private $linkTitulo = "";

    public function __construct($tituloAtual = "", $linkTitulo = "") {
        $this->tituloAtual = $tituloAtual;
        $this->linkTitulo = $linkTitulo;
    }

    public function printHTML() {

    ?>
    <div class="breadcrumbs">
    <?

        if ($this->itens != null && count($this->itens) > 0) {

            for ($i = 0; $i < count($this->itens); $i++) {
                $item = $this->itens[$i];
                ?>
                <a href="<?= $item->getLink() ?>"><?= $item->getTitulo() ?></a> &#187;
                <?
            }
        }

        if (empty($this->linkTitulo)) {
            echo $this->tituloAtual;
        } else {
            ?>
            <a href="<?= $this->linkTitulo ?>"><?= $this->tituloAtual ?></a>
            <?
        }
        
    ?>
    </div>
    <?

    }

    

    public function addItem($itemBreadCrumb) {
        if (!empty($itemBreadCrumb)) {
            array_push($this->itens, $itemBreadCrumb);
        }
    }

    public function inverterOrdemItens() {
        $this->itens = array_reverse($this->itens);
    }

}
?>
