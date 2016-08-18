<?php
require_once("inc_capitulo.php");
require 'library/image/ImageHelper.php';
require 'library/upload/UploadImage.php';

$id = Util::request("id");
$acao =  Util::request("acao");
$ispostback =  Util::request("ispostback");

$registro = $oConn->describleTable("capitulo");


$dir_image     = "../files/capitulo/";
$visible_image = false;
//die(realpath($dir_image));
$heigth_image = 48;


if ( $ispostback ){

	if ( $id != "" )
	    $registro = connAccess::fastOne($oConn, "custom.capitulo"," id = " . $id );

	connAccess::preencheArrayForm($registro, $_POST, "id");

	$prefixo = "";


                    $registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") );


                    $registro["titulo"] = Util::request($prefixo."titulo");
                    $registro["imagem"] = Util::request($prefixo."imagem");
                    $registro["texto"] = Util::request($prefixo."texto");
                    $registro["poema"] = Util::request($prefixo."poema");
                    $registro["poema_autor"] = Util::request($prefixo."poema_autor");
                    $registro["data_cadastro"] = Util::dataPg( Util::request($prefixo."data_cadastro") );

                    $registro["cor_fundo"] = Util::request($prefixo."cor_fundo");

                    $registro["cor_texto"] = Util::request($prefixo."cor_texto");


}

if ( $acao == "SAVE" ){

	connAccess::nullBlankColumns( $registro );

        if ( $registro["data_cadastro"] == "")
            $registro["data_cadastro"] = Util::getCurrentBDdate ();

	if (! @$registro["id"] ){

	     $registro["id"] = connAccess::Insert($oConn, $registro, "custom.capitulo", "id", true);
	}else{
		  connAccess::Update($oConn, $registro, "custom.capitulo", "id");
		}

		$_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
		$ispostback = "";

		$acao = "LOAD";
		$id = $registro["id"];


                if (isset($_FILES['file_imagem']['name']) && $_FILES["file_imagem"]["error"] == 0) {

                        //Remove imagem antiga no caso de edição
                        if (!isset($registro["imagem"])) {
                            @unlink( realpath($dir_image). DIRECTORY_SEPARATOR .   $registro["imagem"]);
                        }

                        $uploadImagem = new UploadImage();

                        //Realiza upload da imagem
                        $registro["imagem"] = $uploadImagem->doUploadFile($_FILES["file_imagem"],
                            $dir_image);

                        //Salva a imagem redimensionada para $width_image.px
                        /* $registro["imagem"] = $imageHelper->saveResizeImage($dir_image,
                          $nome_arquivo, $heigth_image); */
                    }


		  connAccess::Update($oConn, $registro, "custom.capitulo", "id");
}

if ( $acao == "DEL" && $id != "" ){

	$registro = connAccess::fastOne($oConn, "custom.capitulo"," id = " . $id );
	connAccess::Delete($oConn, $registro, "capitulo", "id");

	$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";

	$id = "";
    $registro = $oConn->describleTable("capitulo");
	$ispostback = "";

}

if ( $acao == "LOAD" && $id != "" ){

	$registro = connAccess::fastOne($oConn, "custom.capitulo"," id = " . $id );

        $visible_image = true;
}

?>
<?
 Util::mensagemCadastro(85);
?>

<script src="tinymce/tinymce.min.js" type='text/javascript'></script>
<? require_once("tinymce/editor.php"); ?>
<div class="row">
	<div class="col-xs-12">
		<h1 class="sistem-title">Capítulo</h1>
		<p>Campos com * são de preenchimento obrigatório.</p>

					<form method="post" name="frm" enctype="multipart/form-data"  action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
					<div class="fieldBox">

						  <input type="hidden" name="acao" value="<?php echo $acao ?>">
						  <input type="hidden" name="ispostback" value="1">
						  <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"]?>">
						  <input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">

                                                  <table style="width: 90%">


        <? $eh_primarykey = True;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["id"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_id" >
			    <td>
                                  <div <? echo ($visible_in_html); ?> id="tr_id" >
                    <div class="form-group">
                        <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <span class='mostrapk'><?= $registro['id'] ?></span>
                        <input type="hidden"  name="id" class="form-control" value="<?= $registro["id"] ?>" onkeypress=" return SoNumero(event)"
                               maxlength="">


                    </div>
                </div>

				</td>

			</tr>




        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["titulo"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_titulo" >
			    <td class="form-group">Título<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>


         <input type="text"  name="titulo" value="<?= $registro["titulo"]  ?>"  style="width: 300px"  maxlength="300">


				</td>

			</tr>


 <?
                $eh_primarykey   = False;
                $visible_in_html = '';

                if ($eh_primarykey && $registro["imagem"] == "") {
                    $visible_in_html = " style='display:none' ";
                }
                ?>	<tr
           <? echo ($visible_in_html); ?>
      id="tr_imagem" >
			    <td>
                <div <? echo ($visible_in_html); ?> id="tr_imagem" >
                    <div class="form-group">
                        <label for="imagem">Imagem de Fundo<span class="campoObrigatorio" > *</span> </label>

                        <input type="hidden" name="input_image_hedden" id="input_image_hedden" value="<?= $registro["imagem"] ?>">
                        <input type="file" name="file_imagem" accept="image/*" id="file_imagem" onchange="preview(this, 'input_image_hedden','img_imagem');">
                        <br>
                        <div class="imagem" id="div_imagem" <?
                echo (!$visible_image ? "style='display:none'" : "")
                ?>>
                            <img id="img_imagem" name="img_imagem" src= <?= $dir_image.$registro["imagem"] ?>>
                        </div>
                    </div>
                </div>





                            </td>
                </tr>



        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["texto"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_texto" >
			    <td class="form-group">Texto de Apresentação<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>

			  <textarea id="texto" name="texto" id="texto"  style="width: 90%; height: 120px"
                   ><?= $registro["texto"] ?></textarea>
		         <script>


                                                $(document).ready(function(){
                                                               initEditor("texto");
                                                });
                                    </script>
				</td>

			</tr>




        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["poema"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_poema" >
			    <td class="form-group"> Poema<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>

			  <textarea id="poema" name="poema" style="width: 90%; height: 70px"
                   ><?= $registro["poema"] ?></textarea>

				</td>

			</tr>




        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["poema_autor"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_poema_autor" >
			    <td class="form-group">Autor<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>


         <input type="text"  name="poema_autor" value="<?= $registro["poema_autor"]  ?>"   style="width: 300px" maxlength="300">


				</td>

			</tr>




        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["data_cadastro"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_data_cadastro" >
			    <td>Data de Cadastro<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>


        <input type="text"  name="data_cadastro" value="<?=Util::PgToOut( $registro["data_cadastro"], true) ?>" onkeypress=" return mascaraData(event)"
                    class="temData" onkeypress=" return mascaraData(event)" class="temData" maxlength="10" style="width: 90px;" maxlength="10">


				</td>

			</tr>




        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["cor_fundo"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_cor_fundo" >
			    <td>Cor de Fundo<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>


         <input type="text"  name="cor_fundo" value="<?= $registro["cor_fundo"]  ?>"   class="color form-control"
                                                       style="width: 100px" maxlength="8">


				</td>

			</tr>




        <? $eh_primarykey = False;
           $visible_in_html = "";

           if ( $eh_primarykey && $registro["cor_texto"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }

        ?>
			<tr
           <? echo ($visible_in_html); ?>
      id="tr_cor_texto" >
			    <td>Cor do Texto<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>


         <input type="text"  name="cor_texto" value="<?= $registro["cor_texto"]  ?>"   class="color form-control"
                                                       style="width: 100px" maxlength="8">


				</td>

			</tr>

                                                  </table>
                                                  <br>

					<!-- <div class="divMsgObrigatorio"><?php //echo constant("K_MSG_OBR")?></div> -->
								<?php showButtons($acao, true);
									$enBtGrupo = " disabled ";
									try{
									   $id = $registro["id"];
									   if ( $id > 0)
										  $enBtGrupo = "";

									} catch (Exception $exp){}
								?>
					 </div><!-- End fieldBox -->

                    </form>
<div class="interMenu">
	<?php botaoVoltar("index.php?mod=listar&pag=". Util::request("pag") . "&tipo=". Util::request("tipo")  ) ?>
</div>
</div>
</div>
<script type="text/javascript" src="javascript/jscolor/jscolor.js"></script>
<script>
function salvar()
   {
      var f = document.forms[0];





	  f.acao.value = "<?php echo (  Util::$SAVE) ?>";
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


	  f.acao.value = "<?php echo Util::$DEL?>";
   	  f.submit();
   }

    function preview(input, inputhedden) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $('#img_imagem').attr('src', e.target.result);

            };

            reader.readAsDataURL(input.files[0]);

            $('#'+inputhedden).val(input.files[0]['name']);

            //Pega os elementos que representam a div das imagens
            var image_div = document.getElementById( "div_imagem" ) ;

            //Apresenta a div das imagens
            image_div.style.display = "block";

        }
    }
</script>
