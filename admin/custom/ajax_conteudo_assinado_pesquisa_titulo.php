<?php

require_once("../library/Util.php");
require_once("../library/interfaces/interface_component.php");
require_once("../config.php");
require_once("../inc_usuario.php");
require_once("../painel/inc_usuario_load.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");

if (file_exists(K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php")) {
    require_once K_DIR . "painel/modulos/conteudos_assinados/conteudo_assinado.php";
}

if (file_exists(K_DIR . "custom/tabela_selecao_conteudo_assinado.php")) {
    require_once K_DIR . "custom/tabela_selecao_conteudo_assinado.php";
}

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$titulo = $_REQUEST["titulo"];

$itens = conteudo_assinado::buscaConteudoAssinadoPorTitulo($titulo, 15);

$componenteTabela = new TabelaSelecaoConteudoAssinado($itens);
$componenteTabela->printHTML();
