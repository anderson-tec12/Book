<?php
//Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro
require_once("inc_ferramenta.php");

$ur                           = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"]           = $ur;
$_SESSION["array_querie_ant"] = Util::paginaAtual($_REQUEST, "url,urlnoId", false);

$prefixo = "_p1";

$field_order_type = Util::request("field_order_type");
$field_order      = Util::request("field_order");
?>
<?php Util::mensagemCadastro() ?>

<form method="post" name="frm"
      action="index.php?pag=ferramenta&mod=<?php echo Util::request("mod") ?>">

    <input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
    <input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >
    <!-- Filtro -->

    <div class="fieldBox">

        <? if (Util::request("exp_excel") == "") { ?>
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="sistem-title">Ferramenta</h1>
                    <div class="form-inline">
                        <h4 class="sistem-subtitle">Filtrar por:</h4>

                        <label class="sr-only" for="codigo">Código</label>
                        <input type="text" placeholder="Código" name="codigo" id="codigo" class="form-control" value="<?= Util::request("codigo") ?>"   maxlength="30">

                        <label class="sr-only" for="titulo">Título</label>
                        <input type="text" placeholder="Título" name="titulo" id="titulo" class="form-control" value="<?= Util::request("titulo") ?>"   maxlength="300">
                                <label class="sr-only" for="field_order">Ordenar por</label>
                                <select name="field_order" class="form-control">
                                    <option value="id" <?
                                        if ($field_order == "id") {
                                        echo ( " selected ");
                                        }
                                    ?>>ID</option>

                                    <option value="codigo" <?
                                        if ($field_order == "codigo") {
                                            echo ( " selected ");
                                        }
                                    ?>>Código</option>


                                    <option value="titulo" <?
                                        if ($field_order == "titulo") {
                                            echo ( " selected ");
                                        }
                                    ?>>Título</option>

                                </select>
                                <label class="sr-only" for="field_order_type">Ordenar por</label>
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
                        <input type="button" class="btn btn-primary" class="botao" value="Pesquisar" value="Buscar" onclick="document.frm.submit()">

                    </div><!-- End Form Filter-->
                </div><!-- End col 12 -->
            </div><!-- End Row -->
        <? } ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="bs-example">
                    <div class="row">

                        <? if (Util::request("exp_excel") == "") { ?>
                            <div class="col-xs-3">
                                <h4 class="sistem-subtitle">Lista de Ferramentas</h4>
                            </div>


                            <div class="col-xs-3 pull-right">
                                <ul class="sub-menu">
                                    <li class="sub-menu-item hidden">
                                        <a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','');"
                                           class="action" data-toggle="tooltip" data-placement="left" title="Criar Novo">
                                            <span class="icon icon-file2 text-new"></span>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','','html');" class="action" data-toggle="tooltip" data-placement="bottom" title="Imprimir">
                                            <span class="icon icon-print text-print"></span>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="" onclick="openPrint('listar','<?= Util::request("pag") ?>','','');" class="action" data-toggle="tooltip" data-placement="right" title="Exportar Excel">
                                            <span class="icon icon-file-excel text-export"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <? } ?>
                    </div><!-- End Row -->
                    <table class="table table-hover table-condensed"   <? if (Util::request("exp_excel") == "") { ?> border="0" <? } else { ?> border="1" <? } ?>	>
                        <thead>
                            <td>ID</td>
                            <td>Código</td>
                            <td>Título</td>
                            <td>Cor</td>
                            <? if (Util::request("exp_excel") == "") { ?>
                            <td></td>
                                <? } ?>
                        </thead>
                        <tbody>
                            <?php
                                $prefixo = "p1_";
                                $filtro = "";
                                if (Util::request("id") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("id")));
                                    $filtro .= " and p.id like '%".$strfilt."%' ";
                                }

                                if (Util::request("codigo") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("codigo")));
                                    $filtro .= " and p.codigo like '%".$strfilt."%' ";
                                }

                                if (Util::request("titulo") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("titulo")));
                                    $filtro .= " and p.titulo like '%".$strfilt."%' ";
                                }

                                if (Util::request("descricao") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("descricao")));
                                    $filtro .= " and p.descricao like '%".$strfilt."%' ";
                                }

                                if (Util::request("instrucao_uso") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("instrucao_uso")));
                                    $filtro .= " and p.instrucao_uso like '%".$strfilt."%' ";
                                }

                                if (Util::request("video") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("video")));
                                    $filtro .= " and p.video like '%".$strfilt."%' ";
                                }

                                if (Util::request("palavra_chave") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("palavra_chave")));
                                    $filtro .= " and p.palavra_chave like '%".$strfilt."%' ";
                                }

                                if (Util::request("cor") != "") {
                                    $strfilt = trim(str_replace("'", "''", Util::request("cor")));
                                    $filtro .= " and p.cor like '%".$strfilt."%' ";
                                }

                                if ($field_order != "") {
                                    $filtro.= " order by ".$field_order." ".$field_order_type;
                                }

                                $sql = " select * from ferramenta p where 1 = 1 ".$filtro;


                                $lista = connAccess::fetchData($oConn, $sql);

                                $inicio = 0;
                                $total  = Util::NVL(count($lista), 0);
    //print(  $this->result);
                                $fim    = 1;

//die (NVL(request("selQtdeRegistro"), constant("K_PAG_MINIMUN"))."------");
                                $tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), constant("K_PAG_MINIMUN")),
                                    Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"), 1), $total, $inicio, $fim);

                                $z      = 0;
                                $tarr   = explode("_", $tmp);
                                $inicio = $tarr[0];
                                $fim    = $tarr[1];

                                if (Util::request("exp_excel") == "1") {
                                    $fim = count($lista);
                                }

                                for ($z = 0; $z <= $fim; $z++) {
                                    if ($z >= $fim) break;

                                    if ($z < $inicio) continue;

                                    $item = $lista[$z];

                                    $img   = "edit.png";
                                    $title = "Editar";
                                    ?>
                                <tr>
                                    <td><?= Util::numeroTela($item["id"], true); ?></td>
                                    <td><?= $item["codigo"] ?></td>
                                    <td><?= $item["titulo"] ?></td>
									<td>
                                        <div class="bloco-falacias" style="background: #<?= $item["cor"] ?>">
                                    </td>
                                    <? if (Util::request("exp_excel") == "") { ?>
                                        <td>
                                            <a href="#" onclick="load('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <span class="icon icon-action icon-pencil text-warning"></span>
                                            </a>
                                        </td>
                                    <? } ?>
                                </tr>
                                <?php } ?>
                                <?php if (Util::NVL(count($lista), 0) == 0) { ?>

                                    <tr>
                                        <td colspan="8" class="f-tabela-texto">
                                            N&atilde;o h&aacute; dados a serem exibidos!
                                        </td>
                                    </tr>
                                <?php } ?>


                        </tbody>
                        <? if (Util::request("exp_excel") == "") { ?>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <div class="form-inline">
                                            <div class="form-group form-group-sm">
                                                <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId")        ?>">
                                                <?php
                                                MostrarPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), constant("K_PAG_MINIMUN")),
                                                    Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"), 1), $total, "frm", true, true, $prefixo);
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        <? } ?>
                    </table>
                </div><!-- End Bs Exemple -->
            </div><!-- End col 12 -->
        </div><!-- End Row -->


    </div><!-- END FIELDBOX -->

</form>
<script >
    function load(id)
    {
        var f = document.forms[0];
        ///f.action = "cad_ferramenta.php?acao=<?php echo Util::$LOAD ?>&id="+id;
        f.action =  "index.php?pag=ferramenta&mod=cad&acao=<?php echo Util::$LOAD ?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }

    function excluir(id)
    {
        if (! confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
            return;
		
        var f = document.forms[0];
        f.action =  "delete.php?pag=ferramenta&mod=cad&acao=<?php echo Util::$LOAD ?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
        f.submit();
		
    }

</script>