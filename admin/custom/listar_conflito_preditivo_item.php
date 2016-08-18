<?php
if (file_exists(K_DIR . "painel/ferramentas/conflito/bd/conflito_preditivo_item.php")) {
    require_once K_DIR . "painel/ferramentas/conflito/bd/conflito_preditivo_item.php";
}

$bdConflitoPreditivoItem = new ConflitoPreditivoItem($oConn);

$field_order_type = Util::request("field_order_type");
$field_order = Util::request("field_order");
$grupoSelecionado = Util::request("grupo");

$prefixo = "_p1";

if (empty($grupoSelecionado)) {
    $grupoSelecionado = 'todos';
}

Util::mensagemCadastro();
?>
<form method="post" name="frm">
    <div class="fieldBox">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="sistem-title">Conflito - Itens Função Preditiva</h1>
                <div class="form-inline">
                    <h4 class="sistem-subtitle">Filtrar por:</h4>
                    <?
                    $grupos = $bdConflitoPreditivoItem->getGrupos();
                    ?>
                    <select class="form-control" name="grupo"> 
                        <option <?= $grupoSelecionado == 'todos' ? 'selected' : '' ?> value="todos">Selecione o Grupo</option>
                        <?
                        foreach ($grupos as $key => $grupo):
                            $selected = "";
                            if ($grupoSelecionado == $key) {
                                $selected = "selected";
                            }
                            ?>
                            <option <?= $selected ?> value="<?= $key ?>"><?= $grupo ?></option>
                            <?
                        endforeach;
                        ?>
                    </select> 
                    <button type="button" class="btn btn-primary" value="Pesquisar" onclick="document.frm.submit()">Buscar</button>
                </div>
            </div><!-- End col 12 -->
        </div><!-- End Row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="bs-example">
                    <? if (Util::request("exp_excel") == "") { ?>
                        <div class="col-xs-3">
                            <h4 class="sistem-subtitle">Lista de Itens</h4>
                        </div>

                        <div class="col-xs-3 pull-right">
                            <ul class="sub-menu">
                                <li class="sub-menu-item">
                                    <a href="#" onclick="openPagina('cad', '<?= Util::request("pag") ?>', '');"
                                       class="action" data-toggle="tooltip" data-placement="bottom" title="Criar Novo">
                                        <span class="icon icon-file2 text-new"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <? } ?>


                    <table class="table table-hover table-condensed">
                        <thead>
                        <th>Nome</th>
                        <th>Grupo</th>
                        <th></th>
                        </thead>
                        <tbody>
                            <?
                            if ($grupoSelecionado == 'todos') {
                                $lista = $bdConflitoPreditivoItem->buscaTodos();
                            } else {
                                $lista = $bdConflitoPreditivoItem->buscaPorGrupo($grupoSelecionado);
                            }

                            $inicio = 0;
                            $total = Util::NVL(count($lista), 0);
                            $fim = 1;
                            $tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo . "selQtdeRegistro"), constant("K_PAG_MINIMUN")), Util::NVL(Util::getParam($_REQUEST, $prefixo . "selPagina"), 1), $total, $inicio, $fim);
                            $z = 0;
                            $tarr = explode("_", $tmp);
                            $inicio = $tarr[0];
                            $fim = $tarr[1];

                            for ($z = 0; $z <= $fim; $z++) {
                                if ($z >= $fim)
                                    break;

                                if ($z < $inicio)
                                    continue;

                                $item = $lista[$z];
                                ?>
                                <tr>
                                    <td><?= $item["nome"] ?></td>
                                    <td><?= $bdConflitoPreditivoItem->getGrupoNomePelaChave($item["grupo"]) ?></td>
                                    <td>
                                        <a href="#" onclick="load('<?= $item["id"] ?>')" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                                            <span class="icon icon-action icon-pencil text-warning"></span>
                                        </a>
                                        <a href="#"  onclick="excluir('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Excluir">
                                            <span class="icon icon-action icon-remove2 text-danger"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?
                            }

                            if (Util::NVL(count($lista), 0) == 0) {
                                ?>
                                <tr>
                                    <td colspan="5" class="f-tabela-texto">
                                        N&atilde;o h&aacute; dados a serem exibidos!
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="form-inline">
                                        <div class="form-group form-group-sm">
                                            <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId")                                         ?>">
                                            <?php
                                            MostrarPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo . "selQtdeRegistro"), constant("K_PAG_MINIMUN")), Util::NVL(Util::getParam($_REQUEST, $prefixo . "selPagina"), 1), $total, "frm", true, true, $prefixo);
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="interMenu">
    <a class="voltar" href="index.php?pag=ferramenta&mod=cad&acao=LOAD&id=18">
        <img alt="Voltar" src="<?= K_RAIZ ?>images/back.png"/>
        Voltar
    </a>
</div>

<script >
    function load(id)
    {
        var f = document.forms[0];
        f.action = "index.php?pag=conflito_preditivo_item&mod=cad&acao=<?= Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }

    function excluir(id)
    {
        if (!confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
            return;

        var f = document.forms[0];
        f.action = "delete.php?pag=conflito_preditivo_item&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();

    }
</script>