function getIdsTo(){
    
    var divpai = document.getElementById("div_select_users");
    var checks = divpai.getElementsByTagName("input");
    var saida = "";
    
    for ( var i = 0; i < checks.length; i++){
        
        //alert( checks[i].type );
        if ( checks[i].type=="checkbox" && checks[i].name.indexOf( "chkusuario") >-1 ){
                    if ( checks[i].checked ){
                        
                        if ( saida != "" ){ saida +=","; }
                        
                        saida += checks[i].value;
                    }
        }
    }
    
    return saida;
    
}  

function getConteudoForm(formulario, txt){
    
       var formulario_conteudo = "";
	   
	   for ( var y = 0; y < formulario.elements.length; y++){
		   
                   if ( formulario.elements[y].type=="checkbox" )
                       continue;
                   
                   if ( formulario.elements[y].type=="button" )
                       continue;
                   
		   if ( formulario_conteudo != ""){
			   formulario_conteudo +="&";
		   }
                   
                   if ( txt != "" ){
                       if ( formulario.elements[y].name.indexOf(txt) > -1){
                           continue;
                       }
                   }
                   
		   formulario_conteudo += formulario.elements[y].name+"="+formulario.elements[y].value;		   
	   }
    
       return formulario_conteudo;
}

function add_new_msg(){
    
    var f = document.frm_chat;
    var to = getIdsTo();
    
    f.hd_to.value  =to;
    
    if ( to == "" ){
        alert("Selecione ao menos um destinatário!");
        return false;
    }
    var div_chat_left_box = document.getElementById("div_chat_left_box");
    var div_carregando = document.getElementById("div_carregando");
    var div_temporario = document.getElementById("div_temporario");
    
    var url = "admin/library/chat/ajax_chat.php";
    f.acao.value = "new_chat";
    
    var fn_finish = function(texto_retorno, elemento_retorno){ //Se a criação de um novo chat foi realmente autorizada.
        
        if ( texto_retorno.indexOf("##CURRENT##") > -1 ){            
            var arp = texto_retorno.split("##CURRENT##");
            
            if ( arp[1] != "" ){
                load_chat( arp[1] );
            }
        }
        
    };
    
    var finish00 = function (texto_retorno, elem){ //Ação a ser executada após o teste de mensagem..
        
        //alert( texto_retorno );
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
                
                  load_chat( arp[1] );
                  return;
            }
        }
    }
    
    
    f.acao.value = "checa_chat";
    var url_get = url +"?"+getConteudoForm(f, "mensagem");
    ajaxGet(url_get,div_temporario,div_carregando.innerHTML, finish00 );
        
    
    
    
    
}

function load_chat( id , re_load ){ //Leitura de mensagens vem aqui.
    
    var f = document.frm_chat;
    
    var div_box_enviar = document.getElementById("div_box_enviar");
    var div_carregando = document.getElementById("div_carregando");
    var div_chat_identifica_destinatario = document.getElementById("div_chat_identifica_destinatario");
    var div_chat_box_mensagens = document.getElementById("div_chat_box_mensagens");
    var div_menssages_chat  = document.getElementById("div_menssages_chat");
    
    if ( div_carregando == null && parent != null ){
         div_carregando = parent.document.getElementById("div_carregando");  
        
    }
    
      if ( div_box_enviar == null && parent != null ){        
         div_box_enviar = parent.document.getElementById("div_box_enviar");   
        
    }
    
      if ( div_chat_identifica_destinatario == null && parent != null ){          
         div_chat_identifica_destinatario = parent.document.getElementById("div_chat_identifica_destinatario");
      }
      if ( div_chat_box_mensagens == null && parent != null ){          
         div_chat_box_mensagens = parent.document.getElementById("div_chat_box_mensagens");
      }
       if ( div_menssages_chat == null && parent != null ){          
         div_menssages_chat = parent.document.getElementById("div_menssages_chat");
      }
      
    div_box_enviar.style.display = "none";
    
    var url = "admin/library/chat/ajax_chat.php";
    f.id_current_chat.value = id;
    f.acao.value = "load_chat";
    
    //if ( force != null ){        
    //        f.acao.value = "force_load_chat";        
   // }
    
    var url_get = url +"?"+getConteudoForm(f , "mensagem");
    
    
    var fn_finish = function(texto_retorno, ret){
        div_box_enviar.style.display ="";
       // alert( texto_retorno );
          if ( texto_retorno.indexOf("##CURRENT##") > -1 ){            
                            var arp = texto_retorno.split("##CURRENT##");

                            if ( arp[1] != "" ){
                                
                                var frags = arp[1].split("||");
                                
                                
                                
                                div_chat_identifica_destinatario.innerHTML = frags[1];
                                
                                setaClassLeft( id );
                                 //var objDiv = document.getElementById("your_div");
                                 
                                 
                                 
                                 div_menssages_chat.scrollTop = div_menssages_chat.scrollHeight; //Seta scroll
                            }
                            if ( arp.length > 2 && arp[2].indexOf("SYSTEM##") > -1 ){
                                
                                        div_box_enviar.style.display ="none";
                            }
                          
                            if ( re_load != null && re_load != undefined && re_load == "1"){
                                
                               setTimeout(checaStatusCurrentChat, 2000 ); //2 segundos.. 
                                
                            }
          }
    };
    
    ajaxGet(url_get,div_chat_box_mensagens,div_carregando.innerHTML, fn_finish);
    
}

function nova_msg(){
    
    var f = document.frm_chat;
    
    if ( isVazio(f.mensagem, "Digite sua mensagem!"))
         return false;
    
    f.acao.value = "new_msg";
    
    var fn_finish = function(texto_retorno, ret){
        var div_chat_box_mensagens  = document.getElementById("div_chat_box_mensagens");
        var div_menssages_chat  = document.getElementById("div_menssages_chat");
        
        div_chat_box_mensagens.innerHTML +=  div_temporario.innerHTML;
        
         div_menssages_chat.scrollTop = div_menssages_chat.scrollHeight; //Seta scroll
         f.mensagem.value = "";
         f.btSalvarMensagem.disabled = false;
         f.mensagem.disabled = false;
    };
    
    var div_carregando = document.getElementById("div_carregando");
    var div_temporario = document.getElementById("div_temporario");
    
    
    f.btSalvarMensagem.disabled = true;
    f.mensagem.disabled = true;
    
    var div_chat_box_mensagens = document.getElementById("div_chat_box_mensagens");
    var url = "admin/library/chat/ajax_chat.php";
    ajaxPost(url,div_temporario,div_carregando.innerHTML, fn_finish, f );
}


function TypeMessage(evt)
{
    var key_code = evt.keyCode  ? evt.keyCode  :
                       evt.charCode ? evt.charCode :
                       evt.which    ? evt.which    : void 0;
 
 
    if (key_code == 13)
    {
        nova_msg();
    }
}
 

function setaClassLeft(id ){
    
    var div_chat_left_box = document.getElementById("div_chat_left_box");    
    var divs = div_chat_left_box.getElementsByTagName("div");
    
    
    for ( var i = 0; i < divs.length; i++){
        
        if ( divs[i].id.indexOf("div_aba") > -1){
         
            if ( divs[i].id == "div_aba"+id ){
                divs[i].className = "aba active";
            }else{                

                        if ( divs[i].className == "aba active" ){                
                            divs[i].className = "aba";
                        }
            
            }
            
        }
        
    }
    
}
function checaMensagensNaoLidas( ){
          var qtde_nao_lida = document.getElementById("qtde_nao_lida");
          var div_carregando = document.getElementById("div_carregando");
          var div_temporario = document.getElementById("div_temporario");
          var url = "admin/library/chat/ajax_chat.php";
          
          var f = document.frm_chat;
          f.acao.value ="checa_msg_naolida";
          
             var fn_finish = function(texto_retorno, ret){
                 
                    var arps = texto_retorno.split("##CURRENT##");
                    
                    if ( arps[1].value != qtde_nao_lida.value ){
                        carregaMenuEsquerdoChat();
                    }
                    
                    qtde_nao_lida.value = arps[1].value;
                    
                    setTimeout(checaMensagensNaoLidas, 6000 ); //6 segundos..
             }
          
    ajaxPost(url,div_temporario,div_carregando.innerHTML, fn_finish, f );
          
}

function carregaMenuEsquerdoChat(){
    
          var div_chat_left_box = document.getElementById("div_chat_left_box");
          var qtde_nao_lida = document.getElementById("qtde_nao_lida");
          var div_carregando = document.getElementById("div_carregando");
          var div_temporario = document.getElementById("div_temporario");
          var url = "admin/library/chat/ajax_chat.php";
    
        var f = document.frm_chat;
          f.acao.value ="menu_esquerdo";
          
             var fn_finish = function(texto_retorno, ret){
                 
                        div_chat_left_box.innerHTML = texto_retorno;
             }
          
    ajaxPost(url,div_temporario,div_carregando.innerHTML, fn_finish, f );
    
    
}


function checaStatusCurrentChat( ){
          var id_current_chat = document.getElementById("id_current_chat");
          var url = "admin/library/chat/ajax_chat.php";
          
          var f = document.frm_chat;
          
          f.acao.value ="checa_msg_chat";
          
          
              var fn_finish = function(texto_retorno, ret){
                  
                    
                    var arps = texto_retorno.split("##CURRENT##");
                    //alert( texto_retorno );
                    var qtde = parseInt( arps[2] );
                   // alert( qtde + " lidas ");
                   
                      if ( arps[3] != "" ){ //Atualiza a última data da interação que testamos..
                                
                                     document.getElementById("hd_current_hour").value = arps[3];
                       }
                             
                   //alert( qtde );
                  // alert(  arps[4] );
                    if ( qtde > 0 ){
                        load_chat( arps[1] , "1"); //Esse 1 é o indicativo de que vamos precisar checar este chat, se vamos recarregar o mesmo.
                    }else{
                        
                               setTimeout(checaStatusCurrentChat, 2000 ); //2 segundos.. 
                    }
                };
    
    var div_carregando = document.getElementById("div_carregando");
    var div_temporario = document.getElementById("div_temporario");
    
    
    var div_chat_box_mensagens = document.getElementById("div_chat_box_mensagens");
    var url = "admin/library/chat/ajax_chat.php";
    ajaxPost(url,div_temporario,div_carregando.innerHTML, fn_finish, f );
    
}