<?php
if (file_exists(K_DIR . "library/interfaces/interface_component.php")) {
    require_once K_DIR . "library/interfaces/interface_component.php";
}

class TabelaSelecaoConteudoAssinado implements IComponent {

    private $lista = null;

    public function __construct($listaConteudoAssinado) {
        $this->lista = $listaConteudoAssinado;
    }

    public function printHTML() {
        ?>
        <table class="table table-hover table-condensed">
            <thead>
            <th>Título</th>
            <th>Autor</th>
            <th>Selecionar</th>
        </thead>
        <tbody id="corpo_tabela">
            <?
            if (!empty($this->lista)) {
                for ($i = 0; $i < count($this->lista); $i++) {
                    $item = $this->lista[$i];
                    ?>
                    <tr>
                        <td><?= $item["titulo"] ?></td>
                        <td><?= $item["nome_completo"] ?></td>
                        <td><input type="button" value="Selecionar" class="btn" onclick="selecionar(<?= $item["id"] ?>, '<?= $item["titulo"] . " - " . $item["nome_completo"] ?>')"></td>
                    </tr>
                    <?
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="f-tabela-texto">
                        N&atilde;o h&aacute; dados a serem exibidos!
                    </td>
                </tr>
                <?
            }
            ?>
        </tbody>
        </table>
        <?
    }

}
