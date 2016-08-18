<?php
require_once 'library/interfaces/interface_component.php';
require_once("inc_ferramenta.php");
require_once 'painel/avaliacao/template_avaliacao.php';
require_once 'painel/avaliacao/inc_template_avaliacao.php';

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("ferramenta");

$dir_image_icon = "../files/icons/";

if ($ispostback) {

    if ($id != "")
        $registro = connAccess::fastOne($oConn, "ferramenta", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");

    //$registro["codigo"] = Util::request($prefixo."codigo");

    $registro["titulo"] = Util::request($prefixo . "titulo");

    $registro["descricao"] = Util::request($prefixo . "descricao");

    $registro["instrucao_uso"] = Util::request($prefixo . "instrucao_uso");

    $registro["video"] = Util::request($prefixo . "video");

    $registro["palavra_chave"] = Util::request($prefixo . "palavra_chave");

    $registro["cor"] = Util::request($prefixo . "cor");

    $registro["id_icone1"] = Util::numeroBanco(Util::request($prefixo . "id_icone1"));

    $registro["id_icone2"] = Util::numeroBanco(Util::request($prefixo . "id_icone2"));
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    if (!@$registro["id"]) {

        $registro["id"] = connAccess::Insert($oConn, $registro, "ferramenta", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "ferramenta", "id");
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "DEL" && $id != "") {

    $registro = connAccess::fastOne($oConn, "ferramenta", " id = " . $id);
    connAccess::Delete($oConn, $registro, "ferramenta", "id");

    $_SESSION["st_Mensagem"] = "Registro excluÃ­do com sucesso!";

    $id = "";
    $registro = $oConn->describleTable("ferramenta");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "ferramenta", " id = " . $id);
}
?>
<?
Util::mensagemCadastro(85);
?>

<link href="library/select_image/dd.css" rel="stylesheet">

<div class="row">
    <div class="col-xs-12">
        <h1 class="sistem-title">Ferramenta</h1>

        <br/>

        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_template_analise">Template Análise</button>
                </div>
            </div><!-- End Col 6 -->
        </div><!-- End Row -->
        
        <br/>

        <p>Campos com * são de preenchimento obrigatório.</p>

        <form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
            <div class="fieldBox">

                <input type="hidden" name="acao" value="<?php echo $acao ?>">
                <input type="hidden" name="ispostback" value="1">
                <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"] ?>">
                <input type="hidden" name="tipo" value="<?php
                try {
                    echo Util::request("tipo");
                } catch (Exception $exp) {
                    
                }
                ?>">


                <?
                $eh_primarykey = True;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["id"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_id" >
                    <div class="form-group">
                        <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <span class="mostrapk"><?= $registro["id"] ?></span>
                        <input type="hidden"  name="id" value="<?= $registro["id"] ?>"  >

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["codigo"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_codigo" >
                    <div class="form-group">
                        <label for="codigo">Código<span class="campoObrigatorio" > *</span></label>

                        <input type="text"  name="codigo" value="<?= $registro["codigo"] ?>"  class="form-control" maxlength="30" readonly="true">

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["titulo"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_titulo" >
                    <div class="form-group">
                        <label for="titulo">Título<span class="campoObrigatorio" > *</span></label>

                        <input type="text"  name="titulo" value="<?= $registro["titulo"] ?>"  class="form-control" maxlength="300">

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["descricao"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_descricao" >
                    <div class="form-group">
                        <label for="descricao">Descrição<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <textarea id="descricao" name="descricao" class="form-control"
                                  ><?= $registro["descricao"] ?></textarea>

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["instrucao_uso"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_instrucao_uso" >
                    <div class="form-group">
                        <label for="instrucao_uso">Instruções de Uso<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <textarea id="instrucao_uso" name="instrucao_uso" class="form-control"
                                  ><?= $registro["instrucao_uso"] ?></textarea>

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["video"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_video" >
                    <div class="form-group">
                        <label for="video">Vídeo<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <input type="text"  name="video" value="<?= $registro["video"] ?>"  class="form-control" maxlength="300">

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["palavra_chave"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_palavra_chave" >
                    <div class="form-group">
                        <label for="palavra_chave">Palavras Chave<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <textarea id="palavra_chave" name="palavra_chave" class="form-control"
                                  ><?= $registro["palavra_chave"] ?></textarea>

                    </div>
                </div>


                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["id_icone1"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>


                <div <? echo ($visible_in_html); ?> id="tr_id_icone1" >
                    <div class="row">
                        <div class="col-xs-12">
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

                    </div><!-- End ROW -->
                </div>

                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["id_icone2"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_id_icone2" >
                    <div class="row">
                        <div class="col-xs-12">
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
                    </div>
                </div>

                <?
                $eh_primarykey = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["cor"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_cor" >
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="cor">Cor de Fundo</label>
                                <input type="text" name="cor" id="cor" maxlength="8" value="<?= $registro["cor"] ?>" class="form-control color" >
                            </div>
                        </div><!-- End Col 6 -->
                    </div><!-- End Row -->
                </div>

                <?php
                showButtons($acao, true);
                $enBtGrupo = " disabled ";
                try {
                    $id = $registro["id"];
                    if ($id > 0)
                        $enBtGrupo = "";
                } catch (Exception $exp) {
                    
                }
                ?>
            </div><!-- End fieldBox -->

            <div class="interMenu">
                <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo")) ?>
            </div>
        </form>
    </div>
</div>

<link href="<?= K_RAIZ ?>library/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">
<script src="http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js"></script>
<script src="custom/js/jquery.dd.min.js"></script>
<script language="JavaScript" src="<?= K_RAIZ ?>library/colorpicker/jscolor/jscolor.js"></script>
<script type="text/javascript" src="painel/avaliacao/js/template_avaliacao.js"></script>

<script>

    window.onload = displayColors;

    $(function () {
        setRaizSistema(<?= K_RAIZ ?>);
    });

    function salvar() {
        var f = document.forms[0];
        if (isVazio(f.codigo, 'Informe Código!')) {
            return false;
        }
        if (isVazio(f.titulo, 'Informe Título!')) {
            return false;
        }
        f.acao.value = "<?php echo ( Util::$SAVE) ?>";
        f.submit();
    }


    function novo() {
        var f = document.forms[0];
        document.location = f.action;
    }

    function excluir() {
        var f = document.forms[0];
        if (f.id.value == "") {
            alert("Selecione um registro para excluir!");
            return;
        }
        f.acao.value = "<?php echo Util::$DEL ?>";
        f.submit();
    }

    function displayColors() {
        var bgColor = $('#cor').css('background-color');
        var txtColor = $('#cor').css('color');
        $('.pr_view').css('background-color', bgColor);
        $('.pr_view').css("color", txtColor);
    }

    $('#cor').change(displayColors);
    $("#id_icone1").msDropDown();
    $("#id_icone2").msDropDown();

</script>

<!-- Modal bootstrap -->
<form method="post" action="" id="template_avaliacao_form">

    <input type="hidden" name="id_ferramenta" value=<?= $registro["id"] ?>>
    <input type="hidden" name="qtde_item_template_avaliacao" value="">
    <input type="hidden" name="qtde_sortable_template_avaliacao" value="">
    <input type="hidden" name="ordem_template_avaliacao" id="ordem" value="">

    <div class="modal fade bs-example-modal-lg" id="modal_template_analise" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Template de Análise (<?= $registro["titulo"] ?>)</h4>
                </div>

                <div class="modal-body">

                    <?
                    $templateAvaliacao = new TemplateAvaliacao($registro["id"]);
                    $templateAvaliacao->printHTML();
                    ?>

                    <div class="modal-footer">
                        <button id="btSalvarTemplateAvaliacao" type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>