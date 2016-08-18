<?php
require_once 'inc_modulo.php';
require_once 'inc_ferramenta.php';

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("modulo");
$ferramentaSelecionadas = array();

$dir_image_icon = url_files . "/icons/";

if ($ispostback) {

    if ($id != "")
        $registro = connAccess::fastOne($oConn, "modulo", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["titulo"] = Util::request($prefixo . "titulo");
    $registro["descricao"] = Util::request($prefixo . "descricao");
    $registro["fase"] = Util::request($prefixo . "fase");
    $registro["instrucao_uso"] = Util::request($prefixo . "instrucao_uso");
    $registro["video"] = Util::request($prefixo . "video");
    $registro["id_icone1"] = Util::numeroBanco(Util::request($prefixo . "id_icone1"));
    $registro["id_icone2"] = Util::numeroBanco(Util::request($prefixo . "id_icone2"));
    
    
    $registro["o_que_faz"] = Util::request($prefixo . "o_que_faz");
    $registro["sequencia_uso"] = Util::request($prefixo . "sequencia_uso");
    
    
    $registro["sequencia_uso"] = Util::request($prefixo . "sequencia_uso");
    $registro["pasta"] = Util::request($prefixo . "pasta");
    $registro["url_visualizar"] = Util::request($prefixo . "url_visualizar");
    $registro["url_abrir"] =Util::request($prefixo . "url_abrir");
    
    $registro["url_visualizar_como"] = Util::request($prefixo . "url_visualizar_como");
    $registro["url_abrir_como"] =Util::request($prefixo . "url_abrir_como");
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    $registro["id"] = inc_modulo::saveModulo($registro);

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "DEL" && $id != "") {

    $registro = connAccess::fastOne($oConn, "modulo", " id = " . $id);
    connAccess::Delete($oConn, $registro, "modulo", "id");

    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";

    $id = "";
    $registro = $oConn->describleTable("modulo");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "modulo", " id = " . $id);
}
?>
<?
Util::mensagemCadastro(85);
?>

<link href="library/select_image/dd.css" rel="stylesheet">

<div class="row">
    <div class="col-xs-12">
        <h1 class="sistem-title">Cadastro de Módulo</h1>

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
            <div <? echo ($visible_in_html); ?> id="tr_codigo" >
                <div class="form-group">
                    <label for="codigo">Código<span class="campoObrigatorio" > *</span></label>

                    <input type="text"  name="codigo" value="<?= $registro["codigo"] ?>"  class="form-control" maxlength="30" readonly="true">

                </div>
            </div>

            <?
            $eh_primarykey = False;
            $visible_in_html = '';

            if ($eh_primarykey && $registro["fase"] == "") {
                $visible_in_html = " style='display:none' ";
            }
            ?>
            <div <? echo ($visible_in_html); ?> id="tr_fase" >

                <div class="form-group">
                    <label for="fase">Fase</label>
                    <?
                    $lst = inc_ferramenta::listarFaseModulo();
                    ?>

                    <select name="fase" id="fase" class="form-control">
                        <option value="">--SELECIONE--</option>
                        <?
                        Util::CarregaComboArray($lst, "cod", "descr", $registro["fase"]);
                        ?>
                    </select>
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
              <div <? echo ($visible_in_html); ?> id="tr_instrucao_uso" >
                <div class="form-group">
                    <label for="o_que_faz">O que faz (Otimize o Ritmo)<span class="campoObrigatorio"  style="display:none" > *</span></label>

                    <textarea id="o_que_faz" name="o_que_faz" class="form-control"
                              ><?= $registro["o_que_faz"] ?></textarea>

                </div>
            </div>
            
          
              <div <? echo ($visible_in_html); ?> id="tr_instrucao_uso" >
                <div class="form-group">
                    <label for="sequencia_uso">Sequência de Uso (Otimize o Ritmo)<span class="campoObrigatorio"  style="display:none" > *</span></label>

                    <textarea id="sequencia_uso" name="sequencia_uso" class="form-control"
                              ><?= $registro["sequencia_uso"] ?></textarea>

                </div>
            </div>
            
            
               <div <? echo ($visible_in_html); ?> id="tr_instrucao_uso" >
                <div class="form-group">
                    <label for="o_que_faz">Pasta do Módulo<span class="campoObrigatorio"  style="display:none" > *</span></label>

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

			<div class="row">
                <div class="col-xs-12">
                    <label>&nbsp;</label>
                    <?
                    if ($registro['codigo'] == 'm32') {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Opções do Módulos
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <a class="botao btn btn-info" href="index.php?mod=listar&pag=tipo_acordo&tipo">Tipos de Acordo</a>
                                    <a class="botao btn btn-info" href="index.php?mod=listar&pag=termo_legal&tipo">Termos Legais</a>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div>
            </div>

            <input type="button" class="botao btn btn-success" onclick="salvar()" value="Salvar">

        </form>
        <div class="interMenu">
            <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo") . "&path=" . Util::request("path")) ?>
        </div>
    </div>
</div>

<script src="http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js"></script>
<script src="<?= K_RAIZ ?>custom/js/jquery.dd.min.js"></script>

<script type="text/javascript">
                function salvar() {
                    var f = document.forms[0];

                    if (isVazio(f.titulo, 'Informe Título!')) {
                        return false;
                    }
                    f.acao.value = "<?= ( Util::$SAVE) ?>";
                    f.submit();
                }

                $("#id_icone1").msDropDown();
                $("#id_icone2").msDropDown();
</script>