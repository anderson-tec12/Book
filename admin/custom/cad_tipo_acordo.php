<?php
require_once K_DIR . "custom/inc_tipo_acordo.php";
require_once K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php";

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("custom.tipo_acordo");

$dir_image_icon = url_files . "/icons/";

if ($ispostback) {
    if ($id != "")
        $registro = connAccess::fastOne($oConn, "custom.tipo_acordo", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["descricao"] = Util::request($prefixo . "descricao");
    $registro["id_conteudo_assinado"] = Util::request($prefixo . "conteudo_assinado_id");
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    $registro["id"] = tipo_acordo::salvar($registro);

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";

    $id = $registro["id"];
}

if ($acao == "LOAD" && $id != "") {
    $registro = tipo_acordo::buscaPorId($id);
}

Util::mensagemCadastro(85);
?>

<link href="library/select_image/dd.css" rel="stylesheet">

<div class="row">
    <div class="col-xs-12">
        <h1 class="sistem-title">Cadastro Tipo Acordo</h1>

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
                <label for="descricao">Descrição</label>
                <input class="form-control" name="descricao" id="descricao" readonly value="<?= $registro['descricao'] ?>">
            </div>


            <div class="form-group">
                <?
                $conteudoAssinado = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado']);
                ?>
                <label for="conteudo_assinado">Conteúdos Assinado</label>
                <input type="hidden" class="form-control" name="conteudo_assinado_id" id="conteudo_assinado_id" value="<?= is_null($conteudoAssinado) ? "" : $conteudoAssinado['id'] ?>">
                <input type="text" class="form-control" name="conteudo_assinado_titulo" id="conteudo_assinado_titulo" readonly value="<?= is_null($conteudoAssinado) ? "" : $conteudoAssinado['titulo'] . ' - ' . $conteudoAssinado['nome_completo'] ?>">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado');">Selecionar</button>
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

                $("#resposta_1_icone").msDropDown();
                $("#resposta_2_icone").msDropDown();
</script>

<?
if (file_exists(K_DIR . "custom/pop_pesquisa_conteudo_assinado.php")) {
    include K_DIR . "custom/pop_pesquisa_conteudo_assinado.php";
}