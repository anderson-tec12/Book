<?

require_once("inc_componente_template.php");
require ('library/image/ImageHelper.php');
require ('library/upload/UploadImage.php');
require_once("inc_grupo_componente_template.php");

$id = Util::request("id");
$acao = Util::request("acao");
$acao2 = Util::request("acao2");

$ispostback = Util::request("ispostback");
$dir_image = "../files/componente_template/";
$dir_image_icon = "../files/icons/";

$registro = $oConn->describleTable("custom.componente_template");



if ($ispostback) {
    if ($id != "")
        $registro = connAccess::fastOne($oConn, "custom.componente_template", " id = " . $id);
    connAccess::preencheArrayForm($registro, $_POST, "id");

    $registro["id_modulo"] = Util::request("id_modulo");

    componente_template::carregaForm($registro);
}

if ($acao == "SAVE") {
    $imageHelper = new ImageHelper();
    connAccess::nullBlankColumns($registro);
    
    
    $registro["status"] = "salvo";
    if (!@$registro["id"]) {
        $registro["id"] = connAccess::Insert($oConn, $registro, "custom.componente_template", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.componente_template", "id");
    }
    
    componente_template::garanteTSVector($registro);

    componente_template::salvaItens($registro["id"], Util::request("lista_componentes"));

    $ar = explode(",", Util::request("lista_componentes"));
    
      for ($i = 0; $i < count($ar); $i++) {

            if (trim($ar[$i]) == "")
                continue;

            $campos = explode("|", $ar[$i]);

            componente_template::garanteTSVector_Item($campos[0]);
      }
    
    
    $_SESSION["st_Mensagem"] = "Capítulo salvo com sucesso!";
    $ispostback = "";
    $acao = "LOAD";
    $id = $registro["id"];

    die("<script>document.location.href='index.php?pag=componente_template&mod=cad&id=" . $id . "&acao=LOAD'; </script>");
}

if ($acao == "DEL" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.componente_template", " id = " . $id);
    connAccess::Delete($oConn, $registro, "custom.componente_template", "id");
    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
    $id = "";
    $registro = $oConn->describleTable("custom.componente_template");
    $ispostback = "";
}
//die ( "00 ". $acao2 );
if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.componente_template", " id = " . $id);

    if ($acao2 == "salvar_como") {
        $novo_nome = Util::request("txt_novonome");
        componente_template::salvarComo($registro["id"], $novo_nome);
        $_SESSION["st_Mensagem"] = "Novo template " . $novo_nome . " salvo com sucesso!";
    }
}
?>
<script src="custom/js/modernizr.2.6.2.min.js"></script>
<link href="custom/css/normalize.css" rel="stylesheet">
<link href="custom/css/bootstrap.min.css" rel="stylesheet">
<link href="custom/fonts/icon-fonts.css" rel="stylesheet">
<link href="custom/fonts/styletype.css" rel="stylesheet">
<link href="custom/css/style.css" rel="stylesheet">
<link href="custom/css/pen.css" rel="stylesheet">  
<link href="library/select_image/dd.css" rel="stylesheet"> 
<? Util::mensagemCadastro(85); ?>
<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>"  >




    <input type="hidden" name="acao2">
    <input type="hidden" name="acao" value="<?php echo $acao ?>">
    <input type="hidden" name="ispostback" value="1">
    <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"] ?>">
    <input type="hidden" name="tipo" value="<?php
    try {
        echo Util::request("tipo");
    } catch (Exception $exp) {
        
    }
    ?>">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="sistem-title">Capítulo do Livro</h1>
            <div class="panel panel-default">
                <div class="panel-heading">Capítulo</div>

                <div class="panel-body">
                    <? if ($registro["id"] != "") { ?>

                        <div class="form-inline pull-right">
                            <button type="button" name="btSalvarComo" id="btSalvarComo" onclick="salvar_como('<?= $registro["id"] ?>', this);" class="btn btn-warning btn-block">Salvar Como</button>
                        </div>
                    <? } ?>

                    <div class="form-inline pull-right">
                        <button type="button" onclick="salvar();" class="btn btn-primary btn-block">Salvar</button>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">

                            <div id="div_salvar_como" style="display:none">
                                <div class="form-group">
                                    <label for="txt_novonome">Informe o novo nome:</label><br>
                                    <input type="text" name="txt_novonome" id="txt_novonome" value="" class="form-control">

                                </div>

                                <div class="form-inline pull-right">
                                    <input type="button" name="btConfirmar" id="btConfirmar" class="btn btn-primary" value="Confirmar"  onclick="salvar_como('<?= $registro["id"] ?>', this);">
                                </div>

                                <br/>
                                <br/>
                                <br/>
                            </div>
                        </div>

                        <?
                        $eh_primarykey = True;
                        $visible_in_html = ' style="display:none" ';
                        if ($eh_primarykey && $registro["id"] == "") {
                            $visible_in_html = " style='display:none' ";
                        }
                        ?>
                        <div <? echo ($visible_in_html); ?> id="tr_id" >
                            <div class="form-group">
                                <label for="id">ID</label>
                                <span class="mostrapk"><?= $registro["id"] ?></span>
                                <input type="hidden"  name="id"  id="id" value="<?= $registro["id"] ?>" >
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="nome">Nome <span class="campoObrigatorio"> *</span></label>
                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" value="<?= $registro["nome"] ?>">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="id_ferramenta">Capítulo<span class="campoObrigatorio" style="display: none"> *</span></label>
                                <?
                                //$lista = connAccess::fetchData($oConn, "select id, titulo from ferramenta order by titulo"); 
                                //onchange="atualizaGrupo('ferramenta', this.value)"
                                $lista = connAccess::fetchData($oConn, "select id, titulo  from custom.capitulo order by titulo");
                             
                                ?>
                                <select   name="id_ferramenta" id="id_ferramenta" class="form-control"  >
                                    <option value="">--</option>
                                    <?
                                    Util::CarregaComboArray($lista, "id", "titulo", $registro["id_ferramenta"]);
                                    ?>
                                </select>
                            </div>

                        </div>
                        
                            
                        
                        
                        
                           <div class="col-xs-4">
                            <div class="form-group">
                                <label for="publicado">Estado<span class="campoObrigatorio" style="display: none"> *</span></label>
                                <?
                                $lista = array();
                                
                                $lista[count($lista)] = array("id"=>1,"titulo"=>"Publicado");
                                $lista[count($lista)] = array("id"=>2,"titulo"=>"Não Publicado");
                                ?>
                                <select   name="publicado" id="publicado" class="form-control" >
                                    <option value="">--</option>
                                    <?
                                    Util::CarregaComboArray($lista, "id", "titulo", $registro["publicado"]);
                                    ?>
                                </select>
                            </div>
                        </div>
                        
<? if ( false ) { ?>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="id_modulo">Módulo<span class="campoObrigatorio" style="display: none"> *</span></label>
                                <?
                                $lista = connAccess::fetchData($oConn, "select id, titulo || ' - ' || codigo as titulo from modulo order by titulo");
                                ?>
                                <select   name="id_modulo" id="id_modulo" class="form-control" onchange="atualizaGrupo('modulo', this.value)">
                                    <option value="">--</option>
                                    <?
                                    Util::CarregaComboArray($lista, "id", "titulo", $registro["id_modulo"]);
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="cor">Selecione a cor</label>
                                <input type="text" name="cor" id="cor" maxlength="8" value="<?= $registro["cor"] ?>" class="form-control color" >
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="grupo">Grupo<span class="campoObrigatorio" style="display: none"> *</span></label>
                                <select   name="id_grupo" id="select_grupo" class="form-control">
                                    <?
                                    if ($id != null) {

                                        $grupos = array();

                                        if (!empty($registro['id_ferramenta'])) {
                                            $grupos = inc_grupo_componente_template::buscaGruposPorFerramenta($registro['id_ferramenta']);
                                        } else {
                                            $grupos = inc_grupo_componente_template::buscaGruposPorModulo($registro['id_modulo']);
                                        }

                                        if (!empty($grupos)) {
                                            foreach ($grupos as $key => $grupo) {
                                                ?>
                                                <option value="<?= $grupo['id'] ?>" <?= $grupo['id'] == $registro['id_grupo'] ? "selected" : "" ?>><?= $grupo['nome'] ?></option>
                                                <?
                                            }
                                        } else {
                                            ?>
                                            <option value="">Grupo Padrão</option>
                                            <?
                                        }
                                    } else {
                                        ?>
                                        <option value="">--Selecione--</option>
                                        <?
                                    }
                                    ?>

                                </select>

                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="tipo">Tipo de Template<span class="campoObrigatorio" style="display: none"> *</span></label>
                                <?
                                $arr = array();
                                $arr[count($arr)] = array("id" => "template", "descr" => "Template");
                                $arr[count($arr)] = array("id" => "saiba_mais", "descr" => "Saiba Mais");
                                $arr[count($arr)] = array("id" => "termo_uso", "descr" => "Termos de Uso");
                                ?>
                                <select   name="tipo" id="tipo" class="form-control">
                                    <?
                                    Util::CarregaComboArray($arr, "id", "descr", $registro["tipo"]);
                                    ?>
                                </select>
                            </div>
                        </div>
<? } ?>

    <div class="col-xs-12">
                            <div class="form-group">
                                <label for="publicado">Autor<span class="campoObrigatorio" style="display: none"> *</span></label>
                                <?
                                $lista = connAccess::fastQuerie($oConn, "usuario", " nome is not null ", "nome");
                                ?>
                                <select   name="id_usuario_autor" id="id_usuario_autor" class="form-control" >
                                    <option value="">--</option>
                                    <?
                                    Util::CarregaComboArray($lista, "id", "nome", $registro["id_usuario_autor"]);
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea name="descricao" rows="3" class="form-control"><?= $registro["descricao"] ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="instrucoes">Palavras Chave</label>
                                <textarea name="instrucoes_uso" rows="3" class="form-control"><?= $registro["instrucoes_uso"] ?></textarea>
                            </div>
                        </div>
                    </div>
<? if ( false ) { ?>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="id_icone1">Icone Positivo</label>
                                <select name="id_icone1" id="id_icone1" class="form-control">
                                    <?
                                    $lista = connAccess::fetchData($oConn, " select id, nome, imagem from icone order by nome ");
                                    for ($i = 0; $i < count($lista); $i++) {
                                        $arr = $lista[$i];
                                        $url = $dir_image_icon . $arr["imagem"];
                                        echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $registro["id_icone1"]) );
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="id_icone1">Icone Negativo</label>
                                <select name="id_icone2" id="id_icone2" class="form-control">
                                    <?
                                    for ($i = 0; $i < count($lista); $i++) {
                                        $arr = $lista[$i];
                                        $url = $dir_image_icon . $arr["imagem"];
                                        echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $registro["id_icone2"]) );
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
<? } ?>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="id_icone1">Pré Visualização</label>
                                <button style="width: 100%; height: 60px;" id="pre_visualizar_botao"  type="button" class="btn btn-primary btn-lg" 
                                        data-toggle="modal" data-target="#modal_botoes">
                                    Preview
                                </button>

                            </div>
                        </div>
                    </div>
                </div><!-- End Row -->
            </div><!-- End Panel Body -->

            <!-- Painel Principal -->
            <div class="row">
                <div class="col-xs-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Itens do Layout</div>
                        <div class="panel-body">
                            <p>Arraste os elementos para o painel ao lado para montar o template.</p>
                            <div class="drag-container">
                                <?
                                $lista = connAccess::fetchData($oConn, " select * from custom.item_componente order by nome ");

                                for ($i = 0; $i < count($lista); $i++) {

                                    $item = $lista[$i];
                                    ?>
                                    <div class="drag" id="div_componente_<?= $item["id"] ?>">
                                        <div class="drag-img">
                                            <img height="48" class="icon-drag" title="<?= $item["nome"] ?>" src = "<?= "../files/templates/" . $item["imagem_miniatura"] ?>">
                                        </div>
                                        <div class="drag-span">
                                            <?= $item["nome"] ?>
                                        <!-- #ID#<?= $item["id"] ?>#ID# -->
                                        </div>
                                    </div>
                                <? } ?>

                            </div> <!-- .drag-container -->
                        </div>
                    </div>
                </div><!-- End Col 4 -->
                <div class="col-xs-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">Layout</div>
                        <div class="panel-body">
                            <p>Arrastre os blocos para cima ou para baixo para definir a ordem.</p>
                            <div class="drop-container" id="div_drop">
                                <?
                                $lista_itens = array();

                                if ($registro["id"] != "") {
                                    $lista_itens = connAccess::fetchData($oConn, " select i.*, ti.id as id_item, ti.texto, ti.titulo from custom.componente_template_item ti "
                                                    . "  left join custom.item_componente i on i.id = ti.id_item_componente "
                                                    . "  where ti.id_componente_template = " . $registro["id"] . " and coalesce(ti.status,'') not in ('rascunho') order by ti.ordem ");
                                }

                                if (count($lista_itens) <= 0) {
                                    ?> <p style="color: #909090;">Arraste os Elementos aqui!</p> <? } else { ?>
                                    <?
                                    for ($y = 0; $y < count($lista_itens); $y++) {
                                        componente_template::mostraDragDivGrande($lista_itens[$y]);
                                    }
                                    ?>

                                <? } ?>
                            </div>
                            <br>
                            <div class="lixeira">
                                Arraste aqui para apagar
                            </div> <!-- .lixeira -->
                            <div class="row">
                                <div class="pull-right">
                                    <div class="col-xs-12">

                                        <div class="form-inline pull-right">
                                            <button type="button" onclick="salvar();" class="btn btn-primary btn-block">Salvar</button>
                                        </div>

                                        <? if ($registro["id"]) { ?>
                                            <div class="form-inline pull-right">
                                                <span  class="btn btn-warning btn-block iframe_modal" data-toggle="modal" data-target=".bs-example-modal-lg">
                                                    Pré Visualizar
                                                </span>
                                            </div>
                                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" id="myModal">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">Ã—</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="myLargeModalLabel">PRÃ‰ VISUALIZAÃ‡ÃƒO</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe src="painel/pop_index.php?pag=editar_relato&ict=<?= $registro["id"] ?>&formato=html" width="940px" height="620px" frameborder="0"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Col 8 -->



                    <!-- Modal Pré visualização de botões-->
                    <div class="modal fade" id="modal_botoes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Preview</h4>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="">Pré Visualização 1</label>
                                        <div class="pr_view"
                                        <?
                                        if ($registro["cor"] != "") {
                                            echo(" style='background: #" . $registro["cor"] . "' ");
                                        }
                                        ?> ><!-- class="form-control" -->
                                            <span class="spn_icon spn_icon1"></span>
                                            <span class="spn_text spn_text1"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pré Visualização 2</label>
                                        <div class="pr_view"
                                        <?
                                        if ($registro["cor"] != "") {
                                            echo(" style='background: #" . $registro["cor"] . "' ");
                                        }
                                        ?> ><!-- class="form-control" -->
                                            <span class="spn_icon spn_icon2"></span>
                                            <span class="spn_text spn_text2"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pré Visualização 3</label>
                                        <div class="pr_view2">
                                            <span class="spn_icon spn_icon3"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pré Visualização 4</label>
                                        <div class="pr_view3"><!-- class="form-control" -->
                                            <span class="spn_icon spn_icon3"></span>
                                            <span class="spn_text spn_text3"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Miolo -->
    <input type="hidden" name="id_retorno" >
    <input type="hidden" name="id_item_componente" >
    <input type="hidden" name="lista_componentes" value="">


    <input type="hidden" name="campo_item_edit" id="campo_item_edit" >


    <div class="modal fade" id="myModalTextArea" onclick="save_edit()" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="save_edit()" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Texto</h4>
                </div>

                <div class="modal-body">
                    <div id="div_titulo_editar" style="display:none">
                        <label>Título</label><br>
                        <input name="txtDadosTitulo" id="txtDadosTitulo"
                               maxlength="300" style="width: 400px">
                        <br><br> <!-- txtDadosTitulo  txtDadosEditar -->
                        <label>Texto</label>
                    </div>

                    <textarea name="txtDadosEditar" id="txtDadosEditar"
                              style="width: 550px; height: 450px"></textarea>
                </div>
            </div>
        </div>

    </div>


    <div style="display:none">
        <input type="file" name="file_imagem" id="file_imagem" onchange="submitImagem(this)" >
        <input type="button" name="btUpload" id="btUpload" value="Upload" >
    </div>

</form>

<iframe src="" name="frame_item" id="frame_item"
<? if (Util::request("debug") == "1") { ?>
            style="width: 300px; height: 140px"
        <? } else { ?>
            style="display: none"
        <? } ?>
        ></iframe>




<div class="interMenu">
    <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo")) ?>
</div>
<link href="<?= K_RAIZ ?>library/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="<?= K_RAIZ ?>library/colorpicker/jscolor/jscolor.js"></script>

<script type="text/javascript">
            function editar_textarea(id) {

                var txtDadosEditar = document.getElementById("txtDadosEditar");
                document.getElementById("campo_item_edit").value = id;
                //txtDadosTitulo  txtDadosEditar  div_titulo_editar
                var obj = document.getElementById(id);
                txtDadosEditar.value = obj.value;

                var div_titulo_editar = document.getElementById("div_titulo_editar");
                div_titulo_editar.style.display = "none";

                var id_titulo = id.replace("input_", "input_titulo_");
                var campo_titulo = document.getElementById(id_titulo);
                tinymce.activeEditor.setContent(obj.value);//Quem diria, funciona!
                if (campo_titulo != null) {

                    var txtDadosTitulo = document.getElementById("txtDadosTitulo");
                    txtDadosTitulo.value = campo_titulo.value;
                    div_titulo_editar.style.display = "";
                }
            }

            function save_edit() {

                var txtDadosTitulo = document.getElementById("txtDadosTitulo");
                var txtDadosEditar = document.getElementById("txtDadosEditar");
                var campo_titulo = document.getElementById("txtDadosTitulo");
                var id = document.getElementById("campo_item_edit").value;

                var obj = document.getElementById(id);
                obj.value = tinymce.activeEditor.getContent(); // txtDadosEditar.value; 

                var id_titulo = id.replace("input_", "input_titulo_");
                var campo_titulo = document.getElementById(id_titulo);

                if (campo_titulo != null) {
                    campo_titulo.value = txtDadosTitulo.value;
                }

            }
            //rrend
            function salvar_como(id, bt) {
                var f = document.forms[0];
                if (bt.id.indexOf("btSalvarComo") > -1) {

                    document.getElementById("div_salvar_como").style.display = "";

                }
                if (bt.id.toLowerCase().indexOf("confirmar") > -1) {

                    if (isVazio(f.txt_novonome, "Informe o nome do template que serÃ¡ salvo!")) {
                        return false;
                    }
                    f.acao2.value = "salvar_como";
                    f.acao.value = "LOAD";
                    //alert("ooi ");
                    f.submit()

                }
            }


            function salvar()
            {
                var f = document.forms[0];

                var div_drop = document.getElementById("div_drop");

                if (isVazio(f.nome, 'Informe o Nome!')) {
                    return false;
                }

                if (f.id_ferramenta.value == "" && f.id_modulo.value == "") {
                    alert("Selecione a ferramenta ou módulo!");
                    return false;

                }


                // if (isVazio(f.id_ferramenta, 'Selecione a Ferramenta!')) {
                //     return false;
                // }

                var divs = div_drop.getElementsByTagName("div");

                var str_final = "";
                for (var i = 0; i < divs.length; i++) {

                    if (str_final != "")
                        str_final += ",";

                    str_final += getIDFromDropHTMLbyTag(divs[i].innerHTML, "#IDITEM#") + "|" + getIDFromDrop(divs[i]);

                }
                f.lista_componentes.value = str_final;
                f.acao.value = "<?php echo ( Util::$SAVE) ?>";
                
               // f.enctype = "application/x-www-form-urlencoded";
                f.enctype = "multipart/form-data";
                f.submit();
            }

            function getIDFromDrop(div) {

                var str = div.innerHTML;

                var ar = str.split("#ID#");

                return ar[1];
            }
            function getIDFromDropHTML(str) {

                var ar = str.split("#ID#");

                return ar[1];
            }
            function getIDFromDropHTMLbyTag(str, tag) {

                var ar = str.split(tag);

                return ar[1];
            }

            function generateUUID() {
                var d = new Date().getTime();
                var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                    var r = (d + Math.random() * 16) % 16 | 0;
                    d = Math.floor(d / 16);
                    return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
                });
                return uuid;
            }

            function OnStopDiv(event, ui, html, div) {

                var f = document.forms[0];
                var ID = getIDFromDropHTML(html);

                var div_drop = document.getElementById("div_drop");
                var divs = div_drop.getElementsByTagName("div");

                var strNewID = generateUUID();
                for (var i = 0; i < divs.length; i++) {
                    if (divs[i].id == null || divs[i].id == "") {
                        divs[i].id = strNewID;
                        break;
                    }
                }
                var div_final = document.getElementById(strNewID);

                f.id_retorno.value = strNewID;
                f.id_item_componente.value = ID; //getIDFromDrop(div_final);
                
                if ( getIDFromDrop(div_final) == undefined )
                    return;
                
                
                //alert("ID origem: " + ID + " - ID na final " +f.id_item_componente.value );


                var old_action = f.action;

                var url_frame = "custom/frame_template.php";


                f.acao2.value = "edit_item";
                f.action = url_frame;
                f.target = "frame_item";
                f.submit();

                f.target = "_self";
                f.action = old_action;

                // alert( div_final );



                //if (ui.draggable.element !== undefined) {
                // ui.draggable.element.droppable('enable');
                //}
                //$(this).droppable('disable');
                //ui.draggable.position({of: $(this),my: 'left top',at: 'left top'});
                //ui.draggable.draggable('option', 'revert', "invalid");
                //ui.draggable.element = $(this);
            }


            function preview(input, inputhedden, imgID) {
                if (input.files && input.files[0]) {

                    var reader = new FileReader();

                    reader.onload = function (e) {

                        $('#' + imgID).attr('src', e.target.result);

                    };

                    reader.readAsDataURL(input.files[0]);

                    $('#' + inputhedden).val(input.files[0]['name']);

                    //Pega os elementos que representam a div das imagens
                    //var image_div = document.getElementById( "div_imagem" ) ;

                    //Apresenta a div das imagens
                    //image_div.style.display = "block";

                }
            }

            function atualizaGrupo(tipo, idItem) {

                if (idItem !== null && idItem !== 'undefined') {

                    var paramentro = "";

                    if (tipo == 'ferramenta') {
                        paramentro = "id_ferramenta=" + idItem;
                        var selectModulo = document.getElementById('id_modulo');
                        selectModulo.selectedIndex = 0;
                    } else {
                        paramentro = "id_modulo=" + idItem;
                        var selectFerramenta = document.getElementById('id_ferramenta');
                        selectFerramenta.selectedIndex = 0;
                    }

                    var selectGrupo = document.getElementById('select_grupo');

                    selectGrupo.innerHTML = "<option>Carregando...</option>"

                    var xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            selectGrupo.innerHTML = xmlhttp.responseText;
                        }
                    }

                    xmlhttp.open("GET", "<?= K_RAIZ ?>custom/ajax_atualiza_combo_grupo_componente_template.php?" + paramentro, true);

                    xmlhttp.send();
                }
            }

</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js"></script>
<!--script src="js/jquery_and_jqueryui.js"></script-->
<script src="custom/js/drag_and_drop.js?t=12"></script>
<!-- <script src="custom/js/bootstrap.min.js"></script>-->
<!--script src="<?= K_RAIZ ?>library/select_image/jquery.dd.min.js"></script-->
<script src="custom/js/jquery.dd.min.js"></script>
<script type="text/javascript" src="painel/js/jquery.modal.colorbox.min.js"></script>

<script type="text/javascript">
            $("#id_icone1").msDropDown();
            $("#id_icone2").msDropDown();
</script>

<script type="text/javascript">     $('#nome').keyup(function () {
        var value = $(this).val();
        $('.spn_text').text(value);
    })
            .keyup();
    function displayIcons() {
        var singleValues = $('#id_icone2_title .fnone').attr('src');
        $('.spn_icon1').html('<img src="' + singleValues + '">');
    }
    $('#id_icone2').change(displayIcons);
    displayIcons();


    function displayIconsColor() {
        var singleValuesColor = $('#id_icone1_title .fnone').attr('src');
        $('.spn_icon2').html('<img src="' + singleValuesColor + '">');
    }
    $('#id_icone1').change(displayIconsColor);
    displayIconsColor();

    function displayIconsColor_2() {
        var singleValuesColor2 = $('#id_icone1_title .fnone').attr('src');
        $('.spn_icon3').html('<img src="' + singleValuesColor2 + '">');
    }
    $('#id_icone1').change(displayIconsColor_2);
    displayIconsColor_2();

    function displayColors() {
        var bgColor = $('#cor').css('background-color');
        var txtColor = $('#cor').css('color');
        $('.pr_view').css('background-color', bgColor);
        $('.pr_view').css("color", txtColor);
    }
    $('#cor').change(displayColors);
    //displayColors();
    window.onload = displayColors;
    function displayColors2() {
        var txtColor2 = $('#cor').css('background-color');
        $('.pr_view3').css("color", txtColor2);
    }
    $('#cor').change(displayColors2);
    window.onload = displayColors2;

    function fn_links_iframe() {


        $(document).ready(function () {
            $(".youtube_modal").colorbox({iframe: true, innerWidth: 960, innerHeight: 520});
            $(".vimeo_modal").colorbox({iframe: true, innerWidth: 960, innerHeight: 476});
            $(".iframe_modal").colorbox({iframe: true, innerWidth: "85%", height: "86%"});
            $(".iframe_short_modal").colorbox({imagem_modal: true, innerWidth: 800, height: 450});
        });

    }

    //  fn_links_iframe();  // style="display:none"

</script>

<div style="display:none">
    <iframe name="iframe_ajax" id="iframe_ajax" style="width: 400; height: 250px;  " ></iframe>
    <iframe name="iframe_ajax_limpar" id="iframe_ajax_limpar" style="width: 400; height: 250px;   " ></iframe>
</div>       
<!-- Editor TinyMCE -->
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<!-- Editor TinyMCE -->
<script type="text/javascript">
    function guid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                    .toString(16)
                    .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                s4() + '-' + s4() + s4() + s4();
    }
    function submitImagem(obj) {
        var f = document.frm;
        f.enctype = "multipart/form-data";
        var oldaction = f.action;
        f.target = "iframe_ajax";
        f.acao.value = "upload";
        f.action = "custom/ajax.php?g=" + guid();
        f.submit();

        f.action = oldaction;
        f.target = "_self";
    }

    function aplicaTinyMce() {


        tinymce.init({
            theme: "modern",
            language: 'pt_BR',
            height: 400,
            selector: '#txtDadosEditar',
            // Inserir imagem local
            plugins: ["image"],
            file_browser_callback: function (field_name, url, type, win) {
                if (type == 'image') {

                    document.forms[0].acao2.value = field_name + "|" + url + "|" + type;
                    //alert( field_name );
                    //alert("cheguei aqui ?");
                    $('#file_imagem').click();
                }
            },
            // Aumentar font do texto padrão
            setup:
                    function (ed) {
                        ed.on('init', function ()
                        {
                            this.getDoc().body.style.fontSize = '16px';
                        });
                    },
            // Configuração
            plugins: [
                "link image media save"
            ],
                    toolbar1: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media",
            image_advtab: true,
        });

    }

    aplicaTinyMce();

</script>
