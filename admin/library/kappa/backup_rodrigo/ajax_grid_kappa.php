<?php

header("Content-Type: text/html; charset=UTF-8", true);
require_once("../../ap_padrao.php");
require_once("../../persist/IDbPersist.php");
require_once("../../persist/connAccess.php");
require_once("../../persist/FactoryConn.php");
require_once("../../persist/resumo.php");
require_once("../../persist/Parameters.php");
//require_once("kappa.php");
require_once("kappa_grid.php");
require_once("../../inc_usuario.php");
//Página responsável por mostrar o comentário do kappa


$id_usuario_logado = request("id_usuario");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));


$id_ticket = request("id_ticket");
$id_registro = request("id_registro");
$nome_tabela = request("nome_tabela");
$id_pai = request("id_pai");
$id_componente_template = request("id_componente_template");
$id = $id_ticket;
$prefixo = request("prefixo");
$acao = Util::NVL(request("acao"), "grid");

if ($acao == "salvar_frame") {

    $item = $oConn->describleTable("avaliacao_kappa");

    $item["id_ticket"] = $id_ticket;
    $item["id_registro"] = $id_registro;
    $item["nome_tabela"] = $nome_tabela;
    $item["id_componente_template"] = $id_componente_template;
    $item["id_avaliacao_kappa_pai"] = $id_pai;

    if ($id_pai != "") {
        $item["id_avaliacao_kappa_pai_usuario"] = connAccess::executeScalar($oConn, "select id_usuario from avaliacao_kappa where id = " . $id_pai);

        $nivel = KappaGrid::contaNivel($id_pai);

        if ($nivel >= 1) {
            $item["id_avaliacao_kappa_pai"] = KappaGrid::getIDPai($id_pai);
        }
    }

    $item["nota"] = request($prefixo . "comentario_nota");
    $item["data"] = Util::getCurrentBDdate();
    $item["ressalva"] = Util::acento_para_html(request($prefixo . "ressalva"));
    // $item["id_usuario"] = SessionFacade::getIdLogado();

    if ($item["id_usuario"] == "") {
        $item["id_usuario"] = request("id_usuario");
    }

    connAccess::nullBlankColumns($item);

    connAccess::Insert($oConn, $item, "avaliacao_kappa", "id");

    echo("<script> if ( parent != null ) {  parent.reload_comentario(); } </script>");
}


if ($id_registro != "" && $id_ticket != "" && $nome_tabela != "" && ( $acao == "grid" || $acao == "barra" || $acao == "responder")) {

    $campoTabela = explode(":", $nome_tabela);

    if (count($campoTabela) > 1) {
        $idKappa = "kappa_principal_" . $id_registro . "_" . $campoTabela[1];
    } else {
        $idKappa = "kappa_principal_" . $id_registro;
    }


    $oKappa = new KappaGrid($idKappa);

    $oKappa->id_componente_template = $id_componente_template;
    $oKappa->id_ticket = $id_ticket;
    $oKappa->id_registro = $id_registro;
    $oKappa->nome_tabela = $nome_tabela;
    $oKappa->id_pai = $id_pai;
    $oKappa->href = "a_kappa_" . $id_registro;
    $oKappa->identificador_div_kappa = request("identificador_div_kappa");
    $oKappa->classe_imagem = "kappa_medio";

    if ($oKappa->identificador_div_kappa == "") {

        $oKappa->identificador_div_kappa = "kappa_div_principal_" . $id_registro;
    }

    if ($id_pai != "") {


        $oKappa->idKappa = "kappa_comentario_" . $id_pai;
        $oKappa->href = "a_comentario_kappa_" . $id_pai;
        $oKappa->identificador_div_kappa = "kappa_resposta_comentario_" . $id_pai;
    }
    // $oSubKappa->id_pai = $id_pai;
    //  

    if ($id_pai != "") {
        //   $oKappa->href = "a_kappa_".$id_registro."_".$id_pai;
    }

    $complemento_sql = "";
    //"kappa_".$id_registro
    if ($id_pai == "")
        $complemento_sql .= " and c.id_avaliacao_kappa_pai is null ";

    if ($acao == "grid") {
        $oKappa->mostraTabelaComentario($oConn, "images/", $id_pai, $complemento_sql);
    }
    if ($acao == "barra") {
        $oKappa->mostraBarraComentario($oConn, "images/", $id_pai, $complemento_sql, true, false);
    }
    if ($acao == "responder") {
        $oKappa->mostraResponderComentario(false, array("nota" => "", "ressalva" => ""), $oKappa->idKappa, "", "");
        //($oConn, "images/", $id_pai, $complemento_sql, true, false );
    }
}




$oConn->disconnect();
?>