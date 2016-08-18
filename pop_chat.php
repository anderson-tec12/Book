<?
require_once("inc_protecao_usuario.php");
require_once 'admin/library/chat/inc_chat.php';

$ticket = array("id"=>"0");


$id_current_chat = chat_ticket::getActiveChatID($ticket["id"], $id_usuario_logado);

?>
<form method="post" name="frm_pop">
  <input type="hidden" name="acao" id="acao" >
  <input type="hidden" name="id_ticket" id="id_ticket" value="0" >
  <input type="hidden" name="hd_current_chat_token" id="hd_current_chat_token" value="<?=chat_ticket::getMd5Token( $ticket["id"]."|". $id_usuario_logado) ?>" >
  <input type="hidden" name="id_current_me" id="id_current_me" value="<?=$id_usuario_logado?>" >
  <input type="hidden" name="id_current_chat" id="id_current_chat" value="<?=$id_current_chat ?>" >

  <div class="container">
   <div class="cboxIframe pop_chat">

    <h1>Chat</h1>

    <div class="column6">
     <div class="form-group">

      <input type="text" class="search" placeholder="Digite um nome para buscar">

      <label>Selecione com quem quer conversar</label>

      <?
      $usuarios = chat_ticket::getListaUsuariosMensagem($ticket["id"], $id_usuario_logado );
      ?>

      <div class="list-user-chat" id="div_select_users">

        <? for ( $i = 0; $i < count($usuarios); $i++ ) { 
          $item = $usuarios[$i];
          ?>

          <div class="checkbox">
            <label><input name="chkusuario_<?= $i ?>"
              id="chkusuario_<?= $i ?>"
              value="<?= $item["id_usuario"] ?>" type="checkbox"><img class="avatar-mini" src="<?= Usuario::mostraImagemUser($item["imagem"], $item["id_usuario"])?>"><?=$item["nome_completo"]?></label>
            </div>
            <? } ?>

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

                                         </div>


                                         <input type="hidden" name="hd_to" id="hd_to" >
                                         <input class="btn" value="Iniciar" type="button" onclick="pop_add_new_msg()">

                                         <!-- <button class="btn">Iniciar</button> -->
                                       </div>

                                     </div><!-- /cboxIframe -->
                                   </div><!-- /container -->

                                 </form>
                                 <script type="text/javascript">
                                   $(document).ready(function () {
                                    parent.$.fn.colorbox.resize( {
                                     innerWidth: 490,
                                     innerHeight: 660
                                   });
                                  });
                                </script>

                                <script type="text/javascript" src="admin/javascript/micox.js?t=34"></script>
                                <script type="text/javascript" src="admin/library/chat/chat.js?t=778"></script>
                                <script type="text/javascript">


                                  function pop_add_new_msg(){

                                    var f = document.frm_pop;
                                    var to = getIdsTo();

                                    f.hd_to.value  =to;

                                    if ( to == "" ){
                                      alert("Selecione ao menos um destinatário!");
                                      return false;
                                    }
                                    var div_chat_left_box = parent.document.getElementById("div_chat_left_box");
                                    var div_carregando = document.getElementById("div_carregando");
                                    var div_temporario = document.getElementById("div_temporario");

                                    var url = "admin/library/chat/ajax_chat.php";
                                    f.acao.value = "new_chat";
    var fn_finish = function(texto_retorno, elemento_retorno){ //Se a criação de um novo chat foi realmente autorizada.

      if ( texto_retorno.indexOf("##CURRENT##") > -1 ){            
        var arp = texto_retorno.split("##CURRENT##");

        if ( arp[1] != "" ){
          parent.load_chat( arp[1] );
        }
      }

    };
    
    var finish00 = function (texto_retorno, elem){ //Ação a ser executada após o teste de mensagem..

       // alert( texto_retorno );
       if ( texto_retorno.indexOf("#VAZIO#") > -1 ){

                        f.acao.value = "new_chat"; //Força a criação de um novo chat..

                        var url_get = url +"?"+getConteudoForm(f, "mensagem");

                        //ajaxPost(url,div_chat_left_box,div_carregando.innerHTML, fn_finish, f,"" );
                        ajaxGet(url_get,div_chat_left_box,div_carregando.innerHTML, fn_finish);

                      }
                      if ( texto_retorno.indexOf("##CURRENT##") > -1 ){            
                        var arp = texto_retorno.split("##CURRENT##");

                        if ( arp[1] != "" ){

                          f.id_current_chat.value = arp[1];
                          f.acao.value = "force_load_chat";
                          var url_get = url +"?"+getConteudoForm(f, "mensagem");
                          ajaxGet(url_get,div_chat_left_box,div_carregando.innerHTML, finish00 );

                          parent.load_chat( arp[1] );
                          return;
                        }
                      }
                    }


                    f.acao.value = "checa_chat";
                    var url_get = url +"?"+getConteudoForm(f, "mensagem");
    //alert( url_get );
    ajaxGet(url_get,div_temporario,div_carregando.innerHTML, finish00 );

    
    
    
    
  }


</script>