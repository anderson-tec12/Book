<?php

/**
 * Classe responsável por montar o menu circular de selecao multipla
 *
 * @author Rodrigo Augusto Benedicto - 03/01/2015
 */
class MenuCircularNovo implements IComponent {

    private $idFerramenta;
    private $multselect;
    private $grupoItemFerramenta;

    public function __construct($idFerramenta = "", $multselect = 'f', $grupoItemFerramenta = "") {
        $this->idFerramenta = $idFerramenta;
        $this->multselect = $multselect == 'f' ? FALSE : TRUE;
        $this->grupoItemFerramenta = $grupoItemFerramenta;
    }

    public function printHTML() {
        ?>

        <div id="rotatescroll">
            <div class="inf"></div>
            <a class="bt_fechar_seletor" onclick="hideModalMenuCircular()">Fechar</a>
            <div class="viewport">
                <ul class="overview">
                    <?
                    $templates = componente_template::getComponenteTemplateByFerramenta($this->idFerramenta, $this->grupoItemFerramenta);

                    if ($this->multselect) {
                        for ($i = 0; $i < count($templates); $i++) {
                            $template = $templates[$i];
                            $item = new MenuCircularItemMultselect($template['id'], $template['nome'], "../../files/icons/" . $template['imagem01'], $template['cor'], $template['descricao']);
                            $item->setId($i);
                            $item->printHTML();
                        }
                    } else {
                        for ($i = 0; $i < count($templates); $i++) {
                            $template = $templates[$i];
                            $item = new MenuCircularItem($template['id'], $template['nome'], "../../files/icons/" . $template['imagem01'], $template['cor'], $template['descricao']);
                            $item->printHTML();
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="dot"></div>
            <div class="overlay"></div>
            <div class="thumb"></div>

            <?
            if ($this->multselect) {
                ?>
                <div class="botoes_seletor">
                    <a class="iframe_modal button bt_concluir" onclick="clickConcluirSelecaoFerramenta();">Concluir</a>
                </div>
                <?
            }
            ?>
        </div>

        <?
    }

}
?>
