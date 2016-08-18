<?php

$field_order_type = Util::request("field_order_type");
$field_order = Util::NVL(Util::request("field_order"), "ordem");

$acao2 = Util::request("acao2");

if ($acao2 == "salvar_ordenacao" && Util::request("str_itens") != "") {
    $ar = explode(",", Util::request("str_itens"));

    for ($i = 0; $i < count($ar); $i++) {

        $id_tmp = $ar[$i];

        if (!empty($id_tmp)) {

            $ordem = Util::NVL(Util::request("ordem_" . $id_tmp), "NULL");
            $sql_item = " update custom.termo_legal set ordem = " . $ordem . " where id = " . $id_tmp;

            connAccess::executeScalar($oConn, $sql_item);
        }
    }

    $_SESSION["st_Mensagem"] = "Ordenação salva com sucesso!";
}

Util::mensagemCadastro();
?>

<form method="post" name="frm" action="index.php?pag=termo_legal&mod=<?php echo Util::request("mod") ?>">

    <input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
    <input type="hidden" name="acao2" value="" >

    <div class="row">
        <div class="col-xs-12">
            <h1 class="sistem-title">Termo Inicial - Termos Legais</h1>
            <div class="form-inline">
                <h4 class="sistem-subtitle">Filtrar por:</h4>

                <select name="field_order" class="form-control">
                    <option value="descricao" <?= $field_order == "descricao" ? " selected" : "" ?>>Descrição</option>
                    <option value="ordem" <?= $field_order == "ordem" ? " selected" : "" ?>>Ordenação</option>
                </select>

                <select name="field_order_type" class="form-control">
                    <option value="asc" <?= $field_order_type == "asc" ? " selected" : "" ?>>Ascendente</option>
                    <option value="desc" <?= $field_order_type == "desc" ? " selected" : "" ?>>Descendente</option>
                </select>

                <input type="button" class="btn btn-primary" class="botao" value="Pesquisar" value="Buscar" onclick="document.frm.submit()">
            </div>
        </div><!-- End Col -->
    </div><!-- End Row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="bs-example">

                <div class="row">
                    <div class="col-xs-3">
                        <h4 class="sistem-subtitle">Lista de Termos Legais</h4>
                    </div>
                    <div class="col-xs-3 pull-right">
                        <? if (Util::request("exp_excel") == "") { ?>
                            <ul class="sub-menu">
                                <li class="sub-menu-item">
                                    <a href="#" onclick="salvarOrdenacao();"
                                       class="action" data-toggle="tooltip" data-placement="left" title="Salvar Ordenação">
                                        <span class="icon icon-numbered-list text-success"></span>
                                    </a>
                                </li>

                                <li class="sub-menu-item">
                                    <a href="#" onclick="openPagina('cad', '<?= Util::request("pag") ?>', '');" 
                                       class="action" data-toggle="tooltip" data-placement="left" title="Criar Novo">
                                        <span class="icon icon-file2 text-new"></span>
                                    </a>
                                </li>
                                <li class="sub-menu-item">
                                    <a href="" onclick="openPrint('listar', '<?= Util::request("pag") ?>', '', 'html');" class="action" data-toggle="tooltip" data-placement="bottom" title="Imprimir">
                                        <span class="icon icon-print text-print"></span>
                                    </a>
                                </li>
                                <li class="sub-menu-item">
                                    <a href="" onclick="openPrint('listar', '<?= Util::request("pag") ?>', '', '');" class="action" data-toggle="tooltip" data-placement="right" title="Exportar Excel">
                                        <span class="icon icon-file-excel text-export"></span>
                                    </a>
                                </li>
                            </ul>
                        <? } ?>
                    </div>
                </div><!-- End Row -->

                <table class="table table-hover table-condensed">
                    <thead>
                    <th style="width: 750px">Título</th>
                    <th>Ordenação</th>
                    <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $prefixo = "p1_";
                        $filtro = "";

                        if ($field_order != "") {
                            $filtro.= " order by " . $field_order . " " . $field_order_type;
                        }

                        $sql = " select * from custom.termo_legal " . $filtro;
                        $lista = connAccess::fetchData($oConn, $sql);

                        $str_itens = "";

                        $inicio = 0;
                        $total = Util::NVL(count($lista), 0);
                        $fim = 1;
                        $tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo . "selQtdeRegistro"), constant("K_PAG_MINIMUN")), Util::NVL(Util::getParam($_REQUEST, $prefixo . "selPagina"), 1), $total, $inicio, $fim);
                        $z = 0;
                        $tarr = explode("_", $tmp);
                        $inicio = $tarr[0];
                        $fim = $tarr[1];

                        if (Util::request("exp_excel") == "1") {
                            $fim = count($lista);
                        }

                        for ($z = 0; $z <= $fim; $z++) {
                            if ($z >= $fim)
                                break;

                            if ($z < $inicio)
                                continue;

                            $item = $lista[$z];

                            $str_itens .= $item["id"] . ",";

                            $img = "edit.png";
                            $title = "Editar";
                            ?>
                            <tr>
                                <td><?= strlen($item["titulo"]) > 100 ? substr($item["titulo"], 0, 97) . "..." : $item["titulo"] ?></td>
                                <td>
                                    <input type="number" min="0" step="1" style="min-width: 70px" id="ordem_<?= $item["id"] ?>" name="ordem_<?= $item["id"] ?>" maxlength="8" value="<?= $item["ordem"] ?>" class="form-control input-sm input-size-mini">
                                </td>
                                <? if (Util::request("exp_excel") == "") { ?>
                                    <td>
                                        <a href="#" onclick="load('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                                            <span class="icon icon-action icon-pencil text-warning"></span>
                                        </a>
                                        <a href="#"  onclick="excluir('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Excluir">
                                            <span class="icon icon-action icon-remove2 text-danger"></span>
                                        </a>
                                    </td>
                                <? } ?>
                            </tr>
                        <?php } ?>
                        <?php
                        if (Util::NVL(count($lista), 0) == 0) {
                            ?>
                        <tbody>
                            <tr>
                                <td colspan="5" class="f-tabela-texto">
                                    N&atilde;o h&aacute; dados a serem exibidos!
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <? if (Util::request("exp_excel") == "") { ?>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="form-inline">
                                        <div class="form-group form-group-sm">
                                            <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId")                                                                          ?>">
                                            <?php
                                            MostrarPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo . "selQtdeRegistro"), constant("K_PAG_MINIMUN")), Util::NVL(Util::getParam($_REQUEST, $prefixo . "selPagina"), 1), $total, "frm", true, true, $prefixo);
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    <? } ?>
                </table>
            </div><!-- End BS-Example -->

            <div class="interMenu">
                <a class="voltar" href="index.php?pag=modulo&mod=cad&acao=LOAD&id=34">
                    <img alt="Voltar" src="<?= K_RAIZ ?>images/back.png"/>
                    Voltar
                </a>
            </div>

        </div><!-- Enc Col -->
    </div><!-- End Row -->

    <input type="hidden" name="str_itens" value="<?= $str_itens ?>">

</form>
<script >
    function salvarOrdenacao()
    {
        var f = document.forms[0];
        f.acao2.value = "salvar_ordenacao";
        f.submit();
    }

    function load(id)
    {
        var f = document.forms[0];
        f.action = "index.php?pag=termo_legal&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }

    function excluir(id)
    {
        if (!confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
            return;

        var f = document.forms[0];
        f.action = "delete.php?pag=termo_legal&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();

    }

</script>