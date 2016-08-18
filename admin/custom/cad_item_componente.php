<?php
require_once("inc_item_componente.php");

require_once ("library/upload/UploadImage.php");
require_once ("library/image/ImageHelper.php");

$id         = Util::request("id");
$acao       = Util::request("acao");
$ispostback = Util::request("ispostback");

$registro = $oConn->describleTable("item_componente");

$dir_image     = "../files/templates/";
$visible_image = false;

$heigth_image     = 256;
$heigth_miniature = 48;


if ($ispostback) {

    if ($id != "")
            $registro = connAccess::fastOne($oConn, "custom.item_componente",
                " id = ".$id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"]     = Util::numeroBanco(Util::request($prefixo."id"));
    $registro["codigo"] = Util::request($prefixo."codigo");
    $registro["nome"]   = Util::request($prefixo."nome");
    $registro["obs"]    = Util::request($prefixo."obs");

    $imageHelper = new ImageHelper();

    if (isset($_FILES['file_imagem']['name']) && $_FILES["file_imagem"]["error"] == 0) {

        //Remove imagem antiga no caso de edição
        if ($registro["imagem"] !== "") {
            unlink($dir_image.$registro["imagem"]);
        }

        //Remove imagem_miniatura antiga no caso de edição
        if ($registro["imagem_miniatura"] !== "") {
            unlink($dir_image.$registro["imagem_miniatura"]);
        }

        $uploadImagem = new UploadImage();

        //Realiza upload da imagem
        $nome_arquivo = $uploadImagem->doUploadFile($_FILES["file_imagem"],
            $dir_image);

        //Salva a imagem redimensionada para $heigth_image.px
        $registro["imagem"] = $imageHelper->saveResizeImage($dir_image,
            $nome_arquivo, null, $heigth_image, false);

        //Salva a miniatura da imagem com 150px
        $registro["imagem_miniatura"] = $imageHelper->saveResizeImage($dir_image,
            $nome_arquivo, null, $heigth_miniature, true);
    }

    /* if (isset($_FILES['file_imagem_miniatura']['name']) && $_FILES["file_imagem_miniatura"]["error"] == 0) {

      if (!$registro["imagem_miniatura"] !== "") {
      unlink($dir_image.$registro["imagem_miniatura"]);
      $imageHelper->deleteMiniature($dir_image,
      $registro["imagem_miniatura"]);
      }

      $uploadImagem                 = new UploadImage();
      $registro["imagem_miniatura"] = $uploadImagem->doUploadFile($_FILES["file_imagem_miniatura"],
      $dir_image);

      $imageHelper->saveMiniature($dir_image,
      $registro["imagem_miniatura"], 150);
      } */
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    if (!@$registro["id"]) {
        $registro["id"] = connAccess::Insert($oConn, $registro,
                "custom.item_componente", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.item_componente", "id");
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";

    $ispostback = "";

    $acao = "LOAD";

    $id = $registro["id"];

    die("<script>document.location.href='index.php?acao=LOAD&id=".$id."&pag=".Util::request("pag")."&mod=".Util::request("mod")."'; </script>");
}

if ($acao == "DEL" && $id != "") {

    $registro = connAccess::fastOne($oConn, "custom.item_componente",
            " id = ".$id);
    connAccess::Delete($oConn, $registro, "custom.item_componente", "id");

    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";

    $id         = "";
    $registro   = $oConn->describleTable("custom.item_componente");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro      = connAccess::fastOne($oConn, "custom.item_componente",
            " id = ".$id);
    $visible_image = true;
}
?>

<?
Util::mensagemCadastro(85);
?>

<div class="row">
    <div class="col-xs-7">
        <h1 class="sistem-title">Cadastro de Item Componente</h1>
        <p>Preencha os campos abaixo para realizar o cadastro.<br>
            Campos com * são de preenchimento obrigatório.</p>
        <form method="post" enctype="multipart/form-data" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
            <div class="fieldBox">
                <input type="hidden" name="acao" value="<?php echo $acao ?>">
                <input type="hidden" name="ispostback" value="1">
                <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"] ?>">
                <input type="hidden" name="tipo" value="
                <?php
                try {
                    echo Util::request("tipo");
                } catch (Exception $exp) {
                    
                }
                ?>
                       "/>

                <?
                $eh_primarykey   = True;
                $visible_in_html = "";

                if ($eh_primarykey && $registro["id"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>



                <div <? echo ($visible_in_html); ?> id="tr_id" >
                    <div class="form-group">
                        <div <? if ($registro['id'] == "") { ?> style='display:none' <? } ?> >
                            <label for="id">ID</label> &nbsp;
                            <span class='mostrapk'><?= $registro['id'] ?></span>
                            <input type="hidden"  name="id" value="<?= $registro["id"] ?>" >
                        </div>
                    </div>
                </div>

                <?
                $eh_primarykey   = False;
                $visible_in_html = "";
                if ($eh_primarykey && $registro["codigo"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>

                <div <? echo ($visible_in_html); ?> id="tr_codigo" >
                    <div class="form-group">
                        <label for="codigo">Código<span class="campoObrigatorio" > * </span></label>
                        <input type="text" class="form-control" name="codigo" value="<?= $registro["codigo"] ?>">
                    </div>
                </div>

                <?
                $eh_primarykey   = False;
                $visible_in_html = "";

                if ($eh_primarykey && $registro["nome"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>

                <div <? echo ($visible_in_html); ?> id="tr_nome" >
                    <div class="form-group">
                        <label for="nome">Nome<span class="campoObrigatorio" > * </span></label>
                        <input type="text" class="form-control" name="nome" value="<?= $registro["nome"] ?>">		             	
                    </div>
                </div>

                <?
                $eh_primarykey   = False;
                $visible_in_html = "";

                if ($eh_primarykey && $registro["imagem"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>        

                <div <? echo ($visible_in_html); ?> id="tr_imagem" >
                    <div class="form-group">
                        <label for="imagem">Imagem<span class="campoObrigatorio" > * </span></label>
                        <input type="hidden" name="input_image_hedden" id="input_image_hedden" value="<?= $registro["imagem"] ?>">
                        <input type="file" name="file_imagem" accept="image/*" id="file_imagem" onchange="preview(this, 'input_image_hedden','img_imagem');">                        
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
                $visible_in_html = "";

                if ($eh_primarykey && $registro["imagem_miniatura"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>  

                <div <? echo ($visible_in_html); ?> id="tr_imagem_miniatura" >
                    <div class="form-group">   
                        <label for="imagem_miniatura">Imagem Miniatura<span class="campoObrigatorio" > * </span></label>
                        <input type="hidden" name="input_image_miniatura_hedden" id="input_image_miniatura_hedden" value="<?= $registro["imagem_miniatura"] ?>">
                        <!--<input type="file" name="file_imagem_miniatura"  accept="image/*" id="file_imagem_miniatura" onchange="preview(this, 'input_image_miniatura_hedden','img_miniatura');">-->
                        <br>

                        <div class="imagem" id="div_imagem_miniatura" <?
                echo (!$visible_image ? "style='display:none'" : "")
                ?>>
                            <img id="img_miniatura" height="<?= $heigth_miniature ?>" name="img_miniatura" src= <?= $dir_image.$registro["imagem_miniatura"] ?>>
                        </div>
                    </div>
                </div>

                <?
                $eh_primarykey   = False;
                $visible_in_html = "";

                if ($eh_primarykey && $registro["obs"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>    

                <div <? echo ($visible_in_html); ?> id="tr_obs" >
                    <div class="form-group">
                        <label for="obs">Observações</label>
                        <input type="text" class="form-control" name="obs" value="<?= $registro["obs"] ?>">
                    </div>
                </div>

                <tr>
                    <td  align="right">
                        <?php
                        showButtons($acao, true);

                        $enBtGrupo = " disabled ";

                        try {
                            $id = $registro["id"];

                            if ($id > 0) $enBtGrupo = "";
                        } catch (Exception $exp) {
                            
                        }
                        ?>


                    </td>
                </tr>

                </table>
            </div>

        </form>
        <div class="interMenu">
            <?php botaoVoltar("index.php?mod=listar&pag=".Util::request("pag")."&tipo=".Util::request("tipo")) ?>
        </div>
    </div>
</div>

<script>

    function teste(){
        alert("Carregando a pagina!");
    }

    function salvar()
    {
        var f = document.forms[0];

        if (isVazio(f.codigo, 'Informe Código!')) {
            return false;
        }


        if (isVazio(f.nome, 'Informe Nome!')) {
            return false;
        }
        
        if(isVazio(f.input_image_hedden, 'Selecione a imagem!')){
            return false;
        }
        
        /*if(isVazio(f.input_image_miniatura_hedden, 'Selecione a imagem!')){
            return false;
        }*/

        f.acao.value = "<?php echo ( Util::$SAVE) ?>";
        f.submit();
    }


    function novo(){
        var f = document.forms[0];
        document.location = f.action;
    }

    function excluir(){

        var f = document.forms[0];


        if (f.id.value == "")
        {
            alert("Selecione um registro para excluir!");
            return;
        }


        f.acao.value = "<?php echo Util::$DEL ?>";
        f.submit();
    }
    
    function preview(input, inputhedden) {
        if (input.files && input.files[0]) {
           
            var reader = new FileReader();

            reader.onload = function (e) {
               
                $('#img_imagem').attr('src', e.target.result);

                $('#img_miniatura').attr('src', e.target.result);
     
            };
            
            reader.readAsDataURL(input.files[0]);
            
            $('#'+inputhedden).val(input.files[0]['name']);

            //Pega os elementos que representam a div das imagens
            var image_div = document.getElementById( "div_imagem" ) ;
            var image_miniature_div = document.getElementById( "div_imagem_miniatura" ) ;

            //Apresenta a div das imagens
            image_div.style.display = "block";
            image_miniature_div.style.display = "block";
            
        }
    }
    
</script>