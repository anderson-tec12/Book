<?
require_once 'inc_componente_template_item.php';

class componente_template
{

    static function carregaForm(&$registro)
    {


        global $oConn;

        $prefixo                    = "";
        $registro["id"]             = Util::request($prefixo."id");
        $registro["nome"]           = Util::request($prefixo."nome");
        $registro["descricao"]      = Util::request($prefixo."descricao");
        $registro["instrucoes_uso"] = Util::request($prefixo."instrucoes_uso");
        $registro["modulos"]        = Util::getIDS("modulos"); // Util::request($prefixo."modulos");
        //
                    $registro["tx_modulos"]     = Util::arrayToString(connAccess::fetchData($oConn,
                    " select nome from componente where id in ( ".Util::NVL($registro["modulos"],
                        "0 ")." ) "), "nome", ", ");
        $registro["id_icone1"]      = Util::numeroBanco(Util::request($prefixo."id_icone1"));
        $registro["id_icone2"]      = Util::numeroBanco(Util::request($prefixo."id_icone2"));
    }

    static function carregaCheckBox($rslista, $ids_salvas = "",
                                    $prefixo = "mod", $field_query_val = "id",
                                    $field_query_text = "nome", $sep = "&nbsp;")
    {


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

            $saida .= $sep.'<input type="checkbox" value="'.$item[$field_query_val].'" name="'.$prefixo.'_'.$i.'" id="'.$prefixo.'_'.$i.'"
                                        '.$continua.'>'.$item[$field_query_text].'&nbsp;&nbsp;&nbsp;';
        }
        return $saida;
    }

    static function salvaItens($id, $lista)
    {
        global $oConn;
        global $dir_image;


        $str_id_itens = " 0 ";

        $ar = explode(",", $lista);

        for ($i = 0; $i < count($ar); $i++) {

            if (trim($ar[$i]) == "") continue;

            $campos = explode("|", $ar[$i]);

            $str_id_itens .=", ".$campos[0];

            $item = connAccess::fastOne($oConn,
                    "custom.componente_template_item", " id = ".$campos[0]);

            //$item = $oConn->describleTable("custom.componente_template_item");

            $item["id_componente_template"] = $id;
            $item["id_item_componente"]     = $campos[1];
            $item["ordem"]                  = $i + 1;
            $item["texto"]                  = Util::request("input_".$campos[0]);
            $item["status"]                 = "salvo";

            $str_codigo = strtolower(connAccess::executeScalar($oConn,
                    " select codigo from custom.item_componente where id = ".$item["id_item_componente"]));

            if ($str_codigo == "rel") {

                $item["texto"] = Util::getIDS("input_".$campos[0]);
            }

            //
            if ($str_codigo == "imagem") {

                $campo_upload = "input_file_".$campos[0];



                if ($_FILES[$campo_upload]['name'] != "" && $_FILES[$campo_upload]["size"] > 0) {

                    //Remove imagem antiga no caso de edição
                    //if (!isset($registro["imagem"])) {
                    //    unlink($dir_image.$registro["imagem"]);
                    //}
                    $uploadImagem = new UploadImage();

                    //Realiza upload da imagem
                    $item["texto"] = $uploadImagem->doUploadFile($_FILES[$campo_upload],
                        $dir_image);
                    //print_r( $_FILES[$campo_upload] ); die ( " ---> ". $str_codigo . " - ". $registro["texto"]);
                }
                //die(" --- ");
            }
            //print_r( $item ); die(" -- ");
            connAccess::nullBlankColumns($item);
            connAccess::Update($oConn, $item, "custom.componente_template_item",
                "id");
        }

        $sql = " delete from custom.componente_template_item where id_componente_template = ".$id." and id not in ( ".$str_id_itens." ) ";

        connAccess::executeCommand($oConn, $sql);
    }

    static function InputCampo($item)
    {
        global $oConn;
        global $dir_image;

        $codigo = strtolower($item["codigo"]);

        $tx = '';
        //echo($codigo. " ---- ");
        if ($codigo == "video" || $codigo == "texto" || $codigo == "texto-m") {


            $tx = '<textarea style="width: 200px; height: 48px; border: solid 1px #CCCCCC" name="input_'.$item["id_item"].'">'.@$item["texto"].'</textarea>';
        }
        if ($codigo == "imagem") {


            $tx = '<input type="file" style="border: solid 1px #CCCCCC" name="input_file_'.$item["id_item"].'" onchange="preview(this, \'input_'.$item["id_item"].'\',\'img_prev_'.$item["id_item"].'\');">';
            $tx .= '<input type="hidden"  name="input_'.$item["id_item"].'" value="'.@$item["texto"].'">';
        }

        if ($codigo == "rel") {

            $lista_componente = connAccess::fetchData($oConn,
                    " select id, nome from componente order by nome ");
            $tx               = componente_template::carregaCheckBox($lista_componente,
                    @$item["texto"], "input_".$item["id_item"]);
        }

        return $tx;
    }

    static function mostraDragDivGrande($item)
    {

        global $dir_image;

        $final_img = "../files/templates/".$item["imagem_miniatura"];

        if (strtolower($item["codigo"]) == "imagem" && $item["texto"] != "") {

            $final_img = $dir_image.trim($item["texto"]);
        }
       ?>

<div class="drop-saved" id="div_comp_<?= $item["id_item"] ?>" style="display: block;">
    <table>
        <tr><td>
                <img src = "<?= $final_img ?>" id="img_prev_<?= $item["id_item"] ?>" title="<?= $item["nome"] ?>" height="48">
            </td><td>
                <span id="sp_comp_<?= $item["id_item"] ?>" >
                            <?= componente_template::InputCampo($item); ?>
                        </span>
                    </td></tr>
            </table>
                                <!-- #ID#<?= $item["id"] ?>#ID# -->
                                <!-- #IDITEM#<?= $item["id_item"] ?>#IDITEM# -->
            <input type="hidden" name="hd_comp_<?= $item["id_item"] ?>" id="hd_comp_<?= $item["id_item"] ?>" value="<?= $item["id_item"] ?>" >
        </div>

        <?
    }

    static function mostraMenuDetalhado()
    {

        $listaComponenteTemplate = componente_template_item::getListaComponenteTemplate();

        $total = count($listaComponenteTemplate);
        ?>
        <div class="menu_relato_lista">
            <div class="colum_left">
                <?
                //Imprime na esquerda
                for ($i     = 0; $i < $total / 2; $i++) {

                    $registro = $listaComponenteTemplate[$i];

                    $imagem = K_RAIZ_DOMINIO."files/icons/".$registro["imagem01"];
                    ?>

                    <div class="menu_relato_escolhido left-tip" data-tips="<?= $registro['descricao'] ?>">
                        <img class="icon_menu_relato" src="<?= $imagem ?>">
                        <div class="nome_menu_relato" style="background: <?= "#".$registro["cor"] ?>"><?= $registro["nome"] ?></div>
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

                    $imagem = K_RAIZ_DOMINIO."files/icons/".$registro["imagem01"];
                    ?>

                    <div class="menu_relato_escolhido right-tip" data-tips="<?= $registro['descricao'] ?>">
                        <img class="icon_menu_relato" src="<?= $imagem ?>">
                        <div class="nome_menu_relato" style="background: <?= "#".$registro["cor"] ?>"><?= $registro["nome"] ?></div>
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

    static function mostraMenuSimplificado()
    {
        $listaComponenteTemplate = componente_template_item::getListaComponenteTemplate();
        ?>
        <div class="menu_relato_lista_min">
            <?
            for ($i                       = 0; $i < count($listaComponenteTemplate); $i++) {
                $registro = $listaComponenteTemplate[$i];
                $imagem   = K_RAIZ_DOMINIO."files/icons/".$registro["imagem01"];
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
}
?>