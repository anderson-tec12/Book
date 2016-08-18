<?php
$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("custom.termo_legal");

if ($ispostback) {
    if ($id != "")
        $registro = connAccess::fastOne($oConn, "custom.termo_legal", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["titulo"] = Util::request($prefixo . "titulo");
    $registro["descricao"] = Util::request($prefixo . "descricao");
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    if (!@$registro["id"]) {
        $registro["id"] = connAccess::Insert($oConn, $registro, "custom.termo_legal", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.termo_legal", "id");
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";
    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.termo_legal", " id = " . $id);
}

Util::mensagemCadastro(85);
?>

<link href="library/select_image/dd.css" rel="stylesheet">

<div class="row">
    <div class="col-xs-12">
        <h1 class="sistem-title">Cadastro de Termo Legal</h1>

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
                <label for="titulo">Título<span class="campoObrigatorio"> *</span></label>
                <input class="form-control" name="titulo" id="titulo" maxlength="100" value="<?= $registro['titulo'] ?>">
            </div>


            <div class="form-group">
                <label for="descricao">Descrição<span class="campoObrigatorio"> *</span></label>
                <textarea class="form-control" style="height: 400px" name="descricao" id="pergunta"><?= $registro['descricao'] ?></textarea>
            </div>

            <?php
            showButtons($acao, true);
            $enBtGrupo = " disabled ";
            try {
                $id = $registro["id"];
                if ($id > 0)
                    $enBtGrupo = "";
            } catch (Exception $exp) {
                
            }
            ?>

        </form>
        <div class="interMenu">
            <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&field_order=ordem") ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function salvar()
    {
        var f = document.forms[0];

        if (isVazio(f.titulo, 'Informe o Título!')) {
            return false;
        }

        if (isVazio(f.descricao, 'Informe a Descrição!')) {
            return false;
        }

        f.acao.value = "<?php echo ( Util::$SAVE) ?>";
        f.submit();
    }


    function novo()
    {
        var f = document.forms[0];
        document.location = f.action;

    }

    function excluir()
    {
        var f = document.forms[0];

        if (f.id.value == "")
        {
            alert("Selecione um registro para excluir!");
            return;
        }

        f.acao.value = "<?php echo Util::$DEL ?>";
        f.submit();
    }
</script>