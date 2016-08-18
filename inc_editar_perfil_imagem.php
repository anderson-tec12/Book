<?
$img_usuario = "img/avatar.jpg";
$tipo = Util::NVL( Util::request("tipo"),"arquivo");

if ( $tipo == "perfil" && !$ispostback && $user["imagem"] != "" && $id_usuario_logado != ""){

    $teste = $user["imagem"];
    
    if ( strpos(" ". $user["imagem"], "url:")){
       $ar_teste = explode("url:", $user["imagem"]);
       $teste = $ar_teste[1];


       $lst_tmp = connAccess::fastQuerie($oConn, "usuario_imagem"," id_usuario = " . $id_usuario_logado . " and tipo in ('".$tipo.
         "', 'url') and imagem like '%".$teste."%'");

       if ( count($lst_tmp) <= 0 ){
            //die ( " id_usuario = " . $id_usuario_logado . " and tipo in ('".$tipo. "', 'url') and imagem like '%".$teste."%'" );
            Usuario::adicionarListaImagem($id_usuario_logado, $teste, $tipo, 1); //É o do perfil..
        }
    }
    
}

if ( $acao == "delete" ){
   
    $new_img = Util::request("current_image_tipo").":". Util::request("current_image");
    Usuario::deleteCurrentPhoto($user, $new_img, Util::request("current_image"), Util::request("current_image_tipo") , $tipo);
    $msg = "Imagem removida com sucesso!";
}


$lista_imagens = Usuario::getImagesUser( $id_usuario_logado, "" );

$imagem_inicial = $user["imagem"];
$tipo_img = "arquivo";
if ( $tipo == "arquivo" ){
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
}

if ( $tipo == "galeria" ){
   $imagem_inicial =  "";

   if (count($lista_imagens) > 0 )
       $imagem_inicial = $lista_imagens[0]["tipo"].":".$lista_imagens[0]["imagem"];
}

?>


<div class="form-group column3">
    <label>Imagem de perfil</label>
    <div id="div_img_perfil" class="img-profile">
       <? Usuario::mostraImagemPerfil($user, $lista_imagens); ?>
   </div>
   <input type="hidden" name="current_image" value="<?=  $imagem_inicial ; ?>">
   <input type="hidden" name="current_image_tipo" value="<?= $tipo_img ?>">
</div>

<div class="form-group column3">
    <label>Imagens disponíveis</label>
    <div class="vatar-available" id="div_grid_imagens">
        <?
        if ( count($lista_imagens) > 0 ){ 
            Usuario::mostraGridImagens($id_usuario_logado, $lista_imagens);  
        } ?>
    </div>
</div>

<div class="form-group column6">
    <label>Enviar nova imagem</label>
    <div class="inputFile">
       <span id="span_sel_arquivo">Clique aqui para selecionar uma imagem</span>
       <input type="file" class="form-control" name="file_user_logo" id="file_user_logo" onchange="muda_arquivo(this)">
   </div>
   <input type="button" name="btUpload" id="btUpload" class="btn btn-upload" value="Upload" onclick="fn_upload(this)">
</div>
<iframe name="frame_imagem" id="frame_imagem"></iframe>


<script type="text/javascript" >
    function fn_changemainPhoto(url){

        if ( parent != null  ){

           var  current_profile_image = parent.document.getElementById("current_profile_image");
           var img_current = document.getElementById("img_current");
           if ( current_profile_image != null && img_current != null  ){

               current_profile_image.src = img_current.src;
           }

       }


   }

   function muda_arquivo(obj){


    var img = document.getElementById("span_sel_arquivo");

    if ( obj.value == ""){

       img.innerHTML = "Clique aqui para selecionar uma imagem";
   }else{

       var ar = obj.value.split("\\");

       var str = ar[ ar.length - 1 ];

       img.innerHTML = str;

   }
}

<?= $javascript_load; ?>

function fn_changephoto(new_photo, tipo, url ){

    var f = document.forms[0];
    
    f.current_image.value = new_photo;
    f.current_image_tipo.value = tipo;
    
    var img = document.getElementById("img_current");
    try{
       img.src = url;
       img.style.display = "";

   }catch(Exp){


   }
   var div_excluir_img = document.getElementById("div_excluir_img"); 
   if ( tipo == "url" ){

    div_excluir_img.style.display = "none";
}else{
    div_excluir_img.style.display = "";
    
}

}    
function fn_upload(obj){

    var f = document.forms[0];
    if ( f.file_user_logo.value == "")
    {
        alerta("", "Selecione uma imagem para enviar");
        return;
        
    }
    
    var oldact = f.action;
    
    obj.value = "Enviando..";
    obj.disabled = true;
    f.enctype="multipart/form-data";
    f.action = "ajax_usuario.php";
    f.target="frame_imagem";
    f.acao.value = "upload";
    f.submit();
    
    
    f.action = oldact;
    f.target = "_self";
    
}
function fn_excluir_current(){

    var f = document.form_editar_perfil;
    f.acao.value = "delete";
    
   // alert( f.action );
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
 <? if ( $tipo == "arquivo"){ ?>
   current_profile_image.src = new_img;
   <? } ?>
   <? } ?>
</script>

