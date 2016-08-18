<?php
require_once("inc_template_texto.php");
require_once ("inc_ferramenta.php");
require_once ("inc_componente_template.php");

$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"] = $ur;
$_SESSION["array_querie_ant"] = Util::paginaAtual($_REQUEST, "url,urlnoId", false);

$prefixo = "_p1";

$field_order_type = Util::request("field_order_type");
$field_order = Util::request("field_order");
$codigoSelecionado = Util::request("codigo");
?>

<?php Util::mensagemCadastro() ?>

<form method="post" name="frm" action="index.php?pag=template_texto&mod=<?php echo Util::request("mod") ?>">

    <input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >

    <div class="row">
        <div class="col-xs-12">
            <h1 class="sistem-title">Todos os Templates de Texto</h1>
            <div class="form-inline">
                <h4 class="sistem-subtitle">Filtrar por:</h4>
                <? if (Util::request("exp_excel") == "") { ?>
                    <select class="form-control" name="codigo"> 
                        <?
                        $ferramentaPreposicoesAgressivas = inc_ferramenta::findFerramentaByCodigo("proposicoes_agressivas");
                        $ferramentaPreposicoesConciliadoras = inc_ferramenta::findFerramentaByCodigo("proposicoes_conciliadoras");

                        $ferramentas = array();
                        array_push($ferramentas, $ferramentaPreposicoesAgressivas);
                        array_push($ferramentas, $ferramentaPreposicoesConciliadoras);
                        #$ferramentas = inc_ferramenta::findAllFerramenta();

                        foreach ($ferramentas as $ferramenta):
                            ?>
                            <optgroup label="<?= $ferramenta['titulo'] ?>">
                                <?
                                $itens = componente_template::getComponenteTemplateByFerramenta($ferramenta['id']);

                                foreach ($itens as $item):

                                    if (empty($codigoSelecionado)) {
                                        $codigoSelecionado = $item['id'];
                                    }

                                    $selected = "";

                                    if ($codigoSelecionado == $item['id']) {
                                        $selected = " selected ";
                                    }
                                    ?>
                                    <option <?= $selected ?> value="<?= $item['id'] ?>"><?= $item['nome'] ?></option>
                                    <?
                                endforeach;
                                ?>
                            </optgroup>
                            <?
                        endforeach;
                        ?>
                    </select> 
                    <select name="field_order_type" class="form-control">
                        <option value="asc" <?
                        if ($field_order_type == "asc") {
                            echo ( " selected ");
                        }
                        ?>>Ascendente</option>
                        <option value="desc" <?
                        if ($field_order_type == "desc") {
                            echo ( " selected ");
                        }
                        ?>>Descendente</option>	
                    </select>
                    <button type="button" class="btn btn-primary" class="botao" value="Pesquisar" onclick="document.frm.submit()">Buscar</button>
                <? } ?>
            </div>
        </div><!-- End Col -->
    </div><!-- End Row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="bs-example">

                <div class="row">
                    <div class="col-xs-3">
                        <h4 class="sistem-subtitle">Lista de Templates</h4>
                    </div>
                    <div class="col-xs-3 pull-right">
                        <? if (Util::request("exp_excel") == "") { ?>
                            <ul class="sub-menu">
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
                    <th>Local</th>
                    <th>Texto</th>
                    <th></th>
                    </thead>
                    <tbody>
                        <?php
                        $prefixo = "p1_";
                        $filtro = "";

                        if ($codigoSelecionado != "") {
                            $strfilt = trim(str_replace("'", "''", $codigoSelecionado));
                            $filtro .= " and id_componente_template = '" . $strfilt . "'";
                        }

                        if ($field_order != "") {
                            $filtro.= " order by " . $field_order . " " . $field_order_type;
                        }

                        $sql = " select c.nome as nome_componente, t.* from custom.template_texto t inner join custom.componente_template c on t.id_componente_template=c.id where 1 = 1 " . $filtro;
                        $lista = connAccess::fetchData($oConn, $sql);

                        //print_r($lista);

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

                            $img = "edit.png";
                            $title = "Editar";
                            ?>
                            <tr>
                                <td><?= strlen($item["nome_componente"]) > 50 ? substr($item["nome_componente"], 0, 47) . "..." : $item["nome_componente"] ?></td>
                                <td><?= $item["texto"] ?></td>
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
                                            <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId")                        ?>">
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
        </div><!-- Enc Col -->
    </div><!-- End Row -->
</form>
<script >
    function load(id)
    {
        var f = document.forms[0];
        f.action = "index.php?pag=template_texto&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }

    function excluir(id)
    {
        if (!confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
            return;

        var f = document.forms[0];
        f.action = "delete.php?pag=template_texto&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();

    }

</script>