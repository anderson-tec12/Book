<?php

require_once("inc_item_componente.php");

$ur = Util::paginaAtual($_REQUEST, "url,urlnoId");
$_SESSION["urlant"] = $ur;
$_SESSION["array_querie_ant"] = Util::paginaAtual($_REQUEST, "url,urlnoId", false);

$field_order_type = Util::request("field_order_type");
$field_order = Util::request("field_order");
?>

<?php Util::mensagemCadastro() ?>


<form method="post" name="frm" action="index.php?pag=custom.item_componente&mod=<?php echo Util::request("mod") ?>">
    <input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >

    <div class="row">
        <div class="col-xs-12">
            <h1 class="sistem-title">Elementos do Layout</h1>
            <div class="form-inline">
                <h4 class="sistem-subtitle">Filtrar por:</h4>

                <label class="sr-only" for="nome">Nome</label>
                <input type="text" placeholder="Nome" class="form-control" name="nome" value="<?= Util::request("nome") ?>">

                <label class="sr-only" for="field_order">Identificação</label>
                <select placeholder="" class="form-control" name="field_order">
                  <option value="id" <? if ($field_order == "id"){ echo ( " selected "); } ?>>ID</option>
                  
                        <option value="nome" <? if ($field_order == "nome"){ echo ( " selected "); } ?>>Nome</option>

                </select>
                <label class="sr-only" for="field_order_type">Ordena��o</label>
                
                <select placeholder="" class="form-control" name="field_order_type">
                    <option value="asc" <? if ($field_order_type == "asc"){ echo ( " selected "); } ?>>Ascendente</option>
                    <option value="desc" <? if ($field_order_type == "desc"){ echo ( " selected "); } ?>>Descendente</option>
                </select>
               
                <button type="button" class="btn btn-primary botao" value="Pesquisar" onclick="document.frm.submit()">Buscar</button>
                
            </div><!-- End Form -->
        </div><!-- End Col 12 -->
    </div><!-- End Row -->

    
    <div class="row">
        <div class="col-xs-12">
          <div class="bs-example">
            
            <div class="row">
                
            <div class="col-xs-3">
                <h4 class="sistem-subtitle">Lista Componentes</h4>
            </div>
                
            <div class="col-xs-3 pull-right">
                <? if ( Util::request("exp_excel") == "" ) { ?>
                <ul class="sub-menu">
                    <li class="sub-menu-item">
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
                <? } ?>
              </div>
            </div><!-- End Row -->
            
            <table class="table table-hover table-condensed">
                <thead>
                    <td>ID</td>
                    <td>Nome</td>
                </thead>
                
                <tbody>
                    <?php
                        $prefixo = "p1_";
                        $filtro = "";
                        
                        if (Util::request("codigo") != "") {
                            $strfilt = trim(str_replace("'", "''", Util::request("codigo")));
                            $filtro .= " and p.codigo like '%" . $strfilt . "%' ";
                        }

                        if (Util::request("nome") != "") {
                            $strfilt = trim(str_replace("'", "''", Util::request("nome")));
                            $filtro .= " and p.nome like '%" . $strfilt . "%' ";
                        }
                        
                        if ( $field_order != "" ){
                            $filtro.= " order by "  . $field_order . " " .  $field_order_type;
                        }
                        
                        $sql = " select * from custom.item_componente p where 1 = 1 ";
                        
                        $lista = connAccess::fetchData($oConn, $sql);
                        $inicio = 0;
                        $total = Util::NVL(count($lista),0);
                        $fim = 1;
                        
                        $tmp = SetaRsetPaginacao(Util::NVL(Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"), constant("K_PAG_MINIMUN")),
                        Util::NVL(Util::getParam($_REQUEST,$prefixo."selPagina"),1),$total,$inicio,$fim);
                        
                        $z = 0 ;$tarr = explode("_",$tmp);
                        $inicio = $tarr[0];
                        $fim = $tarr[1];
                        
                        if ( Util::request("exp_excel") == "1" ) {
                            $fim = count($lista);                      
                        }
                        
                        for ($z =0; $z<= $fim ; $z++){
                            if ($z >= $fim)
                                break;
      
                            if ($z < $inicio)
                                continue;
      
                            $item  = $lista[$z];
                            $img = "edit.png";
                            $title = "Editar";
                        ?>
                        <tr>
                            <td><?=  Util::numeroTela( $item["id"], true);  ?></td>
                            <td><?= $item["nome"] ?></td>
                            
                            <? if ( Util::request("exp_excel") == "" ) { ?>
                                <td>
                                    <a href="#" onclick="load('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <span class="icon icon-action icon-pencil text-warning"></span>
                                    </a>
                                    <a href="#"  onclick="excluir('<?php echo $item["id"] ?>');" class="action" data-toggle="tooltip" data-placement="top" title="Excluir">
                                        <span class="icon icon-action icon-remove2 text-danger"></span>
                                    </a>
                                </td>
                            <?php } ?>                    
                        <?
                        }
                    ?>
                    <? if (Util::NVL(count($lista),0) == 0){ ?>
                         <tbody>
                            <tr>
                                <td colspan="12" class="f-tabela-texto">
                                    Não há dados a serem exibidos!
                                </td>
                            </tr>   
                        </tbody>
                    <? } ?>
                        
                    <? if ( Util::request("exp_excel") == "" ) { ?>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <div class="form-inline">
                                        <div class="form-group form-group-sm">
                                            <input name="url" type="hidden" value="<?php //echo Util::paginaAtual("url,urlnoId") ?>">
                        <?php 
                            MostrarPaginacao(Util::NVL( Util::getParam($_REQUEST, $prefixo."selQtdeRegistro"),constant("K_PAG_MINIMUN")),
                            Util::NVL(Util::getParam($_REQUEST, $prefixo."selPagina"),1),$total,"frm", true, true, $prefixo);
                        ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>                        
                    <? } ?>
                </tbody>          
            </table>
          </div><!-- End BS-Example -->
        </div><!-- Enc Col -->
    </div><!-- End Row -->
    
</form>

<script >
    function load(id)
    {
        var f = document.forms[0];
        //f.action = "cad_custom.item_componente.php?acao=<?php echo Util::$LOAD ?>&id="+id;
        f.action = "index.php?pag=item_componente&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();
    }

    function excluir(id)
    {
        if (!confirm("Deseja realmente excluir?. Isto ir&aacute; remover tamb&eacute;m todas as depend&ecirc;ncias deste registro."))
            return;

        var f = document.forms[0];
        f.action = "delete.php?pag=custom.item_componente&mod=cad&acao=<?php echo Util::$LOAD ?>&id=" + id + "&tipo=<?= Util::request("tipo") ?>";
        f.submit();

    }
    
</script>