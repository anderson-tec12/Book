<?php
require_once 'inc_regra_punicao_recompensa.php';
require_once 'inc_ferramenta.php';
require_once 'painel/ferramentas/decisoes_coletivas/tabela_punicao_recompensa.php';

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("regra_punicao_recompensa");
$ferramentaSelecionadas = array();

$dir_image_icon = url_files . "/icons/";

if ($ispostback) {

    if ($id != "")
        $registro = connAccess::fastOne($oConn, "regra_punicao_recompensa", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["titulo"] = Util::request($prefixo . "titulo");
    $registro["mensagem"] = Util::request($prefixo . "mensagem");
    $registro["custo_realizar_recompensa"] = Util::request($prefixo . "custo_recompensar");
    $registro["custo_realizar_punicao"] = Util::request($prefixo . "custo_punir");
    $registro["perda_receber_punicao"] = Util::request($prefixo . "perda_ser_punido");
    $registro["ganho_receber_recompensa"] = Util::request($prefixo . "ganho_ser_recompensado");
}

if ($acao == "SAVE") {

    connAccess::nullBlankColumns($registro);

    $registro["id"] = inc_regra_punicao_recompensa::salvar($registro);

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "DEL" && $id != "") {

    $registro = connAccess::fastOne($oConn, "regra_punicao_recompensa", " id = " . $id);
    connAccess::Delete($oConn, $registro, "regra_punicao_recompensa", "id");

    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";

    $id = "";
    $registro = $oConn->describleTable("regra_punicao_recompensa");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "regra_punicao_recompensa", " id = " . $id);
}
?>

<div class="col-xs-12">
    <br/>
    <?
    Util::mensagemCadastro(85);
    ?>
</div>

<link href="library/select_image/dd.css" rel="stylesheet"/>
<link rel="stylesheet" href="painel/css/decisoes_coletivas.min.css" type="text/css" media="all" />

<form method="post" name="frm" action="index.php?pag=<?= Util::request("pag") ?>&mod=<?= Util::request("mod") ?>&path=<?= Util::request("path") ?>">

    <div class="col-xs-12">
        <h1 class="sistem-title">Cadastro de Regra de Punição e Recompensa</h1>
        <p>Campos com * são de preenchimento obrigatório.</p>
        <br/>
    </div>

    <input type="hidden" name="acao" value="<?php echo $acao ?>">
    <input type="hidden" name="ispostback" value="1">
    <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"] ?>">
    <input type="hidden" name="tipo" value="<?= is_null(Util::request("tipo")) ? "" : Util::request("tipo") ?>">

    <div class="col-xs-12">
        <div class="form-group" <?= empty($registro["id"]) ? "style = 'display: none'" : "" ?>>
            <label for="id">ID </label>
            <span class="mostrapk"><?= $registro["id"] ?></span>
            <input type="hidden"  name="id" value="<?= $registro["id"] ?>"  >
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group">
            <label for="id">Custo por Punir <br/>Má Conduta<span class="campoObrigatorio"> *</span></label>
            <select id="select_custo_punir" name="custo_punir" class="form-control" onchange="atualizarSimulador()">
                <option value="0" <?= $registro["custo_realizar_punicao"] == 0 ? "selected" : "" ?>>0</option>
                <option value="5"<?= $registro["custo_realizar_punicao"] == 5 ? "selected" : "" ?>>-5</option>
                <option value="10"<?= $registro["custo_realizar_punicao"] == 10 ? "selected" : "" ?>>-10</option>
                <option value="15"<?= $registro["custo_realizar_punicao"] == 15 ? "selected" : "" ?>>-15</option>
                <option value="20"<?= $registro["custo_realizar_punicao"] == 20 ? "selected" : "" ?>>-20</option>
            </select>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group">
            <label for="id">Custo por Recompensar Competência<span class="campoObrigatorio"> *</span></label>
            <select id="select_custo_recompensar" name="custo_recompensar" class="form-control" onchange="atualizarSimulador()">
                <option value="0"<?= $registro["custo_realizar_recompensa"] == 0 ? "selected" : "" ?>>0</option>
                <option value="5"<?= $registro["custo_realizar_recompensa"] == 5 ? "selected" : "" ?>>-5</option>
                <option value="10"<?= $registro["custo_realizar_recompensa"] == 10 ? "selected" : "" ?>>-10</option>
                <option value="15"<?= $registro["custo_realizar_recompensa"] == 15 ? "selected" : "" ?>>-15</option>
                <option value="20"<?= $registro["custo_realizar_recompensa"] == 20 ? "selected" : "" ?>>-20</option>
            </select>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group">
            <label for="id">Perda por ser <br/>Punido<span class="campoObrigatorio"> *</span></label>
            <select id="select_perda_ser_punido" name="perda_ser_punido" class="form-control" onchange="atualizarSimulador()">
                <option value="0"<?= $registro["perda_receber_punicao"] == 0 ? "selected" : "" ?>>0</option>
                <option value="5"<?= $registro["perda_receber_punicao"] == 5 ? "selected" : "" ?>>-5</option>
                <option value="10"<?= $registro["perda_receber_punicao"] == 10 ? "selected" : "" ?>>-10</option>
                <option value="15"<?= $registro["perda_receber_punicao"] == 15 ? "selected" : "" ?>>-15</option>
                <option value="20"<?= $registro["perda_receber_punicao"] == 20 ? "selected" : "" ?>>-20</option>
            </select>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group">
            <label for="id">Ganho por ser <br/>Recompensado<span class="campoObrigatorio"> *</span></label>
            <select id="select_ganho_ser_recompensado" name="ganho_ser_recompensado" class="form-control" onchange="atualizarSimulador()">
                <option value="0"<?= $registro["ganho_receber_recompensa"] == 0 ? "selected" : "" ?>>0</option>
                <option value="5"<?= $registro["ganho_receber_recompensa"] == 5 ? "selected" : "" ?>>5</option>
                <option value="10"<?= $registro["ganho_receber_recompensa"] == 10 ? "selected" : "" ?>>10</option>
                <option value="15"<?= $registro["ganho_receber_recompensa"] == 15 ? "selected" : "" ?>>15</option>
                <option value="20"<?= $registro["ganho_receber_recompensa"] == 20 ? "selected" : "" ?>>20</option>
            </select>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <div id="div_simulador" class="comp_decisoes_coletivas">
                <?
                $simulador = new TabelaPunicaoRecompensa(100, 0, 0, 0, 0);
                $simulador->printHTML();
                ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div id="tr_titulo" >
            <div class="form-group">
                <label for="titulo">Título<span class="campoObrigatorio" > *</span></label>
                <input type="text"  name="titulo" value="<?= $registro["titulo"] ?>"  class="form-control" maxlength="300">
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <label for="mensagem">Mensagem<span class="campoObrigatorio" > *</span></label>
            <textarea name="mensagem" rows="3" class="form-control"><?= $registro["mensagem"] ?></textarea>
        </div>
    </div>

    <div class="col-xs-12">
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
    </div>

</form>

<div class="col-xs-12">
    <div class="interMenu">
        <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo") . "&path=" . Util::request("path")) ?>
    </div>
</div>

<script type="text/javascript">

    window.onload = function () {
        atualizarSimulador();
    }

    var raiz_sistema = "";

    function salvar() {
        var f = document.forms[0];

        if (isVazio(f.titulo, 'Informe Título!')) {
            return false;
        }

        if (isVazio(f.mensagem, 'Informe a Mensagem!')) {
            return false;
        }

        f.acao.value = "<?= ( Util::$SAVE) ?>";
        f.submit();
    }

    function excluir() {

        var f = document.forms[0];


        if (f.id.value == "")
        {
            alert("Selecione um registro para excluir!");
            return;
        }

        f.acao.value = "<?php echo Util::$DEL ?>";
        f.submit();
    }

    function novo() {

        var f = document.forms[0];
        document.location = f.action;

    }

    function atualizarSimulador() {

        var divSimulador = document.getElementById("div_simulador");

        var crp = document.getElementById("select_custo_punir").value;
        var crr = document.getElementById("select_custo_recompensar").value;
        var prp = document.getElementById("select_perda_ser_punido").value;
        var grr = document.getElementById("select_ganho_ser_recompensado").value;

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                divSimulador.innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", raiz_sistema + "painel/ferramentas/decisoes_coletivas/ajax_atualiza_simulacao_pelos_valores.php?crp=" + crp + "&crr=" + crr + "&prp=" + prp + "&grr=" + grr, true);
        xmlhttp.send();

    }
</script>