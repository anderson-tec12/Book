<? require_once("inc_protecao_usuario.php"); ?>
<?

$lat = Util::request("lat");
$lng = Util::request("lng");
$zoom = Util::request("zoom");
$eventX = Util::request("eventX");
$eventY = Util::request("eventY");

$coord_x = ""; //Coordenada da imagem final.
$coord_y = "";

$leaf_lat = ""; //Leaf latitude do click
$leaf_lng = ""; //Leaf longitude do click
//Vou criar a miniatura da marcação.. só que o X é na biblioteca Leaf


$acao = Util::request("acao");
$token = Util::request("token");

$registro = $oConn->describleTable("marcacao"); 
$prefixo = "";

if ( $acao == "salvar" && $id_usuario_logado != "" && $token == Usuario::getToken($id_usuario_logado)){

//print_r($_POST); die(" ");
                    //$registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") );					 

  $registro["id_tipo_marcacao"] = Util::request($prefixo."id_tipo_marcacao"); 
  $registro["titulo"] = Util::request($prefixo."titulo"); 
  $registro["texto"] = Util::request($prefixo."texto"); 
  $registro["id_municipio"]  = Util::request($prefixo."id_municipio") ;
  $registro["municipio"] = connAccess::executeScalar($oConn, " select descricao from cadastro_basico where id = " . Util::NVL(  Util::request($prefixo."id_municipio"), " 0 ") ); 
  $registro["tipo"] = "marcacao_usuario"; 					 

  $registro["imagem"] = Util::request($prefixo."imagem"); 
  $registro["localizacao"] = Util::request($prefixo."localizacao"); 
  $registro["url_livro"] = Util::request($prefixo."url_livro"); 

  $registro["coordenadas"] = Util::request($prefixo."coordenadas"); 
  $registro["coord_x"] = Util::request($prefixo."coord_x") ; 	
  $registro["coord_y"] = Util::request($prefixo."coord_y"); 	
  $registro["leaf_lat"] = Util::request($prefixo."leaf_lat"); 
  $registro["leaf_lng"] = Util::request($prefixo."leaf_lng"); 	
  $registro["data_cadastro"] = Util::getCurrentBDdate();
  $registro["id_usuario"]  = $id_usuario_logado;		
  $registro["usuario_cadastro"] = SessionFacade::getNome();

  connAccess::nullBlankColumns( $registro );	

  $registro["id"] = connAccess::Insert($oConn, $registro, "marcacao", "id", true);



  if ( count($_FILES) > 0 && $_FILES["file_image"]["tmp_name"] != "" ){

    $arquivo = $_FILES["file_image"];

    if ( !file_exists(realpath(".") . DIRECTORY_SEPARATOR . "files". DIRECTORY_SEPARATOR . "marcacao")){

      mkdir(realpath(".") . DIRECTORY_SEPARATOR . "files". DIRECTORY_SEPARATOR . "marcacao");
    }



    $pasta = realpath("files/marcacao");

    $sep = DIRECTORY_SEPARATOR;
    $str_final_arquivo = Util::removeAcentos($arquivo["name"]);
    $str_final_arquivo = str_replace(" ", "_", $str_final_arquivo);


    move_uploaded_file( $arquivo["tmp_name"], $pasta .$sep. $registro["id"]."_". $str_final_arquivo);

    $registro["imagem"] = $registro["id"]."_". $str_final_arquivo;

    connAccess::nullBlankColumns( $registro );	
    connAccess::Update($oConn, $registro, "marcacao", "id");
                                ///print_r( $_FILES );die("<<<");	
  }


  $_SESSION["st_Mensagem"] = "Marcação criada com sucesso! - Atualize o mapa para visualizar.";

  die("<script> document.location.href='pop_index.php?pag=mensagem'; </script>");





                   // $registro["status"] = Util::request($prefixo."status");  Publicado e não publicado ?

}


?>

<script src="admin/javascript/validacampos.js?t=9990" type="text/javascript"></script>

<form  method="post" name="form_marcacao" enctype="multipart/form-data" >


  <input type="hidden" name="pag" value="<?= Util::request("pag") ?>" >
  <input type="hidden" name="acao" value="">
  <input type="hidden" name="id_usuario" value="<?=$id_usuario_logado ?>">
  <input type="hidden" name="token" value="<?= Usuario::getToken($id_usuario_logado) ?>">
  <input type="hidden" name="ispostback" value="1" >
  <div class="container">
   <div class="cboxIframe container12 pop_post">


     <?           

     $coordenadas = "";
     if ( $lat != "" && $lng != ""  && is_numeric($lat) && is_numeric($lng) && $zoom != "" ){

          // print_r( $_GET );

      if ( $zoom <= 0 )
        $zoom = K_MAP_IMAGE_ZOOM;

      $fator_zoom = 1/ $zoom;

      $image_x_size = K_MAP_IMAGE_WIDTH;
      $image_y_size = K_MAP_IMAGE_HEIGHT;
            //K_MAP_IMAGE_HEIGHT
            $X   = abs(   $lng * $fator_zoom );  // $image_y_size - $lng; 
            $Y   = abs(  K_MAP_IMAGE_HEIGHT - $lat * $fator_zoom ); //Necessário inverter.
            
            $leaf_lat = $lat * $fator_zoom;
            $leaf_lng = $lng * $fator_zoom;
            
            $coord_x = $X;
            $coord_y = $Y;
            
            $coordenadas = "Zoom: ". $fator_zoom . ", EventX: ".$eventX. ", EventY: ". $eventY. ",LAT: ". $lat . ", LNG: ". $lng . ", CALC_X:".$X. ", CALC_Y: ".$Y;
           // echo("X: ". $X. " Y:". $Y. " Long:". $lng. " Lat: ". $lat);
            ?>
            
            <?
          }
          ?>
          <h1>Criar marcação</h1>

          <div class="column6">
            <div class="form-group">
              
              <label>Ponto selecionado *</label>
              <img class="post-marcado" height="138" width="500" src="crop_mapa.php?X=<?= $X?>&Y=<?=$Y?>" >
              
              <label>Selecione o tipo *</label>
            <?
            $sql = " select c.* from marcacao_tipo c order by c.nome  ";

            $ls = connAccess::fetchData($oConn, $sql)
            ?>
            <select class="form-control js-my-select" name="id_tipo_marcacao" onchange="mostraImg(this)">
              <option value="" selected>Selecione</option>
              <? Util::CarregaComboArray($ls, "id", "nome", @$registro["id_tipo_marcacao"], ""); ?>

            </select>  
            <?	for ( $i =0 ; $i < count( $ls )  ; $i++)
            {
              $arr = $ls[$i];
              ?>
              <img class="icons-posts js-my-image" id="div_img_<?=$arr["id"]?>" src="files/marcacao_tipo/<?=$arr["imagem"]?>">
              <?
            }
            ?>       
            <script>
              function mostraImg( obj ){

                var f= document.forms[0];
                $images =  $('.js-my-image');
                var valor = "div_img_" +
                f.id_tipo_marcacao.value; 
                                          //  $images.show();
                                       // alert(valor );
                                       $images.hide();
                                       $("#"+valor).show();
	                                //$images.show().not(valor).hide();

                                }

                              </script>
                            </div>
                            <div class="form-group">
                              <label>Título *</label>
                              <input type="text" name="titulo" class="form-control" placeholder="Até 40 caracteres" maxlength="40">
                              <input type="hidden" name="coord_x" value="<?=$coord_x?>">
                              <input type="hidden" name="coord_y" value="<?=$coord_y?>">
                              <input type="hidden" name="leaf_lat" value="<?=$leaf_lat?>">
                              <input type="hidden" name="leaf_lng" value="<?=$leaf_lng?>">
                              <input type="hidden" name="coordenadas" value="<?=$coordenadas?>">
                            </div>

                            <div class="form-group">
                              <label>Localização</label>
                              <input type="text" class="form-control" name="localizacao" placeholder="Até 40 caracteres" maxlength="40">
                            </div>
                          </div>


                          <div class="column6">
                           <div class="form-group">

                           <div class="form-group">
                              <label>Descrição *</label>
                              <textarea name="texto" class="form-control" placeholder="Até 170 caracteres" maxlength="170"></textarea>
                            </div>

                             <?
                             $sql = " select c.* from cadastro_basico c where c.id_tipo_cadastro_basico = 3 order by c.descricao  ";

                             $ls = connAccess::fetchData($oConn, $sql)
                             ?>

                             <label>Selecione o Munícipio *</label>
                             <select name='id_municipio' class="form-control">
                               <option value=''>Selecione</option>
                               <? Util::CarregaComboArray($ls, "id", "descricao", @$registro["id_municipio"], ""); ?>
                             </select>
                           </div>

                           <div class="form-group">
                            <label>Enviar imagem</label>
                            <div class="inputFile">
                             <span>Clique aqui para selecionar uma imagem</span>
                             <input type="file" class="form-control" name="file_image" id="file_image">
                             <input type="hidden" name="imagem" value="<?=$registro["imagem"]?>" >
                             <!--<input type="button" name="btUpload" class="bt_upload button" value="Upload" onclick="fn_upload()">-->
                           </div>
                         </div>

                        <div class="form-group">
                          <label>Inserir conteúdo do Livro</label>
                          <input type="text" class="form-control" name='url_livro' value="<?=$registro["url_livro"]?>" placeholder="Copie a URL" maxlength="300">
                        </div>
                      </div>

                      <div class="column12">
                        <input type="button" class="btn" value="Publicar" id="btSalvar" onclick="salvar();" >
                        <input type="button" class="btn" value="Excluir" id="" onclick="">
                      </div>

                    </div><!-- /cboxIframe -->
                  </div><!-- /container -->
                </form>

                <script type="text/javascript">

                  if ( $ != null && $ != undefined ){

                    var jq = parent.$;

                    if ( jq == undefined || jq == null ){

                      jq = parent.Jq;
                    }

	// Modal
	$(document).ready(function () {
    if ( jq != undefined && jq != null && jq.colorbox != undefined && jq.colorbox != null  ){
      jq.colorbox.resize( {
       innerWidth: 980,
       innerHeight: $(document).height()
     });
    }
  });
	
        /* 
	// Selecionar post
	$(function() {
  	var $select = $('.js-my-select'),
    $images =  $('.js-my-image');

	  $select.on('change', function() {
	    var value = '.' + $(this).val();
	    $images.show().not(value).hide();
	  });
	});
  */
	// Upload
	$("#file_image").change(function() {
    $(this).prev().html($(this).val());
  });
}


function valido(){


  var f = document.forms[0];

  if ( isVazio(f.id_tipo_marcacao, "Selecione o tipo"))
    return false;


  if ( isVazio(f.titulo, "Informe o título"))
    return false;


  if ( isVazio(f.texto, "Informe a descrição"))
    return false;


  if ( isVazio(f.id_municipio, "Selecione o município"))
    return false;


      //  if ( isVazio(f.localizacao, "Informe a localização"))
         //       return false;


       // if ( isVazio(f.url_livro, "Informe a localização"))
         //       return false;

         return true;

       }

       function salvar(){

        var f = document.forms[0];
        
        if ( ! valido() )
          return false;
        
        f.acao.value = "salvar";
        f.target = "_self";
        //alert(f.target);
        f.submit();
        
      //  alert("Dei o submit? ");

    }
  </script>