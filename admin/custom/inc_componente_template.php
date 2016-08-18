<?
require_once 'inc_componente_template_item.php';

class componente_template {

     static function findAllGrupoComponente($id_ferramenta = "", $id_modulo = ""){

        global $oConn;

        $sql = " select * from  "
                . "custom.grupo_componente_template where 1 = 1 ";

        if ( $id_ferramenta != "" ){
            $sql .= " and id_ferramenta = ". $id_ferramenta;
        }

        if ( $id_modulo != "" ){
            $sql .= " and id_ferramenta = ". $id_modulo;
        }

        $sql .= " order by nome ";

        return connAccess::fetchData($oConn, $sql);

    }



      public static function formataArgumentoPesquisa($valor) {

        $operator = " & ";

        $res = str_replace("  ", " ", $valor);
        $res = trim(str_replace("  ", " ", $res));

        $exp = explode(" ", $res);

        $str = "";
        for ($z = 0; $z < count($exp); $z++) {

            if ($str != "")
                $str .= $operator;

            $str .= "" . $exp[$z] . "";
        }
        return "'" . $str . "'";


        $res = str_replace(" ", " & ", $res);

        return $res;
    }



     public static function garanteTSVector( $registro ){
         global $oConn;

         $sql = " update custom.componente_template set texto_srch = to_tsvector('portuguese', nome || ' ' || descricao ||' ' || coalesce(instrucoes_uso,'') || ' ' || coalesce(modulos,'')) where id =  ".
                  $registro["id"];

          connAccess::executeCommand($oConn, $sql);

     }

       public static function garanteTSVector_Item( $id ){
         global $oConn;

         $texto = strip_tags(  connAccess::executeScalar($oConn, " select texto from custom.componente_template_item where id = ". $id) );
         $texto = stripcslashes($texto);

         $sql = " update custom.componente_template_item set texto_srch = to_tsvector('portuguese', '".$texto."') where id =  ".
                 $id;

          connAccess::executeCommand($oConn, $sql);

     }


    static function carregaForm(&$registro) {

        global $oConn;

        $prefixo = "";
        $registro["id"] = Util::request($prefixo . "id");
        $registro["nome"] = Util::request($prefixo . "nome");
        $registro["descricao"] = Util::request($prefixo . "descricao");
        $registro["instrucoes_uso"] = Util::request($prefixo . "instrucoes_uso");
        $registro["modulos"] = Util::getIDS("modulos"); // Util::request($prefixo."modulos");
        //
              //      $registro["tx_modulos"] = Util::arrayToString(connAccess::fetchData($oConn, " select nome from componente where id in ( " . Util::NVL($registro["modulos"], "0 ") . " ) "), "nome", ", ");
        $registro["id_icone1"] = Util::numeroBanco(Util::request($prefixo . "id_icone1"));
        $registro["id_icone2"] = Util::numeroBanco(Util::request($prefixo . "id_icone2"));


        if (array_key_exists("id_usuario_autor", $registro)){
            $registro["id_usuario_autor"] = Util::numeroBanco(Util::request($prefixo . "id_usuario_autor"));
        }

        //print_r( $registro ); die ( " ");

    }

    /*
     * Fun��o responsavel por salvar como, para reaproveitar os itens de outros componentes de template
     * Rodrigo Augusto -  16/02/2015
     */

    static function salvarComo($idRegistro, $novoNome = "") {

        if (!empty($idRegistro)) {
            global $oConn;

            $registro = connAccess::fastOne($oConn, "custom.componente_template", "id = " . $idRegistro);
            $registro["nome"] = $novoNome;
            $registro["id"] = null;
            $registro["id"] = connAccess::Insert($oConn, $registro, "custom.componente_template", "id", true);

            return $registro;
        }
    }

    static function carregaCheckBox($rslista, $ids_salvas = "", $prefixo = "mod", $field_query_val = "id", $field_query_text = "nome", $sep = "&nbsp;") {


        $arr_values = new ArrayList(
                explode(",", $ids_salvas)
        );

        $saida = '';

        for ($i = 0; $i < count($rslista); $i++) {

            $item = $rslista[$i];

            $continua = "";

            if ($arr_values->contains($item[$field_query_val])) {
                $continua = " checked ";
            }

            // $saida .= $sep . '<input type="checkbox" value="' . $item[$field_query_val] . '" name="' . $prefixo . '_' . $i . '" id="' . $prefixo . '_' . $i . '"
            //                             ' . $continua . '>' . $item[$field_query_text] . '&nbsp;&nbsp;&nbsp;';

            $saida .= $sep . '<label class="checkbox-inline lbl_check"><input type="checkbox" value="' . $item[$field_query_val] . '" name="' . $prefixo . '_' . $i . '" id="' . $prefixo . '_' . $i . '"
            ' . $continua . '>' . $item[$field_query_text] . '</label>';
        }
        return $saida;
    }


    static function salvaItens($id, $lista) {
        global $oConn;
        global $dir_image;


        $str_id_itens = " 0 ";

        $ar = explode(",", $lista);

        for ($i = 0; $i < count($ar); $i++) {

            if (trim($ar[$i]) == "")
                continue;

            $campos = explode("|", $ar[$i]);

            $str_id_itens .=", " . $campos[0];

            $item = connAccess::fastOne($oConn, "custom.componente_template_item", " id = " . $campos[0]);

            //$item = $oConn->describleTable("custom.componente_template_item");

            $item["id_componente_template"] = $id;
            $item["id_item_componente"] = $campos[1];
            $item["ordem"] = $i + 1;
            $item["titulo"] = Util::request("input_titulo_" . $campos[0]);
            $item["texto"] = Util::request("input_" . $campos[0]);
            $item["status"] = "salvo";

            $str_codigo = strtolower(connAccess::executeScalar($oConn, " select codigo from custom.item_componente where id = " . $item["id_item_componente"]));

            if ($str_codigo == "rel") {

                $item["texto"] = Util::getIDS("input_" . $campos[0]);
            }

            //
            if ($str_codigo == "imagem") {

                $campo_upload = "input_file_" . $campos[0];


                $tamanho = Util::request("input_tamanho_" . $campos[0]);
                $posicao = Util::request("input_posicao_" . $campos[0]);
                $nome_imagem = Util::request("input_nomeimagem_" . $campos[0]);

                $item["texto"] = Util::request("input_" . $campos[0]).
                        "##delimiter##". $tamanho.
                        "##delimiter##". $posicao;


                if ($_FILES[$campo_upload]['name'] != "" && $_FILES[$campo_upload]["size"] > 0) {

                    //Remove imagem antiga no caso de edição
                    //if (!isset($registro["imagem"])) {
                    //    unlink($dir_image.$registro["imagem"]);
                    //}
                    $uploadImagem = new UploadImage();

                    //Realiza upload da imagem
                    $nome_imagem =  $uploadImagem->doUploadFile($_FILES[$campo_upload], $dir_image);
                   // $item["texto"] = $uploadImagem->doUploadFile($_FILES[$campo_upload], $dir_image);
                   // print_r( $_FILES[$campo_upload] ); die ( " ---> ". $str_codigo . " - ". $registro["texto"] . " ---> ". $dir_image . " --- ". realpath($dir_image));
                }
                    $item["texto"] .=  "##delimiter##". $nome_imagem;
                //die(" --- ");
            }
            //print_r( $item ); die(" -- ");
            connAccess::nullBlankColumns($item);
            connAccess::Update($oConn, $item, "custom.componente_template_item", "id");
        }

        $sql = " delete from custom.componente_template_item where id_componente_template = " . $id . " and id not in ( " . $str_id_itens . " ) ";

        connAccess::executeCommand($oConn, $sql);
    }

    static function mostraRadios($valores, $prefixo, $valor = ""){

        $ar = explode(",",$valores);
        $saida = "";

        for ( $i = 0; $i < count($ar); $i++){

            $continuacao = "";

            if ( $ar[$i] == $valor )
                $continuacao = " checked ";

            if ( $valor == "" && $i == 0 ){
                $continuacao = " checked ";
            }

            if ( $i > 0 )
                $saida .= "&nbsp;&nbsp;&nbsp;";

            $saida .= "<input type='radio' ".$continuacao." name='".$prefixo."' id='".$prefixo."_".$i."' value='".$ar[$i]."' >".
                    $ar[$i] ;
        }

        return  $saida;

    }


    static function getIDS($prefixo){

            $str = "";

            foreach($_REQUEST as $key=>$value){

                    if ( strpos(" ".$key,$prefixo."_")){
                            $str = Util::AdicionaStr($str,$value,",");
                    }

            }

            return $str;
    }

    static function InputCampo($item) {
        global $oConn;
        global $dir_image;

        $codigo = strtolower($item["codigo"]);

        $tx = '';
        //echo($codigo. " ---- ");

          if ( $codigo == "texto-tab" ) {


            $tx = '<table style=\'width: 99%\'><tr><td><textarea placeHolder="Título" class="form-control " id="input_titulo_' . $item["id_item"] . '" name="input_titulo_' . $item["id_item"] . '">' . @$item["titulo"] . '</textarea>';

            $tx .= '</td><td><textarea class="form-control " placeHolder="Texto" id="input_' . $item["id_item"] . '" name="input_' . $item["id_item"] . '">' . @$item["texto"] . '</textarea></td></tr></table>';
        }

        if ($codigo == "video" || $codigo == "texto" || $codigo == "texto-m" || $codigo == "texto-p" || $codigo == "txt-kappa") {


            $tx = '<textarea class="form-control drop-saved-item" id="input_' . $item["id_item"] . '" name="input_' . $item["id_item"] . '">' . @$item["texto"] . '</textarea>';
        }
        if ($codigo == "imagem") {


            $ar_valor = explode("##delimiter##",@$item["texto"] );

            $tx = '<input type="file" class="form-control drop-img" name="input_file_' . $item["id_item"] . '" onchange="preview(this, \'input_' . $item["id_item"] . '\',\'img_prev_' . $item["id_item"] . '\');">';
            $tx .= '<input type="text" placeHolder="Legenda"  class="form-control "  name="input_' . $item["id_item"] . '" value="' . @$ar_valor[0] . '">';

            $tx .= '<br>Tamanho: '. self::mostraRadios("Pequeno,Médio,Grande", "input_tamanho_" . $item["id_item"], @$ar_valor[1]);
            $tx .= '<br>Posição: '. self::mostraRadios("Direita,Esquerda", "input_posicao_" . $item["id_item"], @$ar_valor[2]);
             $tx .= '<input type="hidden" placeHolder="Legenda"  class="form-control "  name="input_nomeimagem_' . $item["id_item"] . '" value="' . @$ar_valor[3] . '">';


        }

        if ($codigo == "rel") {

            $lista_componente = connAccess::fetchData($oConn, " select id, nome from componente order by nome ");
            $tx = componente_template::carregaCheckBox($lista_componente, @$item["texto"], "input_" . $item["id_item"]);
        }

        return $tx;
    }

    static function getUrlLivro($item){

        return "index.php?mod=livro&tipo=pagina&id=". $item["id"]; //Fazer a url aqui..
    }

    static function mostraTemplatePagina($id ){
          global $oConn;

          $sql = " select p.*"
                  . " from custom.componente_template p "
                  . " left join custom.capitulo c on c.id = p.id_ferramenta "
                  . "where 1 = 1 and id = " . $id;

          $lista = connAccess::fetchData($oConn, $sql);


          if ( count($lista) <= 0 ){
              return "";
          }

          $registro = $lista[0];


    }



    public static function writeHtmlItem($codigo, $item, $id_relato = ""){

        global $caminho_kappa;
        global $oConn;
        global $ticket;

        $codigo = strtolower($codigo);

        if ( $codigo == "video" ){

            $youtubeKey = explode("?v=", $item["texto"]);   // https://www.youtube.com/watch?v=Fu-tkFHHaDY

            $key = "";
            //print_r( $youtubeKey );
            if ( count($youtubeKey) > 1 ){

                $key = $youtubeKey[1];

                if ( trim($key) != "") {
            ?>
                    <div class="video"><iframe width="auto" height="auto"
                                               src="//www.youtube.com/embed/<?=trim($key)?>?theme=light&amp;autohide=1&amp;showinfo=0;wmode=opaque;border=none;iv_load_policy=1;rel=0"
                                               frameborder="0" allownetworking="internal"></iframe></div>

            <?
                }
            }
        }
        if ( $codigo == "kappa" && false ){ ?>


              <input type="hidden" name="comentario_nota" value="<?=$item["texto"] ?>" >

              <div class="botoes_kappa">
  				<? require_once($caminho_kappa); ?>

                  <?

                  $valor = componente_template_item::getValorItemTemplate($item["id"], $id_relato, "relato");
                  $ressalva = componente_template_item::getValorItemTemplate($item["id"], $id_relato, "relato_ressalva");

                  $valores = array("nota"=>$valor, "ressalva"=>$ressalva );

                   componente_kappa::printHTML(true, $valores);

                  if ( $valor != "" && $id_relato != "" ){
                      echo("<script type='text/javascript'>setNota('".trim($valor)."'); </script>");
                  }
                  ?>
              </div>

          <?
        }
        if ( $codigo == "txt-kappa" || $codigo == "kappa" ){

            if (class_exists("KappaGrid")){
                  $oKappa = new KappaGrid("kappa_principal_".$item["id"]);
                    $oKappa->id_componente_template = $item["id_componente_template"] ;
                    $oKappa->id_ticket = @$ticket["id"];
                    $oKappa->id_registro = $item["id"];
                    $oKappa->nome_tabela = "componente_template_item";
                    //$oKappa->id_pai = "";
                    $oKappa->href = "kappa_".$item["id"]."acapa";//Nome do link para identificar o kappa.
                    $oKappa->classe_css = " kappa_pai";
                            //"a_kappa_".$item["id"];
                    $oKappa->classe_imagem = "kappa_medio";
                    $oKappa->identificador_div_kappa =  "kappa_div_principal_". $item["id"];

                    $complemento_sql = " and c.id_avaliacao_kappa_pai is null ";

                    if (! isset(  $GLOBALS["g_classe_primeiro_kappa"] )
                            || is_null(  $GLOBALS["g_classe_primeiro_kappa"]  )
                            ){

                        $GLOBALS["g_classe_primeiro_kappa"] = $oKappa;
                    }

            }
             ?>
            	<!-- Pergunta 1 -->
                    <h3 ><?=$item["texto"]?></h3>
                     <?

                       require_once($caminho_kappa);

                      $valores = array("nota"=>"", "ressalva"=>"","botao"=>true );

                      $oKappa->mostraBarraComentario($oConn, "images/", "", $complemento_sql, true, true);
                      ?>
                       <a name="a_kappa_<?=$item["id"]?>"></a> <!--Ancora -->
                       <?
                       //componente_kappa::printHTML(true, $valores, "kappa_".$item["id"],"Escreva suas Ressalvas abaixo",
                         //     " style='display:none' ");
                     // $oKappa->mostraResponderComentario(false, $valores, "kappa_".$item["id"],"Escreva suas Ressalvas abaixo",
                       //       " style='display:none' ");

                      ?>

                       <div class="linha_divisoria" style="display:none"></div>

           <?
        }

        if ( $codigo == "texto" ){
            ?>
                   <h3><?=$item["texto"]?></h3>
            <?
        }
        if ( $codigo == "texto-m" ){
            ?>
                   <div class="form">
                   <label><?=$item["texto"]?></label>
                   </div>
            <?
        }



        if ( $codigo == "input" || $codigo == "input-text" ){

            $valor = componente_template_item::getValorItemTemplate($item["id"], $id_relato, "relato");
            ?>
                   <div class="form">
                       <input type="text" name="item_valor_<?= $item["id"] ?>" placeholder="Digite aqui sua resposta" value="<?= $valor ?>"/>
                   </div>
            <?
        }
          if ( $codigo == "kappa"  && false ){
            ?>
            <div class="botoes_kappa">
  				<img src="images/botoes_kappa.png"/>
            </div>
          <? }
            if ( $codigo == "rel" ){


            $lista_componente = connAccess::fetchData($oConn," select id, nome from componente where id in (".Util::NVL($item["texto"]," 0 ").")  order by nome ");
            $tx = Util::arrayToString($lista_componente, "nome"," , "); // componente_template::carregaCheckBox($lista_componente, @$item["texto"], "input_".$item["id_item"]);

                ?>

                   <a href="#a_<?= $item["id"] ?>" onclick="showMe('div_rel_<?= $item["id"] ?>'); " class="button bt_centro" name="a_<?= $item["id_item"] ?>">CLIQUE PARA VER A LISTA DE COMPONENTES QUE ESCOLHEMOS PARA O “Pessoas (físicas & jurídicas)”</a>
                    <div style="display:none" id="div_rel_<?= $item["id"] ?>" class="lista_componente">
                     <?
                     echo ( $tx );
                     ?>

                    </div>


            </td>

           <? }
	       if ( $codigo == "imagem" ){
            ?>
            <div class="imagem">

                <?
                 if ( strtolower( $item["codigo"] ) == "imagem" && $item["texto"] != "" ){

                        $dir_image  = K_RAIZ_DOMINIO .  "files/componente_template/";
                        $final_img =$dir_image.trim($item["texto"]); ?>

                            <img src="<?=$final_img?>" >
                   <?
                    }

                    ?>

            </div>
          <? }


    }

   static function mostraPagina( $id ){

       global $oConn;

       $registro = connAccess::fastOne($oConn,"custom.componente_template"," id = ". $id);

       $reg_capitulo = connAccess::fastOne($oConn,"custom.capitulo", " id = ". $id );
       ?>

        <section class="headz">
          <div class="wrapper" style="color: #<?=$reg_capitulo["cor_texto"] ?>; background-color: #<?=$reg_capitulo["cor_fundo"] ?>;">
           <!-- Texto do H1 deve vir do título do capitulo -->
           <h2 class="cover-title"><?= $registro["nome"] ?></h2>

            <? if ( @$registro["id_usuario_autor"] != "" ) {
                $usuario = connAccess::fastOne($oConn,"usuario"," id = ". @$registro["id_usuario_autor"]);
                $lista_imagens = Usuario::getImagesUser( @$registro["id_usuario_autor"], "" );
                ?>
              <div class="author">
                    <div class="author-content">

                      <span class="author-bar">Autor</span>

                      <div class="popups popups-right">
                          <? if ( count($lista_imagens) > 0 ) {
                              ?>
                                         <img class="avatar-mini" src="<?=Usuario::mostraImagemUser($lista_imagens[0]["imagem"], @$registro["id_usuario_autor"]); ?>" />
                          <? } ?>
                        <span>
                        <div class="content-popup">
                          <? if ( count($lista_imagens) > 0 ) {
                          ?>
                                         <img class="avatar-medium" src="<?=Usuario::mostraImagemUser($lista_imagens[0]["imagem"], @$registro["id_usuario_autor"]); ?>" />
                          <? } ?>
                          <h3><?= $usuario["nome_completo"] ?></h3>
                          <p><?= $usuario["obs"] ?></p>
                        </div>
                        </span>
                      </div>

                    </div><!-- /author-content -->
                  </div><!-- /author -->
            <? } ?>

                  <section class="core">
       <?

           $lista = componente_template_item::getListaItens( $id );

          // print_r( $lista );
           for ( $i = 0; $i < count($lista); $i++ ){

               $item = $lista[$i];
               $codigo = strtolower( $item["codigo"] );

                    if ( $codigo == "texto-m" ){
                       ?>
                              <p><?=$item["texto"]?></p>
                       <?
                    }


                     if ( $codigo == "imagem" ){

                         $arp = explode("##delimiter##", $item["texto"]);

                         $titulo = @$arp[0];
                         $tamanho = @$arp[1];
                         $align = @$arp[2];
                         $imagem = @$arp[3];

                         $classe = "";
                         if ( $tamanho != ""){
                             if ( $tamanho == "Pequeno" ){
                                 $classe .= " img-big";
                             }
                              if ( $tamanho == "Médio" ){
                                 $classe .= " img-med";
                             }
                               if ( $tamanho == "Grande" ){
                                 $classe .= " img-big";
                             }
                         }
                          if ( $align != ""){
                              if ( $align == "Direita" ){
                                  $classe .= " float-right";
                              }
                              if ( $align == "Esquerda" ){
                                  $classe .= " float-left";
                              }
                              if ( $align == "Centro" ){
                                  $classe .= " float-center";
                              }
                         }

                         $final_img  = K_RAIZ_DOMINIO .  "files/componente_template/" . $imagem;

                                ?>
                                  <div class="img<?=$classe?>">
                                    <span><?=$titulo?></span>
                                    <img src="<?=$final_img?>" alt="<?=$titulo?>">
                                  </div>
                            <?
                            }
                            if ( $codigo == "texto" ){ //Título..
                                ?>
                                       <h3><?=$item["texto"]?></h3>
                                <?
                            }
                       }

                       ?>
                           </section>
                         </div>
                       </section>
                  <?

   }



    static function mostraDragDivGrande($item) {

        global $dir_image;

        $final_img = "../files/templates/" . $item["imagem_miniatura"];

        if (strtolower($item["codigo"]) == "imagem" && $item["texto"] != "") {

            $ar = explode("##delimiter##", $item["texto"]);

            $final_img = $dir_image . trim(@$ar[3]); // trim($item["texto"]);
        }
        ?>

        <div class="drop-saved" id="div_comp_<?= $item["id_item"] ?>" style="display: block;">
            <table style="width: 99%">
                <tr>
                    <td style="width: 29px">

                        <img src = "<?= $final_img ?>" class="drop-saved-img" id="img_prev_<?= $item["id_item"] ?>" title="<?= $item["nome"] ?>" height="48">
                    </td><td>
                        <span id="sp_comp_<?= $item["id_item"] ?>" >

                            <?= componente_template::InputCampo($item); ?>
                        </span>
                    </td>
                    <td style="width: 70px">
                        <?
                        $nome_campo = 'input_' . $item["id_item"];

                        if (strpos(" " . strtolower($item["codigo"]), "texto")) {
                            ?>

                            <button onclick="editar_textarea('<?= $nome_campo ?>')"  type="button" class="btn btn-primary btn-small"
                                    data-toggle="modal" data-target="#myModalTextArea">
                                Editar
                            </button>

            <? if (false) { ?>
                                <a href="custom/frame_template.php?campo=<?= $nome_campo ?>" class="iframe_modal" >
                                    <span class="icon icon-action icon-pencil text-warning"></span>
                                </a>    <? } ?>

        <? } ?>
                    </td>
                </tr>
            </table>
                                                                                                                                                                            <!-- #ID#<?= $item["id"] ?>#ID# -->
                                                                                                                                                                            <!-- #IDITEM#<?= $item["id_item"] ?>#IDITEM# -->
            <input type="hidden" name="hd_comp_<?= $item["id_item"] ?>" id="hd_comp_<?= $item["id_item"] ?>" value="<?= $item["id_item"] ?>" >
        </div>

        <?
    }

    static function mostraMenuDetalhado($idFerramenta) {

        $listaComponenteTemplate = self::getComponenteTemplateByFerramenta($idFerramenta);

        $total = count($listaComponenteTemplate);
        ?>
        <div class="menu_relato_lista">
            <div class="colum_left">
                <?
                //Imprime na esquerda
                for ($i = 0; $i < $total / 2; $i++) {

                    $registro = $listaComponenteTemplate[$i];

                    $imagem = K_RAIZ_DOMINIO . "files/icons/" . $registro["imagem01"];
                    ?>

                    <div class="menu_relato_escolhido left-tip" data-tips="<?= $registro['descricao'] ?>">
                        <img class="icon_menu_relato" src="<?= $imagem ?>">
                        <div class="nome_menu_relato" style="background: <?= "#" . $registro["cor"] ?>"><?= $registro["nome"] ?></div>
                    </div>
                    <?
                    if ($i % 2 != 0) {
                        ?>
                        <div class="espaco"></div>
                        <?
                    }
                }
                ?>
            </div><!--colum_left-->
            <div class="colum_right">
                <?
                //Imprime na direita
                for ($i = $total / 2; $i < $total; $i++) {

                    $registro = $listaComponenteTemplate[$i];

                    $imagem = K_RAIZ_DOMINIO . "files/icons/" . $registro["imagem01"];
                    ?>

                    <div class="menu_relato_escolhido right-tip" data-tips="<?= $registro['descricao'] ?>">
                        <img class="icon_menu_relato" src="<?= $imagem ?>">
                        <div class="nome_menu_relato" style="background: <?= "#" . $registro["cor"] ?>"><?= $registro["nome"] ?></div>
                    </div>
                    <?
                    if ($i % 2 != 0) {
                        ?>
                        <div class="espaco"></div>
                        <?
                    }
                }
                ?>
            </div><!--colum_right-->
        </div><!--menu_relato_lista-->

        <?
    }

    static function mostraMenuSimplificado($idFerramenta) {

        $listaComponenteTemplate = self::getComponenteTemplateByFerramenta($idFerramenta);
        ?>
        <div class="menu_relato_lista_min">
            <?
            for ($i = 0; $i < count($listaComponenteTemplate); $i++) {
                $registro = $listaComponenteTemplate[$i];
                $imagem = K_RAIZ_DOMINIO . "files/icons/" . $registro["imagem01"];
                ?>
                <div class="menu_relato_escolhido hint--bottom" data-hint="<?= $registro["nome"] ?>">
                    <img class="icon_menu_relato" src="<?= $imagem ?>">
                </div>
                <?
                if ($i % 2 != 0) {
                    ?>
                    <div class="espaco"></div>
                    <?
                }
            }
            ?>
        </div><!-- /menu_relato_lista_min -->
        <?
    }

    public static function getComponenteTemplateByModulo($idModulo, $codigo_grupo = "") {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = " select ct.*, ic.imagem as imagem01, ic2.imagem as imagem02
                from custom.componente_template ct
             left join icone ic on ic.id = ct.id_icone1
             left join icone ic2 on ic2.id = ct.id_icone2
             left join custom.grupo_componente_template gct on gct.id = ct.id_grupo
             where ct.id_modulo = " . $idModulo;

        if (!empty($codigo_grupo)) {
            $sql.=" and gct.codigo = '" . $codigo_grupo . "'";
        }

        $sql.= " and coalesce(ct.status,'') not in ('rascunho') order by ct.ordem asc";

        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    public static function getComponenteTemplateByFerramenta($idFerramenta, $codigo_grupo = "") {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = " select ct.*, ic.imagem as imagem01, ic2.imagem as imagem02
                from custom.componente_template ct
             left join icone ic on ic.id = ct.id_icone1
             left join icone ic2 on ic2.id = ct.id_icone2
             left join custom.grupo_componente_template gct on gct.id = ct.id_grupo
             where ct.id_ferramenta = " . $idFerramenta;

        if (!empty($codigo_grupo)) {
            $sql.=" and gct.codigo = '" . $codigo_grupo . "'";
        }

        $sql.= " and coalesce(ct.status,'') not in ('rascunho') order by ct.ordem asc";

        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    public static function getComponenteTemplateById($id) {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = " select ct.*, ic.imagem as imagem01, ic2.imagem as imagem02
                from custom.componente_template ct
             left join icone ic on ic.id = ct.id_icone1
             left join icone ic2 on ic2.id = ct.id_icone2
             where ct.id = " . $id . " and coalesce(ct.status,'') not in ('rascunho') order by ct.ordem asc";

        $result = connAccess::fetchData($oConn, $sql);

        if (count($result) > 0) {
            return $result[0];
        }
    }

    public static function findComponenteTemplateByGrupo($codigo_grupo) {

        global $oConn;

        $sql = "select ct.* from custom.componente_template ct left join custom.grupo_componente_template gct on gct.id = ct.id_grupo where gct.codigo = '" . $codigo_grupo . "' order by nome asc";

        return connAccess::fetchData($oConn, $sql);
    }

}
?>
