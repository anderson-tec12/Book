<?php


    $user =  Usuario::getUser( $id_usuario_logado );
    $tipo_img = "arquivo";
    $acao = Util::request("acao");
    $msg = "";
    if ( $acao == "upload" ){
    
                       $arquivo = $_FILES["file_user_logo"];

                       $pasta = realpath("../../");

                        if ( strpos(" ". $arquivo["type"],"image") ){
                        
                                    Usuario::salvaArquivoImagem($pasta, $id_usuario_logado, $arquivo );

                        }
        
        
    }
     if ( $acao == "delete" ){
         
        $new_img = Util::request("current_image_tipo").":". Util::request("current_image");
          Usuario::deleteCurrentPhoto($user, $new_img, Util::request("current_image"), Util::request("current_image_tipo") );
           $msg = "Imagem removida com sucesso!";
     }
    if ( $acao == "editar" ){
        
        //die ( "-->".  Util::request("current_image") );
        
        $new_img = Util::request("current_image_tipo").":". Util::request("current_image");
        
        Usuario::changeCurrentPhoto($user, $new_img, Util::request("current_image"), Util::request("current_image_tipo") );
        
        $msg = "Imagem do perfil alterada com sucesso!";
    }
    
    $lista_imagens = Usuario::getImagesUser( $id_usuario_logado );
    
    if ( $user["imagem"] != ""  ){
        
        $ar_img = explode("arquivo:", $user["imagem"]);
        
        if ( count($ar_img) < 2 ){
            $ar_img = explode("url:", $user["imagem"]);
            
            $tipo_img = "url";
        }
        
        if ( Usuario::adicionarListaImagem($id_usuario_logado,$ar_img[1],$tipo_img,1 ) ){
            //Imagem recente, precisa ser adicionada ao perfil..
             $lista_imagens = Usuario::getImagesUser( $id_usuario_logado );
        }
        
    }
    
    //K_RAIZ_DOMINIO
    ?>
<br>
    <?if ( $msg != ""){ ?>
    <div class="mensagem_aviso"><?=$msg?></div>
    <? } ?>
    <form  method="post" name="form_editar_perfil" enctype="multipart/form-data">
<div class="titulo_pagina">Editar Imagem do Perfil</div>
<div id="box_conteudo">

<table>
    <tr>
        <td valign="top">
            <label>Pré-visualizar</label> 
            <!--Imagem atual -->
            <? if ( $user["imagem"] != ""){
                ?>
            <br>
               <img id="img_current"
                    name="img_current"
                    src="<?= Usuario::mostraImagemUser($user["imagem"], $id_usuario_logado, true); ?>"
                    
                    style="max-width: 150px" >
               <div id="div_excluir_img" 
                    <? if (strpos(" ". $user["imagem"], "url:")){ ?>
                    style="display:none"
                    <? } ?>
                    >
                   <a href="#" onclick="fn_excluir_current()" >Excluir Foto</a>
               </div> 
               
               <?
                
            }else{
                ?>
               <br>
            <i>Não há imagem</i>
              <?
                
            } ?>
        </td>
        <td valign="top">
            <label>Imagens Disponíveis</label>
            <? if ( count($lista_imagens) > 0 ){ ?>
            <!-- Lista de Imagems -->
            <table>
             <tr>
                             
           <?
           $conta = 0;
           for ( $y = 0; $y < count($lista_imagens); $y++ ){ 
                            $item = $lista_imagens[$y];
                            
                            $conta++;
                            if ( $conta == 5 ){
                                $conta = 1;
                                echo("</tr><tr>");
                                
                            }     
                            
                            ?>
                        <td>
                            <a href="#" 
                               onclick="fn_changephoto('<?=$item["imagem"]?>','<?=$item["tipo"]?>','<?= Usuario::mostraImagemUser($item["tipo"].":".$item["imagem"], $id_usuario_logado); ?>')">
                            <img src="<?= Usuario::mostraImagemUser($item["tipo"].":".$item["imagem"], $id_usuario_logado, false); ?>" height="45" 
                                  style="cursor:pointer"></a>
                           </td>
                        <? } ?>
            </tr>
            </table>
            <? } else { ?>
            <br> &nbsp;&nbsp;&nbsp;&nbsp;<i>Não há imagens cadastradas</i>
            <? } ?>
        </td>
        
    </tr>
    <tr>
        <td colspan="2">
    <b>Enviar nova imagem:</b>   
    <input type="file" name="file_user_logo" id="file_user_logo" >
    <input type="button" name="btUpload" class="bt_salvar button" value="Upload" onclick="fn_upload()">
    </td>
    </tr>

    
</table>
</div>


<input type="button" name="btSalvar" class="bt_salvar button" value="Salvar" onclick="fn_salvar()">
<input type="hidden" name="current_image" value="<?= Usuario::mostraImagemUser($user["imagem"], $id_usuario_logado); ?>">
<input type="hidden" name="current_image_tipo" value="<?= $tipo_img ?>">

            <input type="hidden" name="acao" value="">
            <input type="hidden" name="pag" value="<?= Util::request("pag") ?>">
</form>
<script type="text/javascript" >
function fn_changephoto(new_photo, tipo, url ){
    
    var f = document.forms[0];
    
    f.current_image.value = new_photo;
    f.current_image_tipo.value = tipo;
    
    var img = document.getElementById("img_current");
    img.src = url;
    
    var div_excluir_img = document.getElementById("div_excluir_img"); 
    if ( tipo == "arquivo" ){
        
        div_excluir_img.style.display = "";
    }else{
        
        
        
        div_excluir_img.style.display = "none";
    }
    
}    
function fn_upload(){
    
    var f = document.forms[0];
    if ( f.file_user_logo.value == "")
    {
        alert("Selecione uma imagem para enviar");
        return;
        
    }
    f.acao.value = "upload";
    f.submit();
    
}
function fn_excluir_current(){
    
    var f = document.forms[0];
    f.acao.value = "delete";
    f.submit();
}

function fn_salvar(){
    
    var f = document.forms[0];
    f.acao.value = "editar";
    f.submit();
    
}
<? if ( $acao == "editar"  || $acao == "delete" ){ ?>
     var new_img = "<?= Usuario::mostraImagemUser($user["imagem"], $id_usuario_logado); ?>";
     var current_profile_image = document.getElementById("current_profile_image");
     
     current_profile_image.src = new_img;
<? } ?>
</script>   
