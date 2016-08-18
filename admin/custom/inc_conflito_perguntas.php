<?php
if (file_exists(K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_pergunta.php")) {
    require_once K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_pergunta.php";
}

global $oConn;

$bdConflitoAnaliticoPergunta = new ConflitoAnaliticoPergunta($oConn);

$listaPerguntas = $bdConflitoAnaliticoPergunta->buscaTodos();
?>

<div class="row">
    <div class="col-xs-12">
        <div class="bs-example">
            <h4 class="sistem-subtitle">Perguntas - Função Analítica</h4>
            <table class="table table-hover table-condensed">
                <thead>
                <th>Nível</th>
                <th>Pergunta</th>
                <th></th>
                </thead>
                <tbody>
                    <?
                    $ferramentas = inc_ferramenta::findAllFerramenta();

                    foreach ($listaPerguntas as $pergunta) {
                        ?>
                        <tr>
                            <td><?= $pergunta["nivel"] ?></td>
                            <td><?= $pergunta["pergunta"] ?></td>
                            <td>
                                <a href="#" class="action" data-toggle="modal" data-target="#modal_edicao_pergunta" data-placement="top" title="Editar">
                                    <span class="icon icon-action icon-pencil text-warning"></span>
                                </a>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edicao de pergunta -->
<div class="modal fade bs-example-modal-lg" id="modal_edicao_pergunta" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Pergunta</h4>
            </div>

            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="pergunta" class="control-label">Pergunta</label>
                        <textarea class="form-control" id="pergunta"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="resposta_1" class="control-label">Resposta 1</label>
                        <textarea class="form-control" id="resposta_1"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="resposta_2" class="control-label">Resposta 2</label>
                        <textarea class="form-control" id="resposta_2"></textarea>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="salvar()">Salvar</button> 
                </div>
            </div>
        </div>
    </div>
</div>
