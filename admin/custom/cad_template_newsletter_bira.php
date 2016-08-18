<script src="<?= K_RAIZ ?>/custom/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="<?= K_RAIZ ?>/custom/js/template_newsletter.js" type="text/javascript" ></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="custom/css/normalize.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="custom/fonts/icon-fonts.css" rel="stylesheet">
<link href="custom/fonts/styletype.css" rel="stylesheet">
<link href="custom/css/style.css" rel="stylesheet">
<link href="custom/css/pen.css" rel="stylesheet">  

<style>
    .itens{
        /*float: left;*/
        margin: 5px;
        height: 60px;
        width: auto;
    }
    .imagens{
        display: none;
    }
</style>

<?php
require_once 'inc_template_newsletter.php';
require_once 'inc_tipo_item_newsletter.php';


$id = Util::request("id");
$acao = Util::request("acao");
$ispostback = Util::request("ispostback");

$registro = $oConn->describleTable("custom.template_newsletter");

if ($ispostback) {

    if ($id != "")
        $registro = connAccess::fastOne($oConn, "custom.template_newsletter", " id = " . $id);
    connAccess::preencheArrayForm($registro, $_POST, "id");
    $prefixo = "";
    $registro["id"] = Util::numeroBanco(Util::request($prefixo . "id"));
    $registro["nome"] = Util::request($prefixo . "nome");
    $registro["descricao"] = Util::request($prefixo . "descricao");
    $registro["obs"] = Util::request($prefixo . "obs");
}

if ($acao == "SAVE") {
    connAccess::nullBlankColumns($registro);
    //Salva o Template Newsletter
    if (!@$registro["id"]) {
        $registro["id"] = connAccess::Insert($oConn, $registro, "custom.template_newsletter", "id", true);
    } else {
        connAccess::Update($oConn, $registro, "custom.template_newsletter", "id");
    }

    $quantidadeItemNewsletter = $_POST["qtde_item_newsletter"];
    $sortables = explode(",", $_POST["ordem"]);
    if ($quantidadeItemNewsletter > 0) {

        //Salvando itens template newsletter
        for ($i = 0; $i < count($sortables); $i++) {
            $sortable = $sortables[$i];
            $ordem = str_replace("sortable_", "", $sortable);
            $statusItem = $_POST["status_item_newsletter" . $ordem];
            if ($statusItem == "normal") {
                //echo($ordem);
                $tipo_sortable = $_POST["tipo_sortable_" . $ordem];
                $tipo = connAccess::fastOne($oConn, "custom.tipo_item_newsletter", "codigo = '" . $tipo_sortable . "'");
                $item_newslatter = array();
                $item_newslatter["id"] = null;
                $item_newslatter["id"] = $_POST["id_item_newsletter" . $ordem];
                $item_newslatter["ordem"] = $i;
                $item_newslatter["id_template_newsletter"] = $registro["id"];
                $item_newslatter["id_tipo_item_newsletter"] = $tipo['id'];

                $valorItem = "";

                //Formando os valores para o item
                for ($j = 0; $j < $quantidadeItemNewsletter; $j++) {

                    $sortable_item = $_POST["sortable_item_" . $j];

                    if ($sortable_item == $sortable) {
                        if (isset($_POST["item_" . $j])) {
                            $valorItem = $valorItem . $_POST["item_" . $j] . "!#";
                        }
                    }
                }

                $item_newslatter["valor"] = $valorItem;

                if (!@$item_newslatter["id"]) {
                    $item_newslatter["id"] = connAccess::Insert($oConn, $item_newslatter, "custom.item_template_newsletter", "id", true);
                } else {
                    connAccess::Update($oConn, $item_newslatter, "custom.item_template_newsletter", "id");
                }
            } else {
                if ($_POST["id_item_newsletter" . $ordem] != null && $_POST["id_item_newsletter" . $ordem] != "") {
                    $sql = "DELETE FROM custom.item_template_newsletter WHERE id =" . $_POST["id_item_newsletter" . $ordem];
                    connAccess::executeCommand($oConn, $sql);
                }
            }
        }
    }

    $_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
    $ispostback = "";

    $acao = "LOAD";
    $id = $registro["id"];
}

if ($acao == "DEL" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.template_newsletter", " id = " . $id);
    connAccess::Delete($oConn, $registro, "custom.template_newsletter", "id");
    $_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
    $id = "";
    $registro = $oConn->describleTable("custom.template_newsletter");
    $ispostback = "";
}

if ($acao == "LOAD" && $id != "") {
    $registro = connAccess::fastOne($oConn, "custom.template_newsletter", " id = " . $id);
}
?>
<?
Util::mensagemCadastro(85);
?>

<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
    <div class="fieldBox">

        <input type="hidden" name="qtde_item_newsletter" value="">
        <input type="hidden" name="qtde_sortable" value="">
        <input type="hidden" name="ordem" id="ordem" value="">

        <input type="hidden" name="acao" value="<?php echo $acao ?>">
        <input type="hidden" name="ispostback" value="1">
        <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"] ?>">
        <input type="hidden" name="tipo" value="<?php
        try {
            echo Util::request("tipo");
        } catch (Exception $exp) {
            
        }
        ?>">

        <div class="row">
            <div class="col-xs-12">
                <h1 class="sistem-title">template newsletter</h1>
                <p>Campos com * são de preenchimento obrigatório.</p>
                <div class="panel panel-default">
                    <div class="panel-heading">Itens do Layout</div>
                    <div class="panel-body" >
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

                        if ($eh_primarykey && $registro["nome"] == "") {
                            $visible_in_html = " style='display:none' ";
                        }
                        ?>
                        <div <? echo ($visible_in_html); ?> id="tr_nome" >
                            <div class="form-group">
                                <label for="nome">Nome<span class="campoObrigatorio" > *</span></label>

                                <input type="text"  name="nome" value="<?= $registro["nome"] ?>"  class="form-control" maxlength="">

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

                                <input type="text"  name="descricao" value="<?= $registro["descricao"] ?>"  class="form-control" maxlength="">

                            </div>
                        </div>


                        <?
                        $eh_primarykey = False;
                        $visible_in_html = '';

                        if ($eh_primarykey && $registro["obs"] == "") {
                            $visible_in_html = " style='display:none' ";
                        }
                        ?>
                        <div <? echo ($visible_in_html); ?> id="tr_obs" >
                            <div class="form-group">
                                <label for="obs">Observação<span class="campoObrigatorio"  style="display:none" > *</span></label>

                                <textarea id="obs" name="obs" class="form-control"
                                          ><?= $registro["obs"] ?></textarea>

                            </div>
                        </div>
                    </div><!-- End Panel Body -->
                </div><!-- End Panel -->

                <div class="row">
                    <div class="col-xs-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">Itens do Layout</div>
                            <div class="panel-body" >
                                <p>Clique nos botoes abaixo para inserir os elementos.</p>

                                <?
                                $sql = "";

                                $itens = tipo_item_newsletter::findAllTipoItem();
                                //print_r($itens);

                                for ($i = 0; $i < count($itens); $i++) {
                                    $item = $itens[$i];
                                    ?>
                                    <input type="hidden" id="icone_<?= $item['codigo'] ?>" value="<?= $item['imagem'] ?>">
                                    <img src="../files/templates/newsletter/<?= $item['imagem'] ?>">
                                    <input type="button" class="btn btn-default btn-block" value="<?= $item['nome'] ?>" onclick="adicionarItem('<?= $item['codigo'] ?>', '<?= $item['nome'] ?>')">
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div><!-- End Col 3 -->

                    <div class="col-xs-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">Layout</div>
                            <div class="panel-body">
                                <p>Arraste os elementos para cima ou para baixo para definr a ordem.</p>
                                <div id="sortable" >

                                </div>

                                <?
                                if (@$registro["id"]) {
                                    //Carrega os itens ao carregar a pagina pela primeira vez
                                    $itens_template = connAccess::fetchData($oConn, "Select item.*,tipo.codigo from custom.item_template_newsletter item left join custom.tipo_item_newsletter tipo on tipo.id = item.id_tipo_item_newsletter where item.id_template_newsletter =" . $id . " order by item.ordem");

                                    for ($i = 0; $i < count($itens_template); $i++) {


                                        $item_template = $itens_template[$i];

                                        $valor = addcslashes($item_template["valor"], "\\\'\"\n\r");

                                        //echo($valor."<br/>");
                                        ?>
                                        <script type = "text/javascript">
                                            adicionarItem("<?= $item_template["codigo"] ?>", "<?= str_replace("\n", "", $valor); ?>",<?= $item_template["id"] ?>);
                                        </script>
                                        <?
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div><!-- End Col 9 -->
                </div><!-- row -->
            </div><!-- fieldBox -->

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
            <!-- Botão teste chamar modal 
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_imagens">
                Launch demo modal
            </button>-->

            <!-- Modal bootstrap-->
            <div class="modal fade" id="modal_imagens" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Selecione a Imagem</h4>
                        </div>

                        <div class="modal-body">
                            <?
                            $sql = "Select * from public.imagem";
                            $lista = connAccess::fetchData($oConn, $sql);

                            $i = 0;

                            while ($i < count($lista)) {
                                $image = $lista[$i];
                                ?><img id="<?= $image['nome'] ?>"  src="../files/images/<?= $image['imagem'] ?>" class="img-thumbnail itens" data-dismiss="modal" onclick="updateButtonImage(id);"/><?
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <script>

                function salvar()
                {
                    var f = document.forms[0];

                    if (isVazio(f.nome, 'Informe Nome!')) {
                        return false;
                    }

                    f.acao.value = "<?php echo ( Util::$SAVE) ?>";

                    f.qtde_item_newsletter.value = this.countItemNewsletter;
                    f.qtde_sortable.value = this.countItemSortable;

                    var itens = $('#sortable').sortable('toArray');
                    f.ordem.value = itens;

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