<?php
require_once ("inc_template_texto.php");
require_once ("inc_ferramenta.php");
require_once ("inc_componente_template.php");

$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");
$registro = $oConn->describleTable("custom.template_texto");

if ($ispostback) {

    if ($id != "")
        $registro = connAccess::fastOne($oConn, "custom.template_texto", " id = " . $id);

    connAccess::preencheArrayForm($registro, $_POST, "id");

    $prefixo = "";

    $registro["id"] = Util::request($prefixo . "id");
    $registro["texto"] = Util::request($prefixo . "texto");
    $registro["id_componente_template"] = Util::request($prefixo . "componente_template");
}

if ($acao == "SAVE") {
    connAccess::nullBlankColumns($registro);

    if (!@$registro["id"]) {

        $registro["id"] = connAccess::Insert($oConn, $registro, "custom.template_texto", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.template_texto", "id");
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "DEL" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.template_texto", " id = " . $id);
    connAccess::Delete($oConn, $registro, "custom.template_texto", "id");
    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
    $id = "";
    $registro = $oConn->describleTable("custom.template_texto");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.template_texto", " id = " . $id);
}
?>



<div class="row">
    <div class="col-xs-12">

        <? Util::mensagemCadastro(85); ?>

        <h1 class="sistem-title">Cadastro de Templates de Texto</h1>

        <p>Preencha os campos abaixo para realizar o cadastro. Campos com * são de preenchimento obrigatório.</p>
        <form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
            <div class="row">
                <div class="fieldBox col-xs-12">

                    <input type="hidden" name="acao" value="<?php echo $acao ?>">
                    <input type="hidden" name="ispostback" value="1">


                    <div class="form-group" <? if ($registro['id'] == "") { ?> style='display:none' <? } ?> >
                        <label for="id">ID</label> :
                        <input type="hidden" name="id" value="<?= $registro['id'] ?>">
                        <span class='mostrapk'><?= $registro['id'] ?></span>
                    </div>

                    <div class="form-group">

                        <label for="tipo">Local<span class="campoObrigatorio" > * </span></label>

                        <select class="form-control" name="componente_template"> 
                            <?
                            $ferramentaPreposicoesAgressivas = inc_ferramenta::findFerramentaByCodigo("proposicoes_agressivas");
                            $ferramentaPreposicoesConciliadoras = inc_ferramenta::findFerramentaByCodigo("proposicoes_conciliadoras");

                            $ferramentas = array();
                            array_push($ferramentas, $ferramentaPreposicoesAgressivas);
                            array_push($ferramentas, $ferramentaPreposicoesConciliadoras);
                            #$ferramentas = inc_ferramenta::findAllFerramenta();

                            foreach ($ferramentas as $ferramenta):
                                ?>
                                <optgroup label="<?= $ferramenta['titulo'] ?>">
                                    <?
                                    $itens = componente_template::getComponenteTemplateByFerramenta($ferramenta['id']);
                                    foreach ($itens as $item):

                                        $selected = "";

                                        if ($registro['id_componente_template'] == $item['id']) {
                                            $selected = " selected ";
                                        }
                                        ?>
                                        <option <?= $selected ?> value="<?= $item['id'] ?>"><?= $item['nome'] ?></option>
                                        <?
                                    endforeach;
                                    ?>
                                </optgroup>
                                <?
                            endforeach;
                            ?>
                        </select> 
                    </div>

                    <?
                    $eh_primarykey = False;
                    $visible_in_html = "";

                    if ($eh_primarykey && $registro["texto"] == "") {
                        $visible_in_html = " style='display:none' ";
                    }
                    ?>        
                    <div <? echo ($visible_in_html); ?> id="tr_texto" >
                        <div class="form-group">
                            <label for="texto">Texto<span class="campoObrigatorio" > * </span></label>
                            <textarea maxlength="140" id="texto" rows="3" name="texto" class="form-control"><?= $registro["texto"] ?></textarea>
                        </div>    
                    </div>
                </div>
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
            <?php botaoVoltar("index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo")) ?>
        </div>

        <script>
            function salvar()
            {
                var f = document.forms[0];

                if (isVazio(f.texto, 'Informe Texto!')) {
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