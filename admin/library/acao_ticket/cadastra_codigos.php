<?php

require_once("../../config.php"); 
require_once("../Util.php");
require_once("../../persist/IDbPersist.php");
require_once("../../persist/connAccess.php");
require_once("../../persist/FactoryConn.php");
require_once("../../persist/resumo.php");
require_once("../../persist/Parameters.php");



$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

require_once 'acao_ticket.php';

//Objetivo desta tela: Cadastrar os primeiros códigos de componentes e ações. os métodos do log já cadastrão automaticamente; mas, apenas como uma referência, os primeiros componentes e ações
//que sabemos que irão exitir, poderão ser cadastrados aqui.

echo("<br> Ação de Abrir Ticket - ID: ".  acao_ticket::getIDAcao("Cadastrar Ticket")  );
echo("<br> Ação de Concluir o Ticket - ID: ".  acao_ticket::getIDAcao("Concluir Ticket")  );
echo("<br> Ação de Enviar o Convite do Ticket - ID: ".  acao_ticket::getIDAcao("Cadastrar Convite")  );
echo("<br> Ação de Enviar o Convite do Ticket - ID: ".  acao_ticket::getIDAcao("Enviar Convite")  );
echo("<br> Ação de Aceitar o Convite do Ticket - ID: ".  acao_ticket::getIDAcao("Aceitar Convite")  );
echo("<br> Ação de Negar o Convite do Ticket - ID: ".  acao_ticket::getIDAcao("Negar Convite")  );
echo("<br> Ação de Usar o Botão Kappa - ID: ".  acao_ticket::getIDAcao("Kappa")  );
echo("<br> Ação de Pesquisar com o componente de Template ABCD - ID: ".  acao_ticket::getIDAcao("Template ABCD")  );
echo("<br> Ação de Usar o componente de Falácias - ID: ".  acao_ticket::getIDAcao("Falacia")  );
echo("<br> Ação de Usar o componente de Comentário - ID: ".  acao_ticket::getIDAcao("Comentário")  );

echo("<h2>Componentes padrão salvo</h2>");


echo("<br> Componente Relativo ao Ticket - Dados Gerais: ".  acao_ticket::getIDComponente("Ticket","ticket")  );
echo("<br> Componente Relativo ao Convite: ".  acao_ticket::getIDComponente("Convite","convite")  );
echo("<br> Componente Relativo ao Kappa: ".  acao_ticket::getIDComponente("Kappa","kappa")  );
echo("<br> Componente Relativo ao Template ABDC: ".  acao_ticket::getIDComponente("Template ABCD","template_abcd")  );
echo("<br> Componente Relativo ao Falácias: ".  acao_ticket::getIDComponente("Falácias","falacias")  );
echo("<br> Componente Relativo ao Falácias: ".  acao_ticket::getIDComponente("Comentário","comentario")  );


/* Exemplos de como salvar o log - títulos amigáveis 
 * 
 * 
Ex: "fulano" analisou um trecho com o componente Detector de Falácias
Ex: "ciclano" adicionou o componente KAPPA ao componente Detector de Falácias
Ex: "beltrano" avaliou a Detecção de Falácias: KAPPA = 4 (discordo com ressalvas)
Ex: "fulano" comentou o KAPPA da Detecção de Falácias
Ex: "beltrano" comentou o KAPPA da Detecção de Falácias
Ex: "ciclano" comentou o KAPPA da Detecção de Falácias
Ex: "beltrano" adicionou o componente "Análise de Causa" ao Detector de Falácias
Ex: "beltrano" analisou o trecho com o componente "Análise de Causa"
Ex: "ciclano" avaliou a Análise de Causa: KAPPA = 1 (concordo)
Ex: "fulano" avaliou a Análise de Causa: KAPPA = 2 (concordo com ressalvas)
Ex: "ciclano" comentou a Análise de Causa
 */

$oConn->disconnect();