<?php
/*
 * Para utilizar essa include sua tela dever� atender os seguintes itens
 * 1 - Deve haver uma variavel que represente um objeto ou array denominada $registro
 * 2 - $registro deve possuir um atributo VARCHAR denominado "ferramentas_relacionadas"
 * 3 - Deve possuir uma funcao js "salvar()", responsavel por salvar o registro com as ferramentas aqui selecionadas
 * 4 - Deve haver um input na tela denominado "ferramentas_relacionadas"
 */

if (is_null($registro)) {
    echo 'A variavel que representa o objeto deve se chamar $registro<br/>';
    die();
}

if (!array_key_exists('ferramentas_relacionadas', $registro)) {
    echo 'O registro não possui o atributo "ferramentas_relacionadas"';
    die();
}

if (file_exists(K_DIR . "library/interfaces/interface_component.php")) {
    require_once K_DIR . "library/interfaces/interface_component.php";
}

if (file_exists(K_DIR . "custom/inc_ferramenta.php")) {
    require_once K_DIR . "custom/inc_ferramenta.php";
}

$ferramentaSelecionadas = array();

if (!empty($registro['ferramentas_relacionadas'])) {
    $ferramentaSelecionadas = explode(",", $registro['ferramentas_relacionadas']);
}
?>

<div class="form-group">

    <input type="hidden"  readonly="true" id="ferramentas_relacionadas" name="ferramentas_relacionadas" value="<?= $registro["ferramentas_relacionadas"] ?>"  class="form-control" maxlength="300">
    <label>Ferramentas Relacionadas</label>
    <div id="ferramentas_relacionadas" class="panel panel-default">
        <div class="panel-heading">
            <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_ferramentas_relacionadas">Selecionar Ferramentas</button>
            </div>
            <div class="clear"></div>
        </div>
        <div class="panel-body">
            <?
            if (!empty($registro["ferramentas_relacionadas"])) {
                $idsFerramentaRelacionadas = explode(",", $registro["ferramentas_relacionadas"]);
                $ferramentasRelacionadas = inc_ferramenta::carregarFerramentasByIds($idsFerramentaRelacionadas);
                for ($i = 0; $i < count($ferramentasRelacionadas); $i++) {
                    $ferramentaRelacionada = $ferramentasRelacionadas[$i];
                    ?>
                    <div class="thum-ferramenta" style="margin: 10px 15px 0px 0px">
                        <img style="margin-right: 8px" width="48" height="48" class="img-thumbnail itens" src="<?= url_files . "/icons/" . $ferramentaRelacionada["imagem"] ?>" alt=""/><?= $ferramentaRelacionada["titulo"] ?>
                    </div>
                    <?
                }
            }
            ?>
        </div>
    </div><!-- Ferramentas relacionadas -->
</div>

<script type="text/javascript">

    function updateFerramentasRelacionadas(checked, idFerramenta) {

        var input_itens = document.getElementById('ferramentas_relacionadas');

        if (checked) {
            input_itens.value += idFerramenta + ',';
        } else {
            input_itens.value = input_itens.value.replace(idFerramenta + ',', '');
        }
    }

</script>


<!-- Modal Ferramentas -->
<div class="modal fade bs-example-modal-lg" id="modal_ferramentas_relacionadas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Ferramentas Relacionadas</h4>
            </div>

            <div class="modal-body">

                <table class="table table-hover table-condensed">
                    <thead>
                    <th>Título</th>
                    <th>Selecionar</th>
                    </thead>
                    <tbody>
                        <?
                        $ferramentas = inc_ferramenta::findAllFerramenta();

                        for ($i = 0; $i < count($ferramentas); $i++) {
                            $item = $ferramentas[$i];

                            if ($item['grupo'] != 0 && $item['id'] != $id) {
                                $checked = "";
                                if (in_array($item['id'], $ferramentaSelecionadas)) {
                                    $checked = "checked='true'";
                                }
                                ?>
                                <tr>
                                    <td><?= $item["titulo"] ?></td>
                                    <td><input type="checkbox" <?= $checked ?>onclick="updateFerramentasRelacionadas(this.checked, <?= $item["id"] ?>)"></td>
                                </tr>
                                <?
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="salvar()">Salvar</button> 
                </div>
            </div>
        </div>
    </div>
</div>


