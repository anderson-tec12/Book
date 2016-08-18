<?php

class ModuloMenuCircular implements IComponent {

    private $idModulo;
    private $multselect;
    private $grupo;

    public function __construct($idModulo = "", $multselect = 'f', $grupo = "") {
        $this->idModulo = $idModulo;
        $this->multselect = $multselect == 'f' ? FALSE : TRUE;
        $this->grupo = $grupo;
    }

    public function printHTML() {
        ?>

        <div id="rotatescroll">
            <div class="inf"></div>
            <a class="bt_fechar_seletor" onclick="hideModalMenuCircular()">Fechar</a>
            <div class="viewport">
                <ul class="overview">
                    <?
                    $templates = componente_template::getComponenteTemplateByModulo($this->idModulo, $this->grupo);

                    if ($this->multselect) {
                        for ($i = 0; $i < count($templates); $i++) {
                            $template = $templates[$i];
                            $item = new ModuloMenuCircularItemMultselect($template['id'], $template['nome'], "../../files/icons/" . $template['imagem01'], $template['cor'], $template['descricao']);
                            $item->setId($i);
                            $item->printHTML();
                        }
                    } else {
                        for ($i = 0; $i < count($templates); $i++) {
                            $template = $templates[$i];
                            $item = new ModuloMenuCircularItem($template['id'], $template['nome'], "../../files/icons/" . $template['imagem01'], $template['cor'], $template['descricao']);
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
                    <a class="iframe_modal button bt_concluir" onclick="clickConcluirSelecao();">Concluir</a>
                </div>
                <?
            }
            ?>
        </div>

        <?
    }

}
?>
