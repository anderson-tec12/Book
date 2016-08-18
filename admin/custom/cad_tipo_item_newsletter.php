<?php

require ("../sistema/library/upload/UploadImage.php");
require ("../sistema/library/image/ImageHelper.php");


$id         = Util::request("id");
$acao       = Util::request("acao");
$ispostback = Util::request("ispostback");

$registro      = $oConn->describleTable("custom.tipo_item_newsletter");
$visible_image = false;

$dir_image    = "../files/templates/newsletter/";
$heigth_image = 48;


if ($ispostback) {

    if ($id != "") $registro = connAccess::fastOne($oConn, "custom.tipo_item_newsletter", " id = ".$id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::numeroBanco(Util::request($prefixo."id"));

    //$registro["codigo"] = Util::request($prefixo."codigo");

    $registro["nome"] = Util::request($prefixo."nome");

    $registro["obs"] = Util::request($prefixo."obs");

    $imageHelper = new ImageHelper();

    if (isset($_FILES['file_imagem']['name']) && $_FILES["file_imagem"]["error"] == 0) {

        //Remove imagem antiga no caso de edição
        if ($registro["imagem"] != null && $registro["imagem"] != "") {
            unlink($dir_image.$registro["imagem"]);
        }

        $uploadImagem = new UploadImage();

        //Realiza upload da imagem
        $nome_arquivo = $uploadImagem->doUploadFile($_FILES["file_imagem"], $dir_image);

        //Salva a imagem redimensionada para $heigth_image.px
        $registro["imagem"] = $imageHelper->saveResizeImage($dir_image, $nome_arquivo, null, $heigth_image, false);
    }
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    if (!@$registro["id"]) {

        $registro["id"] = connAccess::Insert($oConn, $registro, "custom.tipo_item_newsletter", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.tipo_item_newsletter", "id");
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback              = "";

    $acao = "LOAD";
    $id   = $registro["id"];
}

if ($acao == "DEL" && $id != "") {

    $registro = connAccess::fastOne($oConn, "custom.tipo_item_newsletter", " id = ".$id);

    connAccess::Delete($oConn, $registro, "custom.tipo_item_newsletter", "id");

    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";

    $id         = "";
    $registro   = $oConn->describleTable("custom.tipo_item_newsletter");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro      = connAccess::fastOne($oConn, "custom.tipo_item_newsletter", " id = ".$id);
    $visible_image = true;
}
?>
<?
Util::mensagemCadastro(85);
?>

<div class="row">
    <div class="col-xs-8">
        <h1 class="sistem-title">custom.tipo_item_newsletter</h1>
        <p>Campos com * são de preenchimento obrigatório.</p>

        <form method="post" enctype="multipart/form-data" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
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
                $eh_primarykey   = True;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["id"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_id" >
                    <div class="form-group">
                        <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>
                        <span class="mostrapk"><?= $registro["id"] ?></span>
                        <input type="hidden"  name="id" value="<?= $registro["id"] ?>">
                    </div>
                </div>


                <?
                $eh_primarykey   = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["codigo"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_codigo" >
                    <div class="form-group">
                        <label for="codigo">Código<span class="campoObrigatorio" > *</span></label>

                        <input type="text"  name="codigo" value="<?= $registro["codigo"] ?>"  class="form-control" maxlength="" disabled="false">

                    </div>
                </div>


                <?
                $eh_primarykey   = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["nome"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_nome" >
                    <div class="form-group">
                        <label for="nome">Nome<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <input type="text"  name="nome" value="<?= $registro["nome"] ?>"  class="form-control" maxlength="">

                    </div>
                </div>


                <?
                $eh_primarykey   = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["imagem"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_imagem" >
                    <div class="form-group">
                        <label for="imagem">Imagem<span class="campoObrigatorio" > * </span></label>
                        <input type="hidden" name="input_image_hidden" id="input_image_hidden" value="<?= $registro["imagem"] ?>">
                        <input type="file" name="file_imagem" accept="image/*" id="file_imagem" onchange="preview(this, 'input_image_hidden','img_imagem');">
                        <br>
                        <div class="imagem" id="div_imagem" <?
                echo (!$visible_image ? "style='display:none'" : "")
                ?>>
                            <img id="img_imagem" height="<?= $heigth_image ?>" name="img_imagem" src= <?= $dir_image.$registro["imagem"] ?>>
                        </div>
                    </div>
                </div>

                <?
                $eh_primarykey   = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["obs"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>
                <div <? echo ($visible_in_html); ?> id="tr_obs" >
                    <div class="form-group">
                        <label for="obs">Observações<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <textarea id="obs" name="obs" class="form-control"
                                  ><?= $registro["obs"] ?></textarea>

                    </div>
                </div>


                                        <!-- <div class="divMsgObrigatorio"><?php //echo constant("K_MSG_OBR")        ?></div> -->
                <?php
                showButtons($acao, true);
                $enBtGrupo       = " disabled ";
                try {
                    $id        = $registro["id"];
                    if ($id > 0) $enBtGrupo = "";
                } catch (Exception $exp) {
                    
                }
                ?>
            </div><!-- End fieldBox -->

        </form>
        <div class="interMenu">
            <?php botaoVoltar("index.php?mod=listar&pag=".Util::request("pag")."&tipo=".Util::request("tipo")) ?>
        </div>
    </div>
</div>
<script>
    function salvar()
    {
        var f = document.forms[0];
	    
        if (isVazio(f.codigo, 'Informe Código!')) {
            return false;
        }


        if (isVazio(f.nome, 'Informe Nome!')) {
            return false;
        }

        if(isVazio(f.input_image_hidden, 'Selecione a imagem!')){
            return false;
        }
		
        f.acao.value = "<?php echo ( Util::$SAVE) ?>";
        f.submit();
    }
   

    function novo()
    {
   	    
        var f = document.forms[0];
        document.location = f.action;
	
   	
    }
	
    function excluir()
    {
   	
        var f =   document.forms[0];
   	  
   	   
        if (f.id.value == "")
        {
            alert("Selecione um registro para excluir!");
            return;
        }
   	  
	  
        f.acao.value = "<?php echo Util::$DEL ?>";
        f.submit();
    }

    function preview(input, inputhidden) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $('#img_imagem').attr('src', e.target.result);



            };

            reader.readAsDataURL(input.files[0]);

            $('#'+inputhidden).val(input.files[0]['name']);

            //Pega os elementos que representam a div das imagens
            var image_div = document.getElementById( "div_imagem" ) ;

            //Apresenta a div das imagens
            image_div.style.display = "block";

        }
    }
</script>