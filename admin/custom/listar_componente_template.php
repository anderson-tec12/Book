<?php
//Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro
require_once("inc_componente_template.php");

$ur                           = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"]           = $ur;
$_SESSION["array_querie_ant"] = Util::paginaAtual($_REQUEST, "url,urlnoId", false);

$prefixo = "_p1";

$id_ferramenta    = Util::request("id_ferramenta");
$field_order_type = Util::request("field_order_type");
$field_order      = Util::NVL(Util::request("field_order"), "ordem");
$acao2            = Util::request("acao2");
$id_modulo = Util::request("id_modulo");


if ($acao2 == "salvar_ordenacao" && Util::request("str_itens") != "") {

    $ar = explode(",", Util::request("str_itens"));

    for ($i = 0; $i < count($ar); $i++) {

        $id_tmp = $ar[$i];

        $ordem    = Util::NVL(Util::request("ordem_".$id_tmp), "NULL");
        $sql_item = " update custom.componente_template set ordem = ".$ordem." where id = ".$id_tmp;

        connAccess::executeScalar($oConn, $sql_item);
    }

    $_SESSION["st_Mensagem"] = "Ordenação salva com sucesso!";
}


$rstipo = array();
$rstipo[ count($rstipo)] = array("id"=>"template","descr"=>"Template");
$rstipo[ count($rstipo)] = array("id"=>"saiba_mais","descr"=>"Saiba Mais");
$rstipo[ count($rstipo)] = array("id"=>"termo_uso","descr"=>"Termos de Uso");

?>
<?php Util::mensagemCadastro() ?>

<form method="post" name="frm"
      action="index.php?pag=componente_template&mod=<?php echo Util::request("mod") ?>">

    <input type="hidden" name="id_ferramenta" id="id_ferramenta" value="<?= $id_ferramenta ?>">
    <!--
    <input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
    -->
    <input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >
    <input type="hidden" name="acao2" value="" >
    <!-- Filtro -->

    <div class="fieldBox">

        <? if (Util::request("exp_excel") == "") { ?>
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="sistem-title">Páginas</h1>
                    <div class="form-inline">
                        <h4 class="sistem-subtitle">Filtrar por:</h4>
                        <?
                        if ( false ){
                        //Verifica se id_ferramenta j� foi selecionado
                        if ($id_ferramenta == NULL) {
                            //$id_ferramenta = 1;
                        }
                        $lista         = connAccess::fetchData($oConn, "select id, titulo from ferramenta order by titulo");
                        ?>
                        <select   name="select_ferramenta" id="select_ferramenta" class="form-control" onchange="updateferramenta()">
                            <option value="">Selecione uma ferramenta</option>
                            <?
                            Util::CarregaComboArray($lista, "id", "titulo", $id_ferramenta);
                            ?>
                        </select>
                        <?
                        //|| ' - ' || codigo
                          $lista = connAccess::fetchData($oConn, "select id, titulo  as titulo from modulo order by titulo");
                        ?>
                        <select   name="id_modulo" id="id_modulo" class="form-control" >
                            <option value="">Selecione um módulo</option>
                            <?
                            Util::CarregaComboArray($lista, "id", "titulo", $id_modulo);
                            ?>
                        </select>
                        
                        
                                <?
                              
                                ?>
                                <select   name="tipo" id="tipo" class="form-control">
                                     <option value="">Selecione um tipo</option>
                                    <?
                                    Util::CarregaComboArray($rstipo, "id", "descr", Util::request("tipo"));
                                    ?>
                                </select>
                        <? } ?>
                        <input type="text" class="form-control" name="nome" id="nome"
                               maxlength="300"
                               placeholder="Filtrar por nome" value="<?=Util::request("nome")?>" >
                        </div>
                        <div class="form-inline">
                        <h4 class="sistem-subtitle">Ordenar por:</h4>
                        <select name="field_order" class="form-control">
                            <option value="ordem" <?
                        if ($field_order == "ordem") {
                            echo ( " selected ");
                        }
                            ?>>Ordenação</option>
                            <option value="nome" <?
                                if ($field_order == "nome") {
                                    echo ( " selected ");
                                }
                            ?>>Nome</option>
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
                                <h4 class="sistem-subtitle">Lista de Páginas</h4>
                            </div>


                            <div class="col-xs-3 pull-right">
                                <ul class="sub-menu">
                                    <li class="sub-menu-item">
                                        <a href="#" onclick="salvarOrdenacao();"
                                           class="action" data-toggle="tooltip" data-placement="left" title="Salvar Ordenação">
                                            <span class="icon icon-numbered-list text-success"></span>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="#" onclick="openPagina('cad','<?= Util::request("pag") ?>','');"
                                           class="action" data-toggle="tooltip" data-placement="bottom" title="Criar Novo">
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
                    <table class="table table-hover table-condensed"    <? if (Util::request("exp_excel") == "") { ?> border="0" <? } else { ?>  border="1" <? } ?>	>
                        <thead>
                        <td>ID</td>
                        <td>Nome</td>
                        <td>Tipo</td>
                        <td>Módulos</td>
                        <td style="width: 40px">Ordenação</td>
                        <? if (Util::request("exp_excel") == "") { ?>
                            <td></td>
                        <? } ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $prefixo = "p1_";

                            $filtro = "";


                            if (Util::request("nome") != "") {

                                $strfilt = trim(str_replace("'", "''", Util::request("nome")));

                                $filtro .= " and upper(p.nome) like upper('%".$strfilt."%') ";
                            }


                            if (Util::request("modulos") != "") {

                                $strfilt = trim(str_replace("'", "''", Util::request("modulos")));

                                $filtro .= " and p.modulos like '%".$strfilt."%' ";
                            }

                            if (Util::request("tipo") != "") {

                                $strfilt = trim(str_replace("'", "''", Util::request("tipo")));

                                $filtro .= " and p.tipo = '".$strfilt."' ";
                            }
                            
                            if ( $id_ferramenta != "" ){
                                
                                $filtro .= " and id_ferramenta = ".$id_ferramenta ;
                            }
                            if ( $id_modulo != "" ){
                                
                                $filtro .= " and id_modulo = ".$id_modulo ;
                            }

                            if ($field_order != "") {
                                $filtro.= " order by ".$field_order." ".$field_order_type;
                            }
                            $sql = " select * from custom.componente_template p where 1 = 1  and coalesce(status,'') not in ('rascunho') ".$filtro;

                            $lista = connAccess::fetchData($oConn, $sql);

                            $inicio = 0;
                            $total  = Util::NVL(count($lista), 0);
//print(  $this->result);
                            $fim    = 1;

//die (NVL(request("selQtdeRegistro"), constant("K_PAG_MINIMUN"))."------");
                            $tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), constant("K_PAG_MINIMUN")),
                                Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"), 1), $total, $inicio, $fim);

                            $str_itens = "";
                            $z         = 0;
                            $tarr      = explode("_", $tmp);
                            $inicio    = $tarr[0];
                            $fim       = $tarr[1];

                            if (Util::request("exp_excel") == "1") {
                                $fim = count($lista);
                            }

                            for ($z = 0; $z <= $fim; $z++) {
                                if ($z >= $fim) break;

                                if ($z < $inicio) continue;

                                $item = $lista[$z];

                                if ($str_itens != "") $str_itens .= ",";

                                $str_itens .= $item["id"];

                                $img   = "edit.png";
                                $title = "Editar";
                                ?>
                                <tr>
                                    <td><?= Util::numeroTela($item["id"], true); ?></td>
                                    <td><?= $item["nome"] ?></td>
                                    <td><?= Util::getDescByCOD($rstipo, "id", "descr", $item["tipo"]); ?></td>
                                    <td><?= $item["tx_modulos"] ?></td>
                                    <td>
                                        <? if (Util::request("exp_excel") != "") { ?><?= $item["ordem"] ?><? } else { ?>
                                            <input type="text" id="ordem_<?= $item["id"] ?>" name="ordem_<?= $item["id"] ?>" maxlength="8" value="<?= $item["ordem"] ?>"
                                                   class="form-control input-sm input-size-mini">
                                               <? } ?>

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


                            <?php }
                            ?>

                            <?php if (Util::NVL(count($lista), 0) == 0) { ?>

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
                                    <td colspan="5">
                                        <div class="form-inline">
                                            <div class="form-group form-group-sm">
                                                <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId")              ?>">
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
        ///f.action = "cad_custom.componente_template.php?acao=<?php echo Util::$LOAD ?>&id="+id;
        f.action =  "index.php?pag=componente_template&mod=cad&acao=<?php echo Util::$LOAD ?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }

    function excluir(id)
    {
        if (! confirm("Deseja realmente excluir?. Isto irá remover também todas as dependências deste registro."))
            return;
		
        var f = document.forms[0];
        f.action =  "delete.php?pag=componente_template&mod=cad&acao=<?php echo Util::$LOAD ?>&id="+id+"&tipo=<?= Util::request("tipo") ?>";
        f.submit();
		
    }

    function updateferramenta(){
        var valor_selecionado = document.getElementById('select_ferramenta').value;
        var input_id_ferramenta = document.getElementById('id_ferramenta');
        input_id_ferramenta.value = valor_selecionado;
        //alert(valor_selecionado);
    }

</script>