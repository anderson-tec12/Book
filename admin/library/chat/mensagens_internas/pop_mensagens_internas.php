<link rel="stylesheet" href="css/mensagens_internas.min.css" type="text/css" media="all"/>

<?
require_once 'chat/inc_chat.php';
?>
<!-- Multiple Select -->
<script src="../painel/js/jquery.multiple.select.js"></script>

<?

$ticket = ticket::getLastTicket( $id_usuario_logado );
ticket::setaNumeracaoTicket($ticket, true );
        //echo( "rend ->" . $ticket["id"] );
if ( $ticket["id_usuario"] == $id_usuario_logado ) {
                  ticket::adicionaParticipante($oConn, $ticket["id"], $ticket["id_usuario"], "protagonista"); //Verifica se o dono do ticket esta gravado como protagonista.
                }
                $id_current_chat = chat_ticket::getActiveChatID($ticket["id"], $id_usuario_logado);
                $load_default = true;
        //echo ( $id_current_chat . " --- ");
                ?>


                <div class="container container-twelve comp_mensagens_internas">
                  <form method="post" name="frmSendMsg" >
                    <input type="hidden" name="acao" id="acao" >

                    

                    <div class="twelve columns">
                      <div class="cabecalho_centro">
                        <div class="titulo"><h2>Mensagens Internas</h2></div>
                      </div>
                    </div>


                    <div class="five columns" id="div_select_users">
                      <?
                      $usuarios = chat_ticket::getListaUsuariosMensagem($ticket["id"], $id_usuario_logado );
                      ?>

                      <select name="select_to" id="select_to" class="multiple_select" multiple="multiple">
                        <?
                        Util::CarregaComboArray($usuarios, "id_usuario", "nome_completo", "")
                        ?>

                      </select>

                      <input type="hidden" name="hd_to" id="hd_to" >
                      <input class="button bt_mensagem" style="float: right;" value="Nova Mensagem" type="button" onclick="add_new_msg()">
                    </div>


                    <div class="seven columns">
                      <div class="nome_mensagem" id="div_chat_identifica_destinatario">Nova Mensagem</div>
                      <a class="numero_ticket hint--left" data-hint="Nome do acordo"><?= Util::NVL($ticket["nome"], $ticket["numero"]) ?></a>
                      <div class="img_ticket"></div>
                    </div>

                    <div class="twelve columns">
                      <div class="linha_divisoria"></div>
                    </div>


                    <div class="twelve columns">
                      <!-- Aba de Pessoas (Convidados e Protagonistas) -->
                      <div class="box_user_mensagens" id="div_chat_left_box">
                        <?
                        chat_ticket::getMenuEsquerdoChat($ticket["id"], $id_usuario_logado, $id_current_chat);                
                        ?>


                      </div><!-- /box_user_mensagens -->


                      <!-- Conversas realizadas -->
                      <div class="box_mensagens" id="div_chat_box_mensagens">

                      </div><!-- /box_mensagens -->

                      <!-- Enviar Comentário -->
                      <div class="box_enviar_mensagens" >
                        <div id="div_box_enviar" style="display:none" >
                          <input type="hidden" name="id_current_me" id="id_current_me" value="<?= $id_usuario_logado ?>" >
                          <input type="hidden" name="id_current_chat" id="id_current_chat" value="<?=$id_current_chat ?>" >
                          <input type="hidden" name="id_ticket" id="id_ticket" value="<?=$ticket["id"] ?>" >
                          <input type="hidden" name="hd_current_chat_token" id="hd_current_ticket_token" value="<?= chat_ticket::getMd5Token($ticket["id"]."|". $id_usuario_logado); ?>" >
                          <textarea class="textarea_clean" id="mensagem" name="mensagem" onkeypress="TypeMessage(event)" placeholder="Escreva sua mensagem..."></textarea>
                          <input class="button bt_mensagem" name="btSalvar" type="button" onclick="nova_msg()" value="Enviar"/>
                          <a class="iframe_modal button bt_mensagem_link" href="pop_index.php?pag=mensagens_internas_filtro&ticket_id=<?=$ticket["id"]?>&comp=mensagens_internas">Buscar Mensagens</a>
                        </div>
                      </div>

                    </div><!-- /twelve columns -->
                  </form>

                </div><!-- /comp_mensagens_internas -->


                <div id="div_carregando" style="display:none">
                  <div class="carregando">
        <!-- 
                    <i>Carregando..</i> 
                  -->
                </div>
              </div>
              <div id="div_temporario" style="display:none">
              </div>
<!--
DIVS:
div_chat_identifica_destinatario
div_chat_left_box
div_chat_box_mensagens
div_box_enviar

hd_current_chat
hd_current_chat_token
id_current_me
select_to
hd_to
-->

<script>
$(function() {
  $('.multiple_select').change(function() {
    console.log($(this).val());
  }).multipleSelect({
    width: '245px'
  });
});
</script>

<script type="text/javascript" src="../javascript/micox.js?t=34"></script>
<script type="text/javascript" src="chat/chat.js?t=6"></script>
<script type="text/javascript">

<? if ( $id_current_chat != "" && $load_default ) { ?>
  load_chat( '<?=$id_current_chat?>' );
  <? } ?>
  </script>

<script type="text/javascript">
  $(document).ready(function () {
    parent.$.fn.colorbox.resize({
      innerWidth: 960,
      innerHeight: $(document).height()
    });
  });
</script>