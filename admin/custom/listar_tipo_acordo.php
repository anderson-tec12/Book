<?php
require_once K_DIR . "custom/inc_tipo_acordo.php";

Util::mensagemCadastro()
?>
<form method="post" name="frm">
    <div class="fieldBox">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="sistem-title">Tipos de Acordo</h1>
            </div><!-- End col 12 -->
        </div><!-- End Row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="bs-example">
                    <div class="row">
                        <div class="col-xs-3">
                            <h4 class="sistem-subtitle">Lista de Tipos de Acordo</h4>
                        </div>
                    </div><!-- End Row -->
                    <table class="table table-hover table-condensed">
                        <thead>
                        <th>Descrição</th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?
                            $lista = tipo_acordo::buscaPorProximoNivel(0);

                            foreach ($lista as $item) {
                                ?>
                                <tr>
                                    <td><?= $item["descricao"] ?></td>
                                    <td>
                                        <a href="#" onclick="load('<?= $item["id"] ?>')" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
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
                    <a class="voltar" href="index.php?pag=modulo&mod=cad&acao=LOAD&id=34">
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
        f.action = "index.php?pag=tipo_acordo&mod=cad&acao=<?= Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }
</script>