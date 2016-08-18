<?
require_once("inc_componente_template.php");
require ('library/image/ImageHelper.php');
require ('library/upload/UploadImage.php');

$id         = Util::request("id");
$acao       = Util::request("acao");
$ispostback = Util::request("ispostback");
$dir_image  = "../files/componente_template/";
$dir_image_icon     = "../files/icons/";

$registro = $oConn->describleTable("custom.componente_template");



if ($ispostback) {
    if ($id != "")
        $registro = connAccess::fastOne($oConn,
            "custom.componente_template", " id = ".$id);
        connAccess::preencheArrayForm($registro, $_POST, "id");
        componente_template::carregaForm($registro);
}

if ($acao == "SAVE") {
    $imageHelper = new ImageHelper();
    connAccess::nullBlankColumns($registro);
    $registro["status"] = "salvo";
    if (!@$registro["id"]) {
        $registro["id"] = connAccess::Insert($oConn, $registro,
                "custom.componente_template", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.componente_template", "id");
    }

    componente_template::salvaItens($registro["id"],
        Util::request("lista_componentes"));

    $_SESSION["st_Mensagem"] = "Template salvo com sucesso!";
    $ispostback              = "";
    $acao = "LOAD";
    $id   = $registro["id"];
}

if ($acao == "DEL" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.componente_template",
            " id = ".$id);
    connAccess::Delete($oConn, $registro, "custom.componente_template", "id");
    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
    $id         = "";
    $registro   = $oConn->describleTable("custom.componente_template");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.componente_template",
            " id = ".$id);
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
<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>" enctype="multipart/form-data" >
    <input type="hidden" name="acao" value="<?php echo $acao ?>">
    <input type="hidden" name="ispostback" value="1">
    <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"] ?>">
    <input type="hidden" name="tipo" value="<?php
    try {
        echo Util::request("tipo");
        } catch (Exception $exp) {
    } ?>">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="sistem-title">Templates</h1>
            <div class="panel panel-default">
                <div class="panel-heading">Template</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?
                                    $eh_primarykey   = True;
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
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" value="<?= $registro["nome"] ?>">
                                    </div>
                                </div>
                            </div><!-- End Row -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="id_icone1">Icone Positivo</label>
                                        <select name="id_icone1" id="id_icone1" class="form-control">
                                            <? $lista = connAccess::fetchData($oConn," select id, nome, imagem from icone order by nome ");
                                            for ( $i =0 ; $i < count( $lista )  ; $i++){
                                                    $arr = $lista[$i];
                                                    $url = $dir_image_icon. $arr["imagem"];
                                                    echo ( Util::populaComboTitulo($arr["id"],  $arr["nome"], $url, $registro["id_icone1"]) );
                                            }
                                             //Util::CarregaComboArray($lista, "id", "nome", $registro["id_icone1"]);
                                            ?>  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="id_icone1">Icone Negativo</label>
                                        <select name="id_icone2" id="id_icone2" class="form-control">
                                            <? //$lista = connAccess::fetchData($oConn," select id, nome, imagem from icone order by nome "); 
                                            for ( $i =0 ; $i < count( $lista )  ; $i++){
                                                $arr = $lista[$i];  
                                                $url = $dir_image_icon. $arr["imagem"];
                                                echo ( Util::populaComboTitulo($arr["id"],  $arr["nome"], $url, $registro["id_icone2"]) );
                                            }  //Util::CarregaComboArray($lista, "id", "nome", $registro["id_icone1"]);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- End ROW -->
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="cor">Selecione a cor</label>
                                        <input type="text" name="cor" id="cor" maxlength="8" value="<?= $registro["cor"]?>" class="form-control color" >
                                        
                                        <!--
                                        <label for="id_icone2" class="sr-only">Icone</label>
                                        <select name="id_icone2" id="id_icone2" class="form-control">
                                            <option value="1">Icon 1</option>
                                            <option value="2">Icon 2</option>
                                            <option value="3">Icon 3</option>
                                        </select>
                                        -->
                                    </div>
                                </div><!-- End Col 6 -->
                            </div><!-- End Row -->

                            <div class="row">
                                <div class="col-xs-12">
                                    
                                </div><!-- End Col 12 -->
                            </div><!-- End Row -->

                        </div><!-- End Col 3 -->

                        <div class="col-xs-3">
                            <div class="form-group">
                                <label for="">Pré Visualização 1</label>
                                <div class="pr_view" 
                                <? if ( $registro["cor"] != "" ){
                                    echo(" style='background: #". $registro["cor"]."' ");
                                 } ?> ><!-- class="form-control" -->
                                    <span class="spn_icon spn_icon1"></span>
                                    <span class="spn_text spn_text1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Pré Visualização 2</label>
                                <div class="pr_view" 
                                <? if ( $registro["cor"] != "" ){
                                    echo(" style='background: #". $registro["cor"]."' ");
                                 } ?> ><!-- class="form-control" -->
                                    <span class="spn_icon spn_icon2"></span>
                                    <span class="spn_text spn_text2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Pré Visualização 3</label>
                                <div class="pr_view" 
                                <? if ( $registro["cor"] != "" ){
                                    echo(" style='background: #". $registro["cor"]."' ");
                                 } ?> ><!-- class="form-control" -->
                                    <span class="spn_icon"></span>
                                    <span class="spn_text"></span>
                                </div>
                            </div>
                            <!-- <label for="descricao">Descrição</label>
                            <textarea name="descricao" rows="5" class="form-control"><?= $registro["descricao"] ?></textarea>
                            <label for="instrucoes">Instruções de Uso</label>
                            <textarea name="instrucoes_uso" rows="5" class="form-control"><?= $registro["instrucoes_uso"] ?></textarea> -->
                        </div>
                        <div class="col-xs-4">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" rows="4" class="form-control"><?= $registro["descricao"] ?></textarea>
                            <label for="instrucoes">Instruções de Uso</label>
                            <textarea name="instrucoes_uso" rows="5" class="form-control"><?= $registro["instrucoes_uso"] ?></textarea>
                        </div>
                        <div class="col-xs-2">
                            <label for="modulos">Módulos</label>
                            
                             <?
                                        //----------- CHECKBOXLIST para modulos -> Módulos---------------------------
                                   $has_query  = "1";   $field_query =  "select id, nome from componente where ( nome like '%ABCD%' or nome like '%Relatos%' ) order by nome";
                                   $has_list   = "0";   
                                   $field_query_val = "id";
                                   $field_query_text = "nome";

                                $rslista = array();

                                if ( $has_query ){        
                                        $rslista = connAccess::fetchData($oConn, $field_query); 
                                }

                                if ( !function_exists("get_list_modulos")){

                                     function get_list_modulos(){  return array(); }
                                }

                                if ( $has_list  ){    

                                        $rslista = get_list_modulos();  
                                        $field_query_val = "id";
                                        $field_query_text = "descr";
                                }

                                $arr_values = new ArrayList( 
                                       explode(",", $registro["modulos"] )
                                       );

                                for ( $i = 0; $i< count($rslista); $i++){

                                     $item = $rslista[ $i ];
                                     ?><br>
                                     <input type="checkbox" value="<?=$item[$field_query_val]?>" name="modulos_<?=$i?>" id="modulos_<?=$i?>"  
                                         <?  if (  $arr_values->contains( $item[$field_query_val] )){ echo ( " checked "); } ?>
                                     ><?=$item[$field_query_text]?>
                                     &nbsp;&nbsp;&nbsp;

                                     <?        
                                }        
                                ?>

                        </div>
                    </div><!-- End Row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group pull-right">
                                <button type="button" onclick="salvar();" class="btn btn-primary btn-block">Salvar</button>
                            </div>   
                        </div>
                    </div>
                </div><!-- End Panel Body -->
            </div><!-- End Panel -->
        </div>
    </div><!-- End Row -->
    <!-- Painel Principal -->
    <div class="row">
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">Itens do Layout</div>
                <div class="panel-body">
                    <p>Arraste os elementos para o painel ao lado para montar o template.</p>
                    <div class="drag-container">
                        <?
                        $lista           = connAccess::fetchData($oConn,
                                " select * from custom.item_componente order by nome ");

                        for ($i = 0; $i < count($lista); $i++) {

                            $item        = $lista[$i];
                            ?>
                            <div class="drag" id="div_componente_<?= $item["id"] ?>">
                                <div class="drag-img">
                                    <!-- <span class="drag-span"><img src="../files/icons/icon-drag-20.png" alt=""></span> -->
                                    <img height="48" class="icon-drag" title="<?=$item["nome"] ?>" src = "<?= "../files/templates/".$item["imagem_miniatura"] ?>">
                                </div>
                                <div class="drag-span">
                                    <?=$item["nome"] ?>
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
                            $lista_itens = connAccess::fetchData($oConn,
                                    " select i.*, ti.id as id_item, ti.texto from custom.componente_template_item ti "
                                    ."  left join custom.item_componente i on i.id = ti.id_item_componente "
                                    ."  where ti.id_componente_template = ".$registro["id"]." and coalesce(ti.status,'') not in ('rascunho') order by ti.ordem ");
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
                            <div class="col-xs-6">
                                <? if ( $registro["id"] ) { ?>
                                <button type="button" class="btn btn-warning btn-block" onclick="window.open('custom/preview_template.php?id=<?= $registro["id"] ?>')">
                                    <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Pré Visualizar
                                </button>
                                <? } ?>
                            </div>
                            <div class="col-xs-6">
                                <input type="hidden" name="lista_componentes" value="">
                                <button type="button" class="btn btn-primary btn-block" value="Salvar" onclick="salvar()">  
                     </div>     
                    </div>
            </div>
        </div>
    </div><!-- End Col 8 -->
    <!-- Miolo -->
    
    
    <input type="hidden" name="id_retorno" >
    <input type="hidden" name="acao2" >
    <input type="hidden" name="id_item_componente" >
    
</form>

<iframe src="" name="frame_item" id="frame_item" 
        <? if ( Util::request("debug") =="1" ) { ?>        
        style="width: 300px; height: 140px"
        <? } else { ?>
         style="display: none"
        <? } ?>
        ></iframe>
<div class="interMenu">
    <?php botaoVoltar("index.php?mod=listar&pag=".Util::request("pag")."&tipo=".Util::request("tipo")) ?>
</div>

<link href="<?= K_RAIZ ?>library/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="<?= K_RAIZ ?>library/colorpicker/jscolor/jscolor.js"></script>

<script type="text/javascript">
    function salvar()
    {
        var f = document.forms[0];

        var div_drop = document.getElementById("div_drop");
	    
        if (isVazio(f.nome ,'Informe Template!')){ return false; }
		
        var divs = div_drop.getElementsByTagName("div");
        var str_final = "";
          
        for ( var i = 0; i < divs.length; i++){
              
            if ( str_final != "")
                str_final +=",";
                  
            str_final += getIDFromDropHTMLbyTag(  divs[i].innerHTML,"#IDITEM#" )+"|"+getIDFromDrop( divs[i] );
              
        }
        f.lista_componentes.value = str_final;
        f.acao.value = "<?php echo ( Util::$SAVE) ?>";
        f.submit();
    }
   
    function getIDFromDrop(div){
       
        var str = div.innerHTML;
       
        var ar = str.split("#ID#");
       
        return ar[1];
    }
    function getIDFromDropHTML(str){
       
        var ar = str.split("#ID#");
       
        return ar[1];
    }
     function getIDFromDropHTMLbyTag(str, tag ){
       
        var ar = str.split(tag);
       
        return ar[1];
    }
       
 function generateUUID(){
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
}
       
       
 function OnStopDiv (event, ui, html, div ) {
    
    var f = document.forms[0];
    var ID = getIDFromDropHTML( html  );
    
    var div_drop = document.getElementById("div_drop");
    var divs = div_drop.getElementsByTagName("div");
    
    var strNewID = generateUUID();
    for ( var i = 0; i < divs.length; i++){
              if (divs[i].id == null || divs[i].id == ""){
                     divs[i].id =  strNewID;
                     break;
              }
    }
    var div_final = document.getElementById(strNewID);
    
    f.id_retorno.value = strNewID;
    f.id_item_componente.value = getIDFromDrop(div_final);
    
    
    var old_action = f.action;
    
    var url_frame = "custom/frame_template.php";
    
    
    f.acao2.value = "edit_item";
    f.action = url_frame;
    f.target="frame_item";
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

                $('#'+imgID).attr('src', e.target.result);

            };

            reader.readAsDataURL(input.files[0]);

            $('#'+inputhedden).val(input.files[0]['name']);

            //Pega os elementos que representam a div das imagens
            //var image_div = document.getElementById( "div_imagem" ) ;

            //Apresenta a div das imagens
            //image_div.style.display = "block";

        }
    }
       
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js"></script>
<!--script src="js/jquery_and_jqueryui.js"></script-->
<script src="custom/js/drag_and_drop.js?t=12"></script>
<script src="custom/js/bootstrap.min.js"></script>
<script src="<?= K_RAIZ ?>library/select_image/jquery.dd.min.js"></script>
<script type="text/javascript">

$("#id_icone1").msDropDown();
$("#id_icone2").msDropDown();

</script>
<script type="text/javascript">
    $('#nome').keyup(function() {
        var value = $(this).val();
        $('.spn_text').text(value);
    })
    .keyup();

    function displayIcons() {
        var singleValues = $('#id_icone2_title .fnone').attr('src');
        $('.spn_icon').append('<img src="' + singleValues + '">');
        }
    $('#id_icone1').change(displayIcons);
    displayIcons();

    function displayColors() {
        var bgColor = $('#cor').css('background-color');
        var txtColor = $('#cor').css('color');
        $('.pr_view').css('background-color', bgColor);
        $(".pr_view").css("color", txtColor);
        }
    $('#cor').change(displayColors);
    //displayColors();
window.onload = displayColors;
</script>