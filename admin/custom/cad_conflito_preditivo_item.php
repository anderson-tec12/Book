<?php
if (file_exists(K_DIR . "painel/ferramentas/conflito/bd/conflito_preditivo_item.php")) {
    require_once K_DIR . "painel/ferramentas/conflito/bd/conflito_preditivo_item.php";
}

if (file_exists(K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php")) {
    require_once K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php";
}

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("conflito_preditivo_item");

$bdConflitoPreditivoItem = new ConflitoPreditivoItem($oConn);
$grupos = $bdConflitoPreditivoItem->getGrupos();

$dir_image_icon = url_files . "/icons/";

if ($ispostback) {
    if ($id != "")
        $registro = connAccess::fastOne($oConn, "conflito_preditivo_item", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["nome"] = Util::request($prefixo . "nome");
    $registro["texto"] = Util::request($prefixo . "texto");
    $registro["grupo"] = Util::request($prefixo . "grupo");
    $registro["id_icone"] = Util::numeroBanco(Util::request($prefixo . "icone"));
    $registro["id_conteudo_assinado_1"] = Util::request($prefixo . "conteudo_assinado_1_id");
    $registro["id_conteudo_assinado_2"] = Util::request($prefixo . "conteudo_assinado_2_id");
    $registro["ferramentas_relacionadas"] = Util::request($prefixo . "ferramentas_relacionadas");
}

if ($acao == "SAVE") {
    connAccess::nullBlankColumns($registro);
    $registro["id"] = $bdConflitoPreditivoItem->salvar($registro);
    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";
    $acao = "LOAD";
    $id = $registro["id"];
}


if ($acao == "DEL" && $id != "") {
    $registro = connAccess::fastOne($oConn, "conflito_preditivo_item", " id = " . $id);
    connAccess::Delete($oConn, $registro, "conflito_preditivo_item", "id");
    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
    $id = "";
    $registro = $oConn->describleTable("conflito_preditivo_item");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "conflito_preditivo_item", " id = " . $id);
}

Util::mensagemCadastro(85);
?>

<link href="library/select_image/dd.css" rel="stylesheet">

<div class="row">
    <div class="col-xs-12">
        <h1 class="sistem-title">Cadastro de Item Preditivo</h1>

        <p>Campos com * são de preenchimento obrigatório.</p>

        <form method="post" name="frm" action="index.php?pag=<?= Util::request("pag") ?>&mod=<?= Util::request("mod") ?>&path=<?= Util::request("path") ?>">

            <input type="hidden" name="acao" value="<?= $acao ?>">
            <input type="hidden" name="ispostback" value="1">
            <input type="hidden" name="urlant" value="<?= @$_SESSION["urlant"] ?>">
            <input type="hidden" name="tipo" value="<?= Util::request("tipo") ?>">

            <?
            if (!empty($registro["id"])) {
                ?>
                <div class="form-group">
                    <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>
                    <span class="mostrapk"><?= $registro["id"] ?></span>
                    <input type="hidden"  name="id" value="<?= $registro["id"] ?>"  >
                </div>
                <?
            }
            ?>

            <div class="form-group">
                <label for="pergunta">Nome<span class="campoObrigatorio"> *</span></label>
                <input type="text" class="form-control" name="nome" id="nome" value="<?= $registro['nome'] ?>">
            </div>

            <div class="form-group">
                <label for="pergunta">Texto</label>
                <textarea class="form-control" name="texto" id="texto" style="height: 400px"><?= $registro['texto'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="grupo">Grupo</span></label>
                <select name="grupo" id="grupo" class="form-control">
                    <?
                    foreach ($grupos as $key => $grupo):
                        $selected = "";
                        if ($registro['grupo'] == $key) {
                            $selected = "selected";
                        }
                        ?>
                        <option <?= $selected ?> value="<?= $key ?>"><?= $grupo ?></option>
                        <?
                    endforeach;
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="icone">Icone</span></label>
                <select name="icone" id="icone" class="form-control">
                    <?
                    $lista = connAccess::fetchData($oConn, " select id, nome, imagem from icone order by nome ");
                    for ($i = 0; $i < count($lista); $i++) {
                        $arr = $lista[$i];
                        $url = $dir_image_icon . $arr["imagem"];
                        echo ( Util::populaComboTitulo($arr["id"], $arr["nome"], $url, $registro["id_icone"]) );
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <?
                $conteudoAssinado1 = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado_1']);
                ?>
                <label for="conteudo_assinado_1">Conteúdos Assinado 1</label>
                <input type="hidden" class="form-control" name="conteudo_assinado_1_id" id="conteudo_assinado_1_id" value="<?= is_null($conteudoAssinado1) ? "" : $conteudoAssinado1['id'] ?>">
                <input type="text" class="form-control" name="conteudo_assinado_1_titulo" id="conteudo_assinado_1_titulo" readonly value="<?= is_null($conteudoAssinado1) ? "" : $conteudoAssinado1['titulo'] . ' - ' . $conteudoAssinado1['nome_completo'] ?>">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado_1');">Selecionar</button>
            </div>

            <div class="form-group">
                <?
                $conteudoAssinado2 = conteudo_assinado::buscaPorId($registro['id_conteudo_assinado_2']);
                ?>
                <label for="conteudo_assinado_1">Conteúdos Assinado 2</label>
                <input type="hidden" class="form-control" name="conteudo_assinado_2_id" id="conteudo_assinado_2_id" value="<?= is_null($conteudoAssinado2) ? "" : $conteudoAssinado2['id'] ?>">
                <input type="text" class="form-control" name="conteudo_assinado_2_titulo" id="conteudo_assinado_2_titulo" readonly value="<?= is_null($conteudoAssinado2) ? "" : $conteudoAssinado2['titulo'] . " - " . $conteudoAssinado1['nome_completo'] ?>">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_buscar_conteudo" onclick="setPrefixoCampoSelecionado('conteudo_assinado_2');">Selecionar</button>
            </div>


            <br/>
            <br/>

            <?
            if (file_exists(K_DIR . "custom/inc_ferramentas_relacionadas.php")) {
                include K_DIR . "custom/inc_ferramentas_relacionadas.php";
            }
            ?>

            <div class="form-group">
                <?php
                showButtons($acao, true);
                ?>
            </div>

            <!--<input type="button" class="botao btn btn-success" onclick="salvar()" value="Salvar">-->

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

                        if (isVazio(f.nome, 'Informe Nome!')) {
                            return false;
                        }
                        f.acao.value = "<?= ( Util::$SAVE) ?>";
                        f.submit();
                    }

                    function excluir() {

                        var f = document.forms[0];

                        if (f.id.value == "")
                        {
                            alerta("", "Selecione um registro para excluir!");
                            return;
                        }

                        f.acao.value = "<?php echo Util::$DEL ?>";
                        f.submit();
                    }

                    function novo() {
                        var f = document.forms[0];
                        document.location = f.action;

                    }


                    $("#icone").msDropDown();
</script>

<?
if (file_exists(K_DIR . "custom/pop_pesquisa_conteudo_assinado.php")) {
    include K_DIR . "custom/pop_pesquisa_conteudo_assinado.php";
}
