<?
require_once("ap_padrao.php");
require_once("library/SessionFacade.php");
require_once("persist/IDbPersist.php");
require_once("persist/connAccess.php");
require_once("persist/FactoryConn.php");
require_once("persist/associacoes.php");
require_once("persist/resumo.php");


$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$pag = Util::request("pag");
$mod = Util::request("mod");

$id = Util::request("id");

$prefixo = "";

if ($id != "" && $pag != "") {

    if ($pag == "item_componente") {
        $prefixo = "custom.";
    }
    
    if($pag == "template_newsletter"){
        $prefixo = "custom.";
        //Apaga os itens de newsletter
        connAccess::executeCommand($oConn, "delete from " . $prefixo . "item_template_newsletter where id_template_newsletter = " . $id);
    }

    if ($pag == "componente_template") {
        $prefixo = "custom.";
        connAccess::executeCommand($oConn, "delete from " . $prefixo . "componente_template_item where id_componente_template = " . $id);
    }

    connAccess::executeCommand($oConn, "delete from " . $prefixo . $pag . " where id = " . $id);
}

$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";



$raiz = ""; // $_SESSION["esteModulo"];
?>
<?php botaoVoltar(K_RAIZ . $raiz . "/index.php?mod=listar&pag=" . Util::request("pag") . "&tipo=" . Util::request("tipo")) ?>
<script type="text/javascript">
    voltar();

</script>