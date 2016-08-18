<?
//include functions to capitulo
class capitulo{
  public static function garanteTSVector( $registro ){
  global $oConn;
  $sql = " update custom.capitulo set texto_srch = to_tsvector('portuguese', titulo || ' ' || texto ||' ' || coalesce(poema,'') || ' ' || coalesce(poema_autor,'')) where id =  ".
              $registro["id"];
  connAccess::executeCommand($oConn, $sql);
 }
static function formataTexto($texto ){
    $ar = explode("<img", $texto );
    $str = "";
    for ( $i = 0; $i < count($ar); $i++){
        $pedaco = $ar[$i];
        if ( $i > 0 && $i< count($ar)){
            $pedaco = '<div class="img img-med float-left"><img' .  strtok($ar[$i],'>') ."></div>" .
                           substr( $ar[$i] , strpos(" ".$ar[$i],">"), strlen($ar[$i]) - strlen(strtok($ar[$i])));
        }
        $str .= $pedaco;
    }
    return $str;
}

static function mostraMenu(){
    global $oConn;
    //data-href="Inicio"
    //class="menu-item-link"
    $lista = connAccess::fetchData($oConn," select * from custom.capitulo order by titulo ");
    ?>

    <?
      for ( $i = 0; $i < count($lista); $i++ ){
          $item = $lista[$i];
          $url  ="index.php?mod=livro&id=". $item["id"]."&tipo=capitulo";
          $dir_image = K_VIRTUALPATH_LOGO . "files/capitulo/". $item["imagem"];
          $adiciona_estilo = "";
          if (@$item["imagem"] != "" )
              $adiciona_estilo = 'background: url('. $dir_image.') left no-repeat;'

      ?>
      <div class="menu-item" style="background-color: #<?=$item["cor_fundo"] ?>; color: #<?=$item["cor_texto"] ?>;
                        <? #=$adiciona_estilo ?>
        ">
        <a class="menu-item-link" href="<?=$url ?>">
          <?=$item["titulo"] ?>
        </a>
       <?
          $itens = connAccess::fetchData($oConn," select * from custom.componente_template where id_ferramenta = " . $item["id"]. " order by ordem, nome ");
           for ( $yy = 0; $yy < count($itens); $yy++ ){
               $item_template = $itens[$yy];
               $url  ="index.php?mod=livro&id=". $item_template["id"]."&tipo=pagina";
       ?>
       <div class="menu-subitem">
          <a class="menu-item-link" data-href="<?=$item_template["nome"] ?>" href="<?=$url?>">
            <?=$item_template["nome"] ?>
          </a>
        </div><!-- /menu-subitem -->
       <? } ?>
        </div><!-- /menu-item -->
      <? } ?>
    <?
}


    static function mostraCapitulo($id ){

        global $oConn;

        $registro = connAccess::fastOne($oConn,"custom.capitulo"," id = ". $id );

        $lista_paginas = connAccess::fastQuerie($oConn,"custom.componente_template"," id_ferramenta = ". $id , " ordem asc ");
        ?>

                        <!-- Modelo de Página do Capítulo -->

                        <!-- Colocar o Background e o Color, com a cor que o usuario cadastrar no Capitulo -->
                        <div class="wrapper" style="color: #<?=$registro["cor_texto"] ?>; background-color: #<?=$registro["cor_fundo"] ?>;">

                          <!-- O "background-image" Deve vir do Capitulo omo a imagem de fundo q o usuario vai cadastrar-->
                          <section class="cover"
                                   <? if ( $registro["imagem"] != "" ) {
                                      $caminho_imagem = K_RAIZ_DOMINIO . "files/capitulo/". $registro["imagem"];
                                   ?>
                                   style="background-image: url(<?=$caminho_imagem?>);" >
                                   <? } ?>
                                   <!-- -->
                            <h1 class="cover-title">
                              <?= $registro["titulo"] ?>
                            </h1>
                            <!-- Texto do H1 deve vir do título do capitulo -->
                          </section>

                          <section class="core">
                            <div class="intro">

                            <!-- Texto do H2 deve vir do título do capitulo -->
                            <h2><?= $registro["titulo"] ?></h2>

                            <?= self::formataTexto( $registro["texto"] ) ?>
                            <? if ( false ) { ?>
                            <p><strong>As montanhas e serras, as rochas...</strong> as plantas, os bichos, a vida... os rios, riachos e córregos...
                              os elementos que compõem este lugar único chamado Cuestas Basálticas, que forma a nossa região...
                              Qual a sua história natural? Tudo isso foi sempre assim?</p>

                            <!-- as classes podem ser: img-big / img-med / img-small - float-left / float-right -->
                            <div class="img img-med float-left">
                              <span>Bofete</span>
                              <img src="images/atlas_grafica_24out-71.jpg" alt="Bofete">
                            </div>

                            <p>Você verá que não. O que vemos hoje é resultado de um processo dinâmico, repleto de fenômenos naturais,
                            e levou milhões de anos para se formar. E esses processos não param!
                            Areias levadas pelo vento e pelas águas; sol e chuva desgastando a rocha;
                            a vida se formando e evoluindo, originando incontáveis seres diferentes e dependentes uns dos outros;
                            água correndo, infiltrando, dando suporte à vida e moldando a paisagem.
                            Comecemos por aqui, pela história do ambiente natural da região da Cuesta.</p>
                            <? } ?>
                            <? if ( count($lista_paginas) > 0 ) { ?>
                            <div class="chapter-menu">
                              <h3>Neste capítulo</h3>
                              <ul>
                                   <? for ( $z = 0; $z < count($lista_paginas); $z++){

                                       $item_pagina = $lista_paginas[$z];
                                       ?>


                                  <li><a href="<?= componente_template::getUrlLivro($item_pagina) ?>"><?=$item_pagina["nome"] ?></a></li>
                                   <? } ?>

                              </ul>
                            </div>
                            <? } ?>

                            </div><!-- /intro -->
                            <? if ( $registro["poema"] != "") { ?>
                            <div class="poem">
                              <p><pre>
                              <?= $registro["poema"] ?></pre></p>
                              <span><?=$registro["poema_autor"] ?></span>
                            </div><!-- /Poem -->
                            <? } ?>
                          </section>
                        </div>
    <?


    }





}


?>
