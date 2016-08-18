<?
$ticket = array("id"=>"0");
$id_current_chat = chat_ticket::getActiveChatID($ticket["id"], $id_usuario_logado);   
$load_default = true;

if ( $id_usuario_logado != "" ){
?>

<form method="post" name="frm_chat" >
                    <input type="hidden" name="acao" id="acao" >
                    <input type="hidden" name="id_ticket" id="id_ticket" value="0" >
                    <input type="hidden" name="hd_current_chat_token" id="hd_current_chat_token" value="<?=chat_ticket::getMd5Token( $ticket["id"]."|". $id_usuario_logado) ?>" >
                    <input type="hidden" name="id_current_me" id="id_current_me" value="<?=$id_usuario_logado?>" >
                          <input type="hidden" name="id_current_chat" id="id_current_chat" value="<?=$id_current_chat ?>" >
                          <input type="hidden" name="qtde_nao_lida" id="qtde_nao_lida" value="<?=chat_ticket::getQtdeConversaNaoLidaTicket($ticket["id"], Util::NVL($id_usuario_logado,"0")) ?>" >
                          
                          <input type="hidden" name="hd_div_chat_visivel" id="hd_div_chat_visivel" value="0" >
                          <input type="hidden" name="hd_current_hour" id="hd_current_hour" value="" >
                    


<!-- Sidebar -->
<input type="checkbox" id="chat-slide" onclick="indicaVisualizacao(this)"/>
<div class="container">
	<label for="chat-slide" class="chat-toggle hint--left" data-hint="Abrir e Fechar Chat"></label>
	<div class="chat-sidebar">
		<!-- Janela -->
		<div class="conversation-list">
			<div class="profile-avatar" >
                            
                            <ul>
                                <li><a href="pop_index.php?pag=chat" class="add-contact hint--left iframe-modal-small" data-hint="Enviar mensagem"></a></li>
                            </ul>
                            
                            <div id="div_chat_left_box">
				
					
					
                                             <?
                                            chat_ticket::getMenuEsquerdoChat($ticket["id"], $id_usuario_logado, $id_current_chat);                
                                            ?>
                                        
                                        <? if ( false ) { ?>
					<!-- Lista -->
					<li>
						<div class="popups">
							<a href="#">
								<div class="badges">
									<img class="avatar-small" src="img/avatar.jpg">
									<div class="number-badges">4</div>
								</div>
							</a>
								<span>
									<div class="content-popup">
										<img class="avatar-medium" src="img/avatar.jpg">
										<h3>Roseli Aparecida</h3>
										<p>Pós-graduando em Fotografia e formada em Comunicação Visual e atualmente estudo Design.</p>
										<div class="list-icon-posts">
											<div class="post-mini post-fogo"></div>
											<div class="post-mini post-animal"></div>
											<div class="post-mini post-peixe"></div>
											<div class="post-mini post-nadar"></div>
											<div class="post-mini post-escalar"></div>
											<div class="post-mini post-restaurante"></div>
										</div>
									</div>
								</span>
						</div>
					</li>

					<li><a href="#"><img class="avatar-small active" src="img/avatar.jpg"></a></li>
					<li><a href="#"><img class="avatar-small" src="img/avatar.jpg"></a></li>
					<li><a href="#"><img class="avatar-small" src="img/avatar.jpg"></a></li>
					<li><a href="#"><img class="avatar-small" src="img/avatar.jpg"></a></li>
					<li><a href="#"><img class="avatar-small" src="img/avatar.jpg"></a></li>
					<li><a href="#"><img class="avatar-small" src="img/avatar.jpg"></a></li>
					<li><a href="#"><img class="avatar-small" src="img/avatar.jpg"></a></li>
					
					<!-- Mostrar todos -->
					<li><a href="#" class="more-contact hint--left iframe-modal-small" data-hint="Mostrar todos os contatos"></a></li>
                                        <? } ?>
			
                            </div>
			</div>
                         <div id="div_carregando" style="display:none">
                                               <div class="carregando">
                                     <!-- 
                                                 <i>Carregando..</i> 
                                               -->
                                             </div>
                        </div>
                        <div id="div_temporario" style="display:none">
                        </div>
		</div><!-- /conversation-list -->

		<section class="conversation-inner" id="div_chat_visivel">
			<div class="header-contact" id="div_chat_identifica_destinatario">
				<h4 class="hint--left" data-hint="Roberto Vieira, Isabelly Fernanda, Sergio da Silva, Mario Andrade, Juliana da Silva ">
					Roberto Vieira, Isabelly Fernanda, Sergio da Silva...
				</h4>
			</div>
			
			<!-- Mensagens enviadas -->
			<div class="menssages-chat" id="div_menssages_chat">
				<div class="content-message"  id="div_chat_box_mensagens">
					
					<div class="message">
						<h4>Edgar de Oliveira Souza</h4>
						<h5>25/11/2015 12:23</h5>
						<p>Donec accumsan aliquet dui. Phasellus elementum cursus dolor, vel interdum neque elementum quis. Fusce a eros ut diam gravida porttitor sed vel ex.</p>
					</div>
					<div class="message">
						<h4>Roberto Vieira</h4>
						<h5>29/11/2015 12:45</h5>
						<p>Sed euismod et ex in rhoncus. Sed vitae molestie eros</p>
						<p>Donec sit amet orci quis ligula efficitur tincidunt consectetur ut enim.</p>
					</div>
					<div class="message">
						<h4>Isabelly Fernanda</h4>
						<h5>10/12/2015 14:56</h5>
						<p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
					</div>
				
					<!-- Enviar Mensagem -->
					

				</div><!-- /content-message -->
                                <div class="submit-message" id="div_box_enviar">
						<textarea placeholder="Enviar" id="mensagem" name="mensagem" onkeypress="TypeMessage(event)"></textarea>
                                                      <input class="button bt_mensagem" name="btSalvarMensagem" type="button" onclick="nova_msg()" value="Enviar"/>
					</div>
			</div><!-- /menssages-chat -->
		</section><!-- /conversation-inner -->

	</div>
</div>
<? } ?>
</form>
<script type="text/javascript" src="admin/javascript/micox.js?t=34"></script>
<script type="text/javascript" src="admin/library/chat/chat.js?t=778"></script>
<script type="text/javascript">

<? if ( $id_current_chat != "" && $load_default ) { ?>
   load_chat( '<?=$id_current_chat?>' );
  <? } ?>
      

    function indicaVisualizacao( obj ){
             var hd_div_chat_visivel = document.getElementById("hd_div_chat_visivel");
             var div_chat_visivel  =  document.getElementById("div_chat_visivel");
             
             hd_div_chat_visivel.value = "0";
             
            // alert( obj.checked );  div_chat_visivel.style.display != "none"
             if (  obj.checked ){
                 
                     hd_div_chat_visivel.value = "1";
                 
                     var id_current_chat= document.getElementById("id_current_chat");
                     
                     if ( id_current_chat != null && id_current_chat.value != "" ){
                         load_chat( id_current_chat.value );
                     }
             }
    }
     
checaStatusCurrentChat();  

checaMensagensNaoLidas(); 
  </script>