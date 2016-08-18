<?php
if (file_exists(K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_pergunta.php")) {
    require_once K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_pergunta.php";
}
Util::mensagemCadastro()
?>
<form method="post" name="frm">
    <div class="fieldBox">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="sistem-title">Conflito - Função Analítica</h1>
            </div><!-- End col 12 -->
        </div><!-- End Row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="bs-example">
                    <div class="row">
                        <div class="col-xs-3">
                            <h4 class="sistem-subtitle">Lista de Perguntas</h4>
                        </div>
                    </div><!-- End Row -->
                    <table class="table table-hover table-condensed">
                        <thead>
                        <th>Nível</th>
                        <th>Pergunta</th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?
                            $bdConflitoAnaliticoPergunta = new ConflitoAnaliticoPergunta($oConn);
                            $listaPerguntas = $bdConflitoAnaliticoPergunta->buscaTodos();

                            foreach ($listaPerguntas as $pergunta) {
                                ?>
                                <tr>
                                    <td><?= $pergunta["nivel"] ?></td>
                                    <td><?= $pergunta["pergunta"] ?></td>
                                    <td>
                                        <a href="#" onclick="load('<?= $pergunta["id"] ?>')" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                                            <span class="icon icon-action icon-pencil text-warning"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?
                            }
                            ?>
                        </tbody>
                    </table>
                </div><!-- End Bs Exemple -->
                <div class="interMenu">
                    <a class="voltar" href="index.php?pag=ferramenta&mod=cad&acao=LOAD&id=18">
                        <img alt="Voltar" src="<?= K_RAIZ ?>images/back.png"/>
                        Voltar
                    </a>
                </div>
            </div><!-- End col 12 -->

        </div><!-- End Row -->
    </div><!-- END FIELDBOX -->
</form>

<script >
    function load(id)
    {
        var f = document.forms[0];
        f.action = "index.php?pag=conflito_pergunta&mod=cad&acao=<?= Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }
</script>