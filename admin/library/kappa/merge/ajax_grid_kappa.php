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
require_once ("../../painel/chat/inc_chat.php");
//Página responsável por mostrar o comentário do kappa


$id_usuario_logado = request("id_usuario");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));


$objeto_kappa = request("objeto_kappa");
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
    
    $item["id_usuario_avaliado"] = KappaGrid::tentaLocalizarUsuarioAvaliado($id_ticket, $nome_tabela, $id_registro);

    connAccess::nullBlankColumns($item);

    connAccess::Insert($oConn, $item, "avaliacao_kappa", "id");

    $parametro = request($prefixo."parametro");
    
    if ( $parametro == "bypass"){ //É um comentário com a nota 3 porém ele não quis usar nenhuma ferramenta, quis apenas deixar o comentário.
        //Ele vai receber uma mensagem na caixa de entrada avisando que ele pode fazer usufruto da ferramenta "não entendi" quando quiser.
        
        $id_user_sistema = chat_ticket::getIDUserSistema();
        $mensagem = "Você comentou com nota \"Não sei\" em ".$objeto_kappa. ". Porém você pode utilizar a ferramenta \"Não entendi\" sempre que desejar
             para esta função clicando <a href='painel_controle.php?pag=inc_nao_entendi&cnt=1&comp=nao_entendi&id_ticket=". $item["id_ticket"]."&idr=".
                $id_registro."&tb=".$nome_tabela."&obj=".$objeto_kappa."' target='_top'>aqui</a>";
        
        
        $ids_testa = chat_ticket::getListaIDSUsuarioEmOrdem($id_user_sistema.",". $item["id_usuario"]);
        $id_chat = "";
        
         $sql = " select id from chat_ticket where id_ticket = ". $id_ticket . " and ids_usuarios='". $ids_testa."' ";
         $lista = connAccess::fetchData($oConn, $sql);
        
         if ( count($lista) > 0 ){
               $id_chat = $lista[0]["id"];
         }else{
               $id_chat =   chat_ticket::geraNovoChatTicket($id_ticket, $id_user_sistema.",".$item["id_usuario"]); //Devolve a id do chat para o sacaninha..
         }
     
        $id_mensagem = chat_ticket::novaMensagem($item["id_ticket"], $id_chat, $id_user_sistema, $mensagem);   
        chat_ticket::forcaStatusLidoChatParticipante($id_chat, $id_user_sistema);//Indica quem foi lido.. e deleta o restante. 
    }
    
    echo("<script> if ( parent != null ) {  parent.reload_comentario(); } </script>");
}

if ($id_registro != "" && $id_ticket != "" && $nome_tabela != "" && ( $acao == "grid" || $acao == "barra" || $acao == "responder")) {

    $campoTabela = explode(":", $nome_tabela);

    $base_div = "kappa_principal";
    if ( Util::request("localizador_load") != "" ){
        
           $arp = explode(",", Util::request("localizador_load") );
           $base_div = $arp[5];
    }
    
    
    if (count($campoTabela) > 1) {
        $idKappa = $base_div. "_" . $id_registro . "_" . $campoTabela[1];
    } else {
        $idKappa = $base_div. "_" . $id_registro;
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
    
    if ( $base_div != "" ){
        $oKappa->prefixo_principal = $base_div;
    }
    
    if ( Util::request("modal_nao_sei") != ""){
       $oKappa->modal_nao_sei = Util::request("modal_nao_sei"); 
    }

    if ($oKappa->identificador_div_kappa == "") {
        $oKappa->identificador_div_kappa = "kappa_div_principal_" . $id_registro;
        
        if ( Util::request("localizador_load") != "" ){
        
                    $arp = explode(",", Util::request("localizador_load") );
                    $oKappa->identificador_div_kappa = $arp[1];
        }
        
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