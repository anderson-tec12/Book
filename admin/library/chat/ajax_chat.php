<?php
require_once("../Util.php");
require_once("../../config.php");
require_once("../../persist/IDbPersist.php");
require_once("../../persist/connAccess.php");
require_once("../../persist/FactoryConn.php");
require_once("../../inc_usuario.php");
require_once("inc_chat.php");

//    div_chat_identifica_destinatario
//    div_chat_left_box
//    div_chat_box_mensagens
//    div_box_enviar
//
//    hd_current_chat
//    hd_current_chat_token
//    id_current_me
//    select_to
//    hd_to

$token = Util::request("hd_current_chat_token");
$id_usuario = Util::request("id_current_me");
$id_ticket =  Util::request("id_ticket");
$acao  = Util::request("acao");
$hd_to  = Util::request("hd_to");
$id_chat = Util::request("id_current_chat");
$mensagem = Util::request("mensagem");
$id_mensagem = Util::request("id_mensagem");
$hd_current_hour = Util::request("hd_current_hour");

$tokenCorreto = chat_ticket::getMd5Token($id_ticket."|". $id_usuario);

if ( $tokenCorreto != $token ){ //Token inválido.. não poderemos fazer nada, pois não é permitido que este rapaz veja este dado.
    
    echo("Token inválido!. Não é possível acessar esta opção");
    echo("<br>correto: ". $tokenCorreto . " recebido: ". $token . " -- ". $id_ticket. " Usuário: ". $id_usuario );
    die(" ");
}

$oConn = FactoryConn::getConn(K_CONN_TYPE);


$sql = " select id from chat_ticket where id_ticket = ". $id_ticket . " and ( ids_usuarios is null or ids_usuarios = '') ";
$lista = connAccess::fetchData($oConn, $sql);
for ( $i = 0; $i < count($lista); $i++){
    chat_ticket::setaIDSChat( $lista[$i]["id"] );
}

if ( $acao == "checa_chat" ){
    
//   $qtde_test = count( explode(",",$hd_to))+1;
//
//            $sql =  " select count(ctp.*) as qtde, ctp.id_chat from chat_ticket_participante ctp "
//             . " left join chat_ticket ct on ct.id = ctp.id_chat "
//                     . "where ct.id_ticket =  " . $id_ticket .
//                     " and ctp.id_chat in ( select id_chat from chat_ticket_participante where id_ticket = ".
//                      $id_ticket. " and id_usuario in ( ". $hd_to.",". $id_usuario . " ) ) group by ctp.id_chat having count(ctp.*) = ". $qtde_test; //Um papo só entre as pessoas que já estão nele.

          $ids_testa = chat_ticket::getListaIDSUsuarioEmOrdem($hd_to.",". $id_usuario);
    
                $sql = " select id from chat_ticket where id_ticket = ". $id_ticket . " and ids_usuarios='". $ids_testa."' ";
echo($sql);
                $lista = connAccess::fetchData($oConn, $sql);

                if ( count($lista) > 0 ){
                    echo("<!-- ##CURRENT##". $lista[0]["id"] ."##CURRENT##  -->" );
                    //die(" ");
                }else{
                    echo("#VAZIO#");
                }
  
    
}


if ( $acao == "new_chat"){
    
     $id_chat =   chat_ticket::geraNovoChatTicket($id_ticket, $hd_to.",".$id_usuario); //Devolve a id do chat para o sacaninha..
     echo("<!-- ##CURRENT##". $id_chat ."##CURRENT##  -->" );
     chat_ticket::getMenuEsquerdoChat($id_ticket, $id_usuario, $id_chat);
}

if ( $acao == "force_load_chat"){
    
     chat_ticket::forcaInteracaoDataChatParticipante($id_chat, $id_usuario, true );
     //echo("<!-- ##CURRENT##". $id_chat ."##CURRENT##  -->" );
     chat_ticket::getMenuEsquerdoChat($id_ticket, $id_usuario, $id_chat);
     //chat_ticket::mostraMensagensChat($id_chat, $id_ticket);
     
}



if ( $acao == "menu_esquerdo"){
    
      echo(  chat_ticket::getMenuEsquerdoChat($id_ticket, $id_usuario, $id_chat) );   
}
if ( $acao == "checa_msg_naolida"){
    
    $qtde_nao_lida =  chat_ticket::getQtdeConversaNaoLidaTicket($id_ticket, $id_usuario);
    
    echo("<!-- ##CURRENT##". Util::NVL($qtde_nao_lida,"0") ."##CURRENT##"."  -->" );
}
if ( $acao == "load_chat"){
   
    chat_ticket::mostraMensagensChat($id_chat, $id_ticket);
    //chat_ticket::listaMensagensDeUmaConversa($id_chat);
    chat_ticket::forcaInteracaoDataChatParticipante($id_chat, $id_usuario);//Indica o momento em que esse usuário leu alguma coisa..
    //
    if ( Util::request("hd_div_chat_visivel") == "1"){
    
       chat_ticket::forcaStatusLidoChatParticipante($id_chat, $id_usuario);//Indica quem foi lido.. e deleta o restante.
    }
    
    $continua_chat = "";
    
    $chat_tkt = connAccess::fastOne($oConn, "chat_ticket_mensagem", " id_chat = ". $id_chat. " order by id asc limit 1 ");
    if ( $chat_tkt["id_usuario"] == chat_ticket::getIDUserSistema() ){
        //Se é o sistema que enviou, então não tem direito de resposta
       // $continua_chat="SYSTEM##";
    }
    
    $qtde_nao_lida =  chat_ticket::getQtdeConversaNaoLidaTicket($id_ticket, $id_usuario);
    $continua_chat = Util::NVL($qtde_nao_lida,"0");
    
    echo("<!-- ##CURRENT##". $id_chat ."||".  chat_ticket::getTituloChatFormatado($id_chat, $id_usuario, "titulo")."##CURRENT##".$continua_chat."  -->" );
    
}

if ( $acao == "new_msg"){
   // echo("--- NEWID--> ". $id_chat);
    chat_ticket::forcaInteracaoDataChatParticipante($id_chat, $id_usuario);//Indica o momento em que esse usuário leu alguma coisa..
    chat_ticket::forcaStatusLidoChatParticipante($id_chat, $id_usuario);//Indica quem foi lido.. e deleta o restante.  
    
    $id_mensagem = chat_ticket::novaMensagem($id_ticket, $id_chat, $id_usuario, $mensagem);      
    chat_ticket::forcaStatusLidoChatParticipante($id_chat, $id_usuario);//Indica quem foi lido.. e deleta o restante.  
    
    $id_usuario_ticket = $id_usuario; // connAccess::executeScalar($oConn, " select id_usuario from ticket where id = ". $id_ticket );
    chat_ticket::mostraMensagem($id_mensagem, $id_usuario_ticket);
    
    echo("<!-- ##CURRENT##". $id_mensagem ."##CURRENT##  -->" );
}
if ( $acao == "load_unique_msg" && $id_mensagem != ""){
    echo("<!-- ##CURRENT##". $id_mensagem ."##CURRENT##  -->" );
    $id_usuario_ticket = connAccess::executeScalar($oConn, " select id_usuario from ticket where id = ". $id_ticket );
    chat_ticket::mostraMensagem($id_mensagem, $id_usuario_ticket);
}

if ( $acao == "checa_msg_chat" && $id_chat != ""){
         
        $hd_current_hour = Util::request("hd_current_hour");
      
         if ( $hd_current_hour != "" ){
                   $complemento = " and id_mensagem in  ( select id from chat_ticket_mensagem where id_chat = ". $id_chat . " and data > '".$hd_current_hour."' ) ";
         }
        
             $sql_conta = " select count(*) from chat_ticket_mensagem_status where "
                             . " id_usuario ".$commando." in ( ". $id_usuario . " ) and coalesce(lido, 0 ) = 0 ";

             if ( $id_chat != "" )
                 $sql_conta .= " and id_chat = ". $id_chat;
              
              $sql_conta .= $complemento;
        
             $qtde_nao_lido =  connAccess::executeScalar($oConn, $sql_conta );
             
             $data_maxima_ultima_interacao = connAccess::executeScalar($oConn, " select max(data) as res from chat_ticket_mensagem where id_chat = ". $id_chat  );
             
             if ( $data_maxima_ultima_interacao == "")
                 $data_maxima_ultima_interacao = Util::getCurrentBDdate();
             
        //$qtde_nao_lido =  chat_ticket::getMensagensNaoLida($id_usuario, $id_chat, " ", $complemento); 
   
        echo("<!-- ##CURRENT##".$id_chat."##CURRENT##". Util::NVL($qtde_nao_lido,"0") ."##CURRENT##".$data_maxima_ultima_interacao."##CURRENT##".$sql_conta."##CURRENT##  -->" );
    
}
?>