<?php
require_once("admin/library/Util.php");
require_once("admin/library/SessionFacade.php");
require_once("admin/library/SessionCliente.php");
require_once("admin/oAuth/config.php");
require_once("admin/config.php");
require_once("admin/persist/IDbPersist.php");
require_once("admin/persist/connAccess.php");
require_once("admin/persist/FactoryConn.php");
require_once("admin/inc_usuario.php");


$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$acao = Util::request("acao");
$id_usuario = Util::request("id_usuario");
$token = Util::request("token");

if ( $id_usuario != "" && $token != ""){
    
    if ( $token != Usuario::getToken($id_usuario)){
        die("Token recebido inválido!");
    }
    
    
    if ( $acao == "remover_imagem" ){
        
        
    }
    
    if ( $acao == "upload" ){
        
               $arquivo = $_FILES["file_user_logo"];
 
                                    //print_r ( $arquivo ); die ( " 00000 ");

              $pasta = realpath(".");

              if ( strpos(" ". $arquivo["type"],"image") ){

                 $tipo = "arquivo";
                  
                 Usuario::salvaArquivoImagem($pasta, $id_usuario, $arquivo, $tipo ); 
                 $user = Usuario::getUser($id_usuario);
                 
                 $lista_imagens = Usuario::getImagesUser( $id_usuario, "" );
                 
                 $atualiza_img = false;
                 $current_image = "";
                 $current_image_tipo = "";
                 if ( trim($user["imagem"]) == "" && count($lista_imagens) > 0 ){
                     $atualiza_img = true;
                     $current_image  = $lista[0]["imagem"];
                     $current_image_tipo  = $lista[0]["tipo"];
                 }
                 ?>
                  <div id="div_img_perfil" class="img-profile">
                                         <?   Usuario::mostraImagemPerfil($user, $lista_imagens); ?>
                                    
		  </div>

                            <div class="vatar-available" id="div_grid_imagens">
                                    
                                    <?
                                        Usuario::mostraGridImagens($id_usuario, $lista_imagens);  
                                    ?>
				</div>
                          <script>
                              
                              if ( parent != null ){
                                  var div_img_perfil = parent.document.getElementById("div_img_perfil");
                                  var div_grid_imagens = parent.document.getElementById("div_grid_imagens");
                                  var btUpload = parent.document.getElementById("btUpload");
                                  
                                  btUpload.value = "Upload"; btUpload.disabled = false;
                                  
                                  if ( div_grid_imagens != null  )
                                  div_grid_imagens.innerHTML = document.getElementById("div_grid_imagens").innerHTML;
                              
                                   if ( div_img_perfil != null  )
                                  div_img_perfil.innerHTML = document.getElementById("div_img_perfil").innerHTML;
                                  <? if ( $atualiza_img ) { ?>
                                          
                                          
                                    var f = parent.document.forms[0];

                                    f.current_image.value = "<?=$current_image?>";
                                    f.current_image_tipo.value = "<?=$current_image_tipo?>";
                                  <? } ?>       
                              
                              }
                              
                              </script>

                 <?
             }
    }
    
}


$oConn->disconnect();
?>