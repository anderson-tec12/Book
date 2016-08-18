<?php
require_once 'library/interfaces/interface_component.php';
require_once 'inc_ferramenta.php';

if (file_exists(K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php")) {
    require_once K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php";
}

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("ferramenta");

$dir_image_icon = url_files . "/icons/";

if ($ispostback) {

    if ($id != "")
        $registro = connAccess::fastOne($oConn, "ferramenta", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["titulo"] = Util::request($prefixo . "titulo");
    $registro["descricao"] = Util::request($prefixo . "descricao");
    $registro["instrucao_uso"] = Util::request($prefixo . "instrucao_uso");
    $registro["video"] = Util::request($prefixo . "video");
    $registro["link_saiba_mais"] = Util::request($prefixo . "link_saiba_mais");
    $registro["palavra_chave"] = Util::request($prefixo . "palavra_chave");
    $registro["ferramentas_relacionadas"] = Util::request($prefixo . "ferramentas_relacionadas");
    $registro["cor"] = Util::request($prefixo . "cor");
    $registro["id_icone1"] = Util::numeroBanco(Util::request($prefixo . "id_icone1"));
    $registro["id_icone2"] = Util::numeroBanco(Util::request($prefixo . "id_icone2"));
    $registro["tipo_ferramenta"] = Util::request($prefixo . "tipo_ferramenta");
    $registro["id_conteudo_assinado_1"] = Util::request($prefixo . "conteudo_assinado_1_id");
    $registro["id_conteudo_assinado_2"] = Util::request($prefixo . "conteudo_assinado_2_id");
    $registro["id_conteudo_assinado_3"] = Util::request($prefixo . "conteudo_assinado_3_id");
    $registro["id_conteudo_assinado_4"] = Util::request($prefixo . "conteudo_assinado_4_id");
    
    
    $registro["pasta"] = Util::request($prefixo . "pasta");
    $registro["url_visualizar"] = Util::request($prefixo . "url_visualizar");
    $registro["url_abrir"] =Util::request($prefixo . "url_abrir");
    
    $registro["url_visualizar_como"] = Util::request($prefixo . "url_visualizar_como");
    $registro["url_abrir_como"] =Util::request($prefixo . "url_abrir_como");
    
    
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    if (!@$registro["id"]) {

        $registro["id"] = connAccess::Insert($oConn, $registro, "ferramenta", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "ferramenta", "id");
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "DEL" && $id != "") {

    $registro = connAccess::fastOne($oConn, "ferramenta", " id = " . $id);
    connAccess::Delete($oConn, $registro, "ferramenta", "id");

    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";

    $id = "";
    $registro = $oConn->describleTable("ferramenta");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "ferramenta", " id = " . $id);
}
?>
<?
Util::mensagemCadastro(85);
?>

<link href="library/select_image/dd.css" rel="stylesheet">
<div class="row">
    <div class="col-xs-12">


        <h1 class="sistem-title">Cadastro de Ferramenta</h1>

        <p>Campos com * são de preenchimento obrigatório.</p>

        <form method="post" name="frm" action="index.php?pag=<?= Util::request("pag") ?>&mod=<?= Util::request("mod") ?>&path=<?= Util::request("path") ?>">

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
            $eh_primarykey = True;
            $visible_in_html = '';

            if ($eh_primarykey && $registro["id"] == "") {
                $visible_in_html = " style='display:none' ";
            }
            ?>
            <div <? echo ($visible_in_html); ?> id="tr_id" >
                <div class="form-group">
                    <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>

                    <span class="mostrapk"><?= $registro["id"] ?></span>
                    <input type="hidden"  name="id" value="<?= $registro["id"] ?>"  >

                </div>
            </div>

            <?
            $eh_primarykey = False;
            $visible_in_html = '';

            if ($eh_primarykey && $registro["codigo"] == "") {
                $visible_in_html = " style='display:none' ";
            }
            ?>
            <div class="row">
                <div class="col-xs-8">
                    <div <? echo ($visible_in_html); ?> id="tr_codigo" >
                        <div class="form-group">
                            <label for="codigo">Código<span class="campoObrigatorio" > *</span></label>

                            <input type="text"  name="codigo" value="<?= $registro["codigo"] ?>"  class="form-control" maxlength="30" readonly="true">

                        </div>
                    </div>


                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["titulo"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_titulo" >
                        <div class="form-group">
                            <label for="titulo">Título<span class="campoObrigatorio" > *</span></label>

                            <input type="text"  name="titulo" value="<?= $registro["titulo"] ?>"  class="form-control" maxlength="300">

                        </div>
                    </div>



                    <!-- Ferramentas Relacionadas -->

                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["descricao"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_descricao" >
                        <div class="form-group">
                            <label for="descricao">Descrição<span class="campoObrigatorio"  style="display:none" > *</span></label>

                            <textarea id="descricao" name="descricao" class="form-control"
                                      ><?= $registro["descricao"] ?></textarea>

                        </div>
                    </div>


                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["id_icone2"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_tipo_ferramenta" >
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="tipo_ferramenta">Tipo de Ferramenta</label>
                                    <?
                                    $lst = inc_ferramenta::listarTipoFerramenta();
                                    ?>

                                    <select name="tipo_ferramenta" id="tipo_ferramenta" class="form-control">
                                        <option value="">--SELECIONE--</option>
                                        <?
                                        Util::CarregaComboArray($lst, "cod", "descr", $registro["tipo_ferramenta"]);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["instrucao_uso"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_instrucao_uso" >
                        <div class="form-group">
                            <label for="instrucao_uso">Instruções de Uso<span class="campoObrigatorio"  style="display:none" > *</span></label>

                            <textarea id="instrucao_uso" name="instrucao_uso" class="form-control"
                                      ><?= $registro["instrucao_uso"] ?></textarea>

                        </div>
                    </div>


                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["video"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_video" >
                        <div class="form-group">
                            <label for="video">Vídeo<span class="campoObrigatorio"  style="display:none" > *</span></label>

                            <input type="text"  name="video" value="<?= $registro["video"] ?>"  class="form-control" maxlength="300">

                        </div>
                    </div>

                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["link_saiba_mais"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_video" >
                        <div class="form-group">
                            <label for="link_saiba_mais">Link Saiba Mais <span class="campoObrigatorio"  style="display:none" > *</span></label>
                            <input type="text"  name="link_saiba_mais" value="<?= $registro["link_saiba_mais"] ?>"  class="form-control" maxlength="300">
                        </div>
                    </div>


                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["palavra_chave"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_palavra_chave" >
                        <div class="form-group">
                            <label for="palavra_chave">Palavras Chave<span class="campoObrigatorio"  style="display:none" > *</span></label>

                            <textarea id="palavra_chave" name="palavra_chave" class="form-control"
                                      ><?= $registro["palavra_chave"] ?></textarea>

                        </div>
                    </div>


                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["id_icone1"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>


                    <div <? echo ($visible_in_html); ?> id="tr_id_icone1" >
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="id_icone1">Icone Positivo</label>
                                    <select name="id_icone1" id="id_icone1" class="form-control">
                                        <?
                                        $lista = connAccess::fetchData($oConn, " select id, nome, imagem from icone order by nome ");
                                        for ($i = 0; $i < count($lista); $i++) {
                                            $arr = $lista[$i];
                                            $url = $dir_image_icon . $arr["imagem"];
                                            echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $registro["id_icone1"]) );
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div><!-- End ROW -->
                    </div>

                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["id_icone2"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>
                    <div <? echo ($visible_in_html); ?> id="tr_id_icone2" >
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="id_icone1">Icone Negativo</label>
                                    <select name="id_icone2" id="id_icone2" class="form-control">
                                        <?
                                        for ($i = 0; $i < count($lista); $i++) {
                                            $arr = $lista[$i];
                                            $url = $dir_image_icon . $arr["imagem"];
                                            echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $registro["id_icone2"]) );
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    $eh_primarykey = False;
                    $visible_in_html = '';

                    if ($eh_primarykey && $registro["cor"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>

                    <div <? echo ($visible_in_html); ?> id="tr_cor" >
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="cor">Cor de Fundo</label>
                                    <input type="text" name="cor" id="cor" maxlength="8" value="<?= $registro["cor"] ?>" class="form-control color" >
                                </div>
                            </div><!-- End Col 6 -->
                        </div><!-- End Row -->
                    </div>

                    
              
            
               <div <? echo ($visible_in_html); ?> id="tr_instrucao_uso" >
                <div class="form-group">
                    <label for="o_que_faz">Pasta da Ferramenta<span class="campoObrigatorio"  style="display:none" > *</span></label>

                    <input type="text" id="pasta" name="pasta" class="form-control"
                              value="<?= $registro["pasta"] ?>">
                </div>
                <div class="form-group">
                    <table>
                        <tr>
                            <td>
                               <label for="url_abrir">URL de Abertura<span class="campoObrigatorio"  style="display:none" > *</span></label>

                    <input type="text" id="url_abrir" name="url_abrir" class="form-control"
                              value="<?= $registro["url_abrir"] ?>" title="URL usada para abrir o módulo"> 
                            </td>
                            
                            <td>
                                
                                
                                  <label for="fase">Abrir como</label>
                    <?
                    $ls_abrir = array();
                    $ls_abrir[ count($ls_abrir)] = array("cod"=>"Painel");
                    $ls_abrir[ count($ls_abrir)] = array("cod"=>"Popup");
                    ?>

                    <select name="url_abrir_como" id="url_abrir_como" class="form-control">
                        <?
                        Util::CarregaComboArray($ls_abrir, "cod", "cod", $registro["url_abrir_como"]);
                        ?>
                    </select>
                                
                            </td>
                            
                            
                        </tr>
                        
                    </table>
                    
                </div>
                <div class="form-group">
                       <table>
                        <tr>
                            <td>
                    <label for="url_abrir">URL de Visualização<span class="campoObrigatorio"  style="display:none" > *</span></label>

                    <input type="text" id="url_visualizar" name="url_visualizar" class="form-control"
                              value="<?= $registro["url_visualizar"] ?>" title="URL usada para visualizar caso o registro já tenha sido criado">
                    
                    
                            </td>
                      <td>
                                
                                
                                  <label for="fase">Abrir como</label>
                 

                    <select name="url_abrir_como" id="url_abrir_como" class="form-control">
                        <?
                        Util::CarregaComboArray($ls_abrir, "cod", "cod", $registro["url_abrir_como"]);
                        ?>
                    </select>
                                
                            </td>
                    
                        </tr>
                        
                    </table>
                    
                </div>
             </div>
             
                    
                    <?
                    if ($registro['relacionar_conteudo_assinado'] == 't') {
                        ?>
                        <h2 class="sistem-title">Conteúdos Assinados</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Relacionamento de Conteúdos Assinados</div>
                            <div class="panel-body">
                                    <div class="form-group">
                                        <?
                                        $conteudoAssinado1 = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado_1']);
                                        ?>
                                        <label for="conteudo_assinado_1">Conteúdo Assinado 1</label>
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <input type="hidden" class="form-control" name="conteudo_assinado_1_id" id="conteudo_assinado_1_id" value="<?= is_null($conteudoAssinado1) ? "" : $conteudoAssinado1['id'] ?>">
                                                <input type="text" class="form-control" name="conteudo_assinado_1_titulo" id="conteudo_assinado_1_titulo" readonly value="<?= is_null($conteudoAssinado1) ? "" : $conteudoAssinado1['titulo'] . ' - ' . $conteudoAssinado1['nome_completo'] ?>">
                                            </div>
                                            <div class="col-xs-2">
                                                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado_1');">Selecionar</button>
                                            </div>
                                        </div>
                                    </div>
                               
                                <div class="form-group">
                                    <?
                                    $conteudoAssinado2 = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado_2']);
                                    ?>
                                    <label for="conteudo_assinado_2">Conteúdo Assinado 2</label>
                                    <div class="row">
                                        <div class="col-xs-10">
                                             <input type="hidden" class="form-control" name="conteudo_assinado_2_id" id="conteudo_assinado_2_id" value="<?= is_null($conteudoAssinado2) ? "" : $conteudoAssinado2['id'] ?>">
                                    <input type="text" class="form-control" name="conteudo_assinado_2_titulo" id="conteudo_assinado_2_titulo" readonly value="<?= is_null($conteudoAssinado2) ? "" : $conteudoAssinado2['titulo'] . " - " . $conteudoAssinado1['nome_completo'] ?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado_2');">Selecionar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?
                                    $conteudoAssinado3 = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado_3']);
                                    ?>
                                    <label for="conteudo_assinado_3">Conteúdo Assinado 3</label>
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <input type="hidden" class="form-control" name="conteudo_assinado_3_id" id="conteudo_assinado_3_id" value="<?= is_null($conteudoAssinado3) ? "" : $conteudoAssinado3['id'] ?>">
                                    <input type="text" class="form-control" name="conteudo_assinado_3_titulo" id="conteudo_assinado_3_titulo" readonly value="<?= is_null($conteudoAssinado3) ? "" : $conteudoAssinado3['titulo'] . ' - ' . $conteudoAssinado3['nome_completo'] ?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado_3');">Selecionar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?
                                    $conteudoAssinado4 = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado_4']);
                                    ?>
                                    <label for="conteudo_assinado_4">Conteúdo Assinado 4</label>
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <input type="hidden" class="form-control" name="conteudo_assinado_4_id" id="conteudo_assinado_4_id" value="<?= is_null($conteudoAssinado4) ? "" : $conteudoAssinado4['id'] ?>">
                                            <input type="text" class="form-control" name="conteudo_assinado_4_titulo" id="conteudo_assinado_4_titulo" readonly value="<?= is_null($conteudoAssinado4) ? "" : $conteudoAssinado4['titulo'] . " - " . $conteudoAssinado1['nome_completo'] ?>">
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado_4');">Selecionar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div><!-- End Col 8 -->
                <div class="col-xs-4">
                    <label>&nbsp;</label>
                    <?
                    if (file_exists(K_DIR . "custom/inc_ferramentas_relacionadas.php")) {
                        include K_DIR . "custom/inc_ferramentas_relacionadas.php";
                    }
                    ?>

                    <?
                    if ($registro['codigo'] == 'conflito') {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Função Analítica
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <a class="botao btn btn-info" href="index.php?mod=listar&pag=conflito_pergunta&tipo">Perguntas da Função Analítica</a>
                                </div>
                                <div class="form-group">
                                    <a class="botao btn btn-info" href="index.php?mod=listar&pag=conflito_avaliativo_item&tipo">Itens da Função Avaliativa</a>
                                </div>
                                <div class="form-group">
                                    <a class="botao btn btn-info" href="index.php?mod=listar&pag=conflito_preditivo_item&tipo">Itens da Função Preditiva</a>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                    
                     <?
                    if ($registro['codigo'] == 'competicao') {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Fases da Competição
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <a class="botao btn btn-info" href="index.php?mod=listar&pag=competicao_fase">Cadastro Fases</a>
                                </div>
                              
                            </div>
                        </div>
                        <?
                    }
                    ?>
                    
                    
                </div>
            </div>
    </div><!-- End Col 12 -->
</div> <!-- End Row -->

<input type="button" class="botao btn btn-success" onclick="salvar()" value="Salvar">

</form>

<div class="interMenu">
    <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo") . "&path=" . Util::request("path")) ?>
</div>
</div>
</div>

<link href="<?= K_RAIZ ?>library/colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css">
<script src="http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js"></script>
<script src="<?= K_RAIZ ?>custom/js/jquery.dd.min.js"></script>
<script type="text/javascript" src="<?= K_RAIZ ?>library/colorpicker/jscolor/jscolor.js"></script>
<script type="text/javascript" src="<?= K_RAIZ ?>painel/analise/js/template_analise.js"></script>

<script type="text/javascript">

    window.onload = displayColors;

    $(function () {
        setRaizSistema('<?= K_RAIZ ?>');
    });

    function salvar() {
        var f = document.forms[0];
        if (isVazio(f.codigo, 'Informe Código!')) {
            return false;
        }
        if (isVazio(f.titulo, 'Informe Título!')) {
            return false;
        }
        f.acao.value = "<?= ( Util::$SAVE) ?>";
        f.submit();
    }

    function displayColors() {
        var bgColor = $('#cor').css('background-color');
        var txtColor = $('#cor').css('color');
        $('.pr_view').css('background-color', bgColor);
        $('.pr_view').css("color", txtColor);
    }

    $('#cor').change(displayColors);
    $("#id_icone1").msDropDown();
    $("#id_icone2").msDropDown();

</script>

<?
if (file_exists(K_DIR . "custom/pop_pesquisa_conteudo_assinado.php")) {
    include K_DIR . "custom/pop_pesquisa_conteudo_assinado.php";
}