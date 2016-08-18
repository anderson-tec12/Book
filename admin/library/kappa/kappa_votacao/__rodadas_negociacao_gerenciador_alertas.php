<?php

require_once K_DIR . "inc_ticket_participante.php";
require_once K_DIR . "library/kappa/kappa_votacao/bd_avaliacao_kappa.php";
require_once K_DIR . "painel/chat/inc_chat.php";
require_once K_DIR . "painel/ferramentas/decisoes_coletivas/bd/ticket_configuracao_item.php";
require_once K_DIR . "painel/modulos/rodadas_negociacao/bd/negociacao_proposta.php";
require_once K_DIR . "painel/newsletter/enviador_newsletter.php";

/**
 * @author Rodrigo Augusto Benedicto
 */
class KappaVotacaoDisparadorAlertasRodadas implements IDisparadorAlertaKappaVotacao {

    private $bdTicketconfiguracaoItem = null;
    private $conexao = null;

    public function __construct() {
        $this->conexao = FactoryConn::getConn(constant("K_CONN_TYPE"));
        $this->bdTicketconfiguracaoItem = new TicketConfiguracaoItem($this->conexao);
    }

    /*
     * Função criada para disparar mensagens após a avaliação através do kappa de votação
     */

    public function enviaAlertaAoSalvarKappaVotacao(AvaliacaoKappa $avaliacaoKappa) {

        $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
        $bdNegociacaoProposta = new NegociacaoProposta($this->conexao);

        $itemNegociacao = $bdAvaliacaoKappa->buscaRegistroAvaliado($avaliacaoKappa->getIdRegistro(), $avaliacaoKappa->getNomeTabela());

        $proposta = $bdNegociacaoProposta->buscaPorId($itemNegociacao['id_proposta']);

        #Notificação ao autor da proposta
        $this->notificaAutorPropostaAvaliada($avaliacaoKappa->getIdTicket(), $proposta, $avaliacaoKappa->getIdUsuario());

        #Avisa que a proposição está na ultima rodada
        /* $qtdeAvaliacoesFeitasAoUsuario = $bdAvaliacaoKappa->getQtdeDeAvaliacoesAoUsuario($proposta['id_usuario'], AvaliacaoKappa::TIPO_REPLICA, $avaliacaoKappa->getIdUsuario(), $avaliacaoKappa->getIdRegistro(), $avaliacaoKappa->getNomeTabela());
          $qtdeRodadas = 1;
          if ($qtdeAvaliacoesFeitasAoUsuario == $qtdeRodadas) {
          $this->notificaPropostaNaUltimaRodada($proposta, $itemNegociacao);
          } */


        #1/3 ja avaliou quer avaliar?
        $this->notificaQueUmTercoDasPessoasJaAvaliaram($proposta, $itemNegociacao);

        #Proposta foi aprovada
        #Melhorar lógica para ticket coletivo
        if ($avaliacaoKappa->getNota() == 1 && $avaliacaoKappa->getTipoAvaliacao() == AvaliacaoKappa::TIPO_AVALIACAO_FINAL) {
            $this->notificaPropostaAprovada($proposta);
        }
    }

    public function notificaPropostasPublicadasPelaOutraParte($id_ticket) {

        $usuariosNegociacao = TicketParticipante::buscaParticipantesTicketPorTipo($id_ticket, array('antagonista', 'protagonista'));

        $msg = "As proposições foram publicadas pela outra parte, clique <a href='#' onclick=\"parent.closeIFrame('painel_controle.php?pag=inc_rodadas_negociacao_chegada&mod=rodadas_negociacao&cnt=1')\">aqui</a> para acessar.";
        $msgEmail = "As proposições foram publicadas pela outra parte, clique <a href='http://www.1acordo.com/'>aqui</a> para acessar.";

        foreach ($usuariosNegociacao as $usuario) {

            chat_ticket::enviaMensagemSistema($usuario['id'], $id_ticket, $msg);

            $configuracaoItem = $this->bdTicketconfiguracaoItem->buscaConfiguracao(TicketConfiguracaoItem:: ALERTA_PROPOSTA_PUBLICADA_OUTRA_PARTE, 'usuario', $usuario['id']);

            if ($configuracaoItem['valor'] == 't') {
                $enviadorNewsletter = new EnviadorNewsletter('1 Acordo', $id_ticket, 'rbtec2014@gmail.com', $msgEmail);
                $enviadorNewsletter->enviar();
            }
        }
    }

    public function notificaPropostaAprovada($proposta) {

        $usuariosNegociacao = TicketParticipante::buscaParticipantesTicketPorTipo($proposta['id_ticket'], array('antagonista', 'protagonista'));

        $autor = Usuario::getUser($proposta['id_usuario']);

        $msg = "A proposta de " . $autor['nome'] . " foi aprovada, 'aqui' clique  para acessar.";

        foreach ($usuariosNegociacao as $usuario) {

            chat_ticket::enviaMensagemSistema($usuario['id'], $proposta['id_ticket'], $msg);

            $configuracaoItem = $this->bdTicketconfiguracaoItem->buscaConfiguracao(TicketConfiguracaoItem:: ALERTA_PROPOSTA_APROVADA, 'usuario', $usuario['id']);

            if ($configuracaoItem['valor'] == 't') {
                #Enviar e-mail
            }
        }
    }

    public function notificaAutorPropostaAvaliada($id_ticket, $proposta, $idAvaliador) {

        $autorProposta = Usuario::getUser($proposta['id_usuario']);

        $autorAvaliacao = Usuario::getUser($idAvaliador);

        $msg = $autorAvaliacao['nome'] . " avaliou sua proposição clique 'aqui' para acessar.";

        chat_ticket::enviaMensagemSistema($autorProposta['id'], $id_ticket, $msg);

        $configuracaoItem = $this->bdTicketconfiguracaoItem->buscaConfiguracao(TicketConfiguracaoItem:: ALERTA_PROPOSTA_SUA_FOI_AVALIADA, 'usuario', $autorProposta['id']);

        if ($configuracaoItem['valor'] == 't') {
            #Enviar e-mail
        }
    }

    public function notificaPoucoTempoFimDaNegociacao() {
        $usuariosNegociacao = TicketParticipante::buscaParticipantesTicketPorTipo($id_ticket, array('antagonista', 'protagonista'));

        $msg = "Falta 24 horas para o encerramento da negociação, clique 'aqui' para acessar.";

        foreach ($usuariosNegociacao as $usuario) {

            chat_ticket::enviaMensagemSistema($usuario['id'], $id_ticket, $msg);

            $configuracaoItem = $this->bdTicketconfiguracaoItem->buscaConfiguracao(TicketConfiguracaoItem:: ALERTA_FALTA_POUCO_TEMPO_FIM_NEGOCIACAO, 'usuario', $usuario['id']);

            if ($configuracaoItem['valor'] == 't') {
                #Enviar e-mail
            }
        }
    }

    public function notificaPropostaNaUltimaRodada($proposta, $idAvaliador) {
        $autorProposta = Usuario::getUser($proposta['id_usuario']);

        $autorAvaliacao = Usuario::getUser($idAvaliador);

        $msg = $autorAvaliacao['nome'] . " iniciou a última rodadada de negociação em  sua proposição clique 'aqui' para acessar.";

        chat_ticket::enviaMensagemSistema($autorProposta['id'], $id_ticket, $msg);

        $configuracaoItem = $this->bdTicketconfiguracaoItem->buscaConfiguracao(TicketConfiguracaoItem:: ALERTA_PROPOSTA_SUA_FOI_AVALIADA, 'usuario', $autorProposta['id']);

        if ($configuracaoItem['valor'] == 't') {
            #Enviar e-mail
        }
    }

    public function notificaQueUmTercoDasPessoasJaAvaliaram($proposta, $itemNegociacao) {

        $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

        $usuariosOutroTime = array();

        if ($proposta['time'] == 'protagonista') {
            $usuariosOutroTime = TicketParticipante::buscaParticipantesTicketPorTipo($proposta['id_ticket'], array('antagonista'));
        } else {
            $usuariosOutroTime = TicketParticipante::buscaParticipantesTicketPorTipo($proposta['id_ticket'], array('protagonista'));
        }

        $quemAvaliouList = $bdAvaliacaoKappa->buscaPessoasAvaliaramRegistro($itemNegociacao['id'], 'negociacao_item');

        $totalPessoas = count($usuariosOutroTime);

        #echo 'Total de Pessoas = ' . $totalPessoas . "</br>";

        $totalPessoasJaAvaliaram = count($quemAvaliouList);

        #echo 'Total de Pessoas Avaliaram = ' . $totalPessoasJaAvaliaram . "</br>";

        $umTercoDoTotal = intval($totalPessoas / 3);

        #echo '1/3 do Total = ' . $umTercoDoTotal . "</br>";

        if ($umTercoDoTotal < $totalPessoasJaAvaliaram) {

            foreach ($usuariosOutroTime as $usuario) {

                $avaliacaoRaizUsuario = $bdAvaliacaoKappa->buscaKappaRaizPorRegistroEUsuario($proposta['id'], 'negociacao_item', $usuario['id']);

                if (empty($avaliacaoRaizUsuario)) {

                    $msg = "1/3 das pessoas já avaliaram a proposta, quer avaliar? Clique 'aqui' para acessar.";

                    chat_ticket::enviaMensagemSistema($usuario['id'], $proposta['id_ticket'], $msg);

                    $configuracaoItem = $this->bdTicketconfiguracaoItem->buscaConfiguracao(TicketConfiguracaoItem:: ALERTA_UM_TERCO_DAS_PESSOAS_JA_AVALIARAM_PROPOSTA, 'usuario', $usuario['id']);

                    if ($configuracaoItem['valor'] == 't') {
                        #Enviar e-mail
                    }
                }
            }
        }
    }

    public function notificaUsuarioQueNaMetadeDoTempoAindaNaoAvaliou() {
        
    }

    public function notificaResumoDiarioDeAtividades() {
        
    }

}
