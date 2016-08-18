<?php
if (file_exists(K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_pergunta.php")) {
    require_once K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_pergunta.php";
}

if (file_exists(K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_resposta.php")) {
    require_once K_DIR . "painel/ferramentas/conflito/bd/conflito_analitico_resposta.php";
}

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("conflito_analitico_pergunta");

$bdConflitoAnaliticoPergunta = new ConflitoAnaliticoPergunta($oConn);
$bdConflitoAnaliticoResposta = new ConflitoAnaliticoResposta($oConn);

$dir_image_icon = url_files . "/icons/";

if ($ispostback) {
    if ($id != "")
        $registro = connAccess::fastOne($oConn, "conflito_analitico_pergunta", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["pergunta"] = Util::request($prefixo . "pergunta");
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);


    $registro["id"] = $bdConflitoAnaliticoPergunta->salvar($registro);

    $codigoResposta1 = Util::request($prefixo . "resposta_1_codigo");
    if (!empty($codigoResposta1)) {
        //$codigoResposta1 = Util::request($prefixo . "resposta_1_codigo");
        $resposta1 = $bdConflitoAnaliticoResposta->buscaPorCodigo($codigoResposta1);
        if (!is_null($resposta1)) {
            $resposta1['resposta'] = Util::request($prefixo . "resposta_1");
            $resposta1["id_icone"] = Util::numeroBanco(Util::request($prefixo . "resposta_1_icone"));
            $resposta1["contextualizacao"] = Util::request($prefixo . "resposta_1_contexto");
            $bdConflitoAnaliticoResposta->salvar($resposta1);
        }
    }

    $codigoResposta2 = Util::request($prefixo . "resposta_2_codigo");
    if (!empty($codigoResposta2)) {
        $resposta2 = $bdConflitoAnaliticoResposta->buscaPorCodigo($codigoResposta2);
        if (!is_null($resposta2)) {
            $resposta2['resposta'] = Util::request($prefixo . "resposta_2");
            $resposta2["id_icone"] = Util::numeroBanco(Util::request($prefixo . "resposta_2_icone"));
            $resposta2["contextualizacao"] = Util::request($prefixo . "resposta_2_contexto");
            $bdConflitoAnaliticoResposta->salvar($resposta2);
        }
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";

    $id = $registro["id"];
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "conflito_analitico_pergunta", " id = " . $id);
}

Util::mensagemCadastro(85);

$respostas = $bdConflitoAnaliticoResposta->buscaPelaPergunta($registro["id"]);

//print_r($respostas);
?>

<link href="library/select_image/dd.css" rel="stylesheet">

<div class="row">
    <div class="col-xs-12">
        <h1 class="sistem-title">Cadastro de Pergunta (Conflito)</h1>

        <p>Campos com * são de preenchimento obrigatório.</p>

        <form method="post" name="frm" action="index.php?pag=<?= Util::request("pag") ?>&mod=<?= Util::request("mod") ?>&path=<?= Util::request("path") ?>">

            <input type="hidden" name="acao" value="<?= $acao ?>">
            <input type="hidden" name="ispostback" value="1">
            <input type="hidden" name="urlant" value="<?= @$_SESSION["urlant"] ?>">
            <input type="hidden" name="tipo" value="<?= Util::request("tipo") ?>">

            <div class="form-group">
                <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>
                <span class="mostrapk"><?= $registro["id"] ?></span>
                <input type="hidden"  name="id" value="<?= $registro["id"] ?>"  >
            </div>

            <div class="form-group">
                <label for="pergunta">Pergunta<span class="campoObrigatorio"> *</span></label>
                <input class="form-control" name="pergunta" id="pergunta" value="<?= $registro['pergunta'] ?>" >
            </div>

            <?
            if (count($respostas) > 0 && isset($respostas[0])) {
                $resposta1 = $respostas[0];
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Grupo de Resposta 1
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="resposta_1" class="control-label">Resposta 1<span class="campoObrigatorio">*</span></label>
                            <input type="hidden" name="resposta_1_codigo" value="<?= $resposta1['codigo_resposta'] ?>">
                            <textarea class="form-control" name="resposta_1" id="resposta_1"><?= $resposta1['resposta'] ?></textarea>
                        </div>   
                        <div class="form-group">
                            <label for="resposta_1_contexto" class="control-label">Contexto da Resposta 1<span class="campoObrigatorio">*</span></label>
                            <textarea class="form-control" name="resposta_1_contexto" id="resposta_1_contexto"><?= $resposta1['contextualizacao'] ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label for="resposta_1_icone">Icone Resposta 1</label>
                                    <select name="resposta_1_icone" id="resposta_1_icone" class="form-control">
                                        <?
                                        $lista = connAccess::fetchData($oConn, " select id, nome, imagem from icone order by nome ");
                                        for ($i = 0; $i < count($lista); $i++) {
                                            $arr = $lista[$i];
                                            $url = $dir_image_icon . $arr["imagem"];
                                            echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $resposta1["id_icone"]) );
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div><!-- End ROW -->  
                    </div>
                </div>
                <? } ?>

            <?
            if (count($respostas) > 1 && isset($respostas[1])) {
                $resposta2 = $respostas[1];
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Grupo de Resposta 2
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="resposta_2" class="control-label">Resposta 2<span class = "campoObrigatorio">*</span></label>
                            <input type="hidden" name="resposta_2_codigo" value="<?= $resposta2['codigo_resposta'] ?>">
                            <textarea class="form-control" name="resposta_2" id="resposta_2"><?= $resposta2['resposta'] ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="resposta_2_contexto" class="control-label">Contexto da Resposta 2<span class="campoObrigatorio">*</span></label>
                            <textarea class="form-control" name="resposta_2_contexto" id="resposta_2_contexto"><?= $resposta2['contextualizacao'] ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label for="resposta_2_icone">Icone Resposta 2</label>
                                    <select name="resposta_2_icone" id="resposta_2_icone" class="form-control">
                                        <?
                                        $lista = connAccess::fetchData($oConn, " select id, nome, imagem from icone order by nome ");
                                        for ($i = 0; $i < count($lista); $i++) {
                                            $arr = $lista[$i];
                                            $url = $dir_image_icon . $arr["imagem"];
                                            echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $resposta2["id_icone"]) );
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div><!-- End ROW -->   
                    </div>
                </div>
                <? }?>

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

                $("#resposta_1_icone").msDropDown();
                $("#resposta_2_icone").msDropDown();
</script>