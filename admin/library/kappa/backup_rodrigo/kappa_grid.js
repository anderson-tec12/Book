function respoder_kappa(){
    
    var f = document.forms[0];
    
    var ar = arguments;
    
    var id_registro = ar[0];
    var nome_tabela = ar[1];
    var id_componente_template = ar[2];
    var id_pai = ar[3];
    var div_retorno = document.getElementById(ar[4]);
    var prefx = ar[6];
    var identificador_div_kappa = ar[7];
    
    
    //var p_comentario_nota = document.getElementById(prefx + "comentario_nota");
    //p_comentario_nota.value = "";
    
    
    //var p_ressalva = document.getElementById(prefx + "ressalva");
    //p_ressalva.value = "";
    
    f.id_registro.value = id_registro;
    f.nome_tabela.value = nome_tabela;
    f.id_componente_template.value = id_componente_template;
    f.id_pai.value = id_pai;
    f.prefixo.value = prefx;
    // alert(f.prefixo.value);
    var hd_atual_kappa = f.hd_atual_kappa.value;
    var div_retorno = document.getElementById(identificador_div_kappa);
    
    if ( hd_atual_kappa != "" ){
        //Já temos um kappa aberto, vamos fecha-lo e abrir o nosso.
        
        var div_atual = document.getElementById(hd_atual_kappa);
		if ( div_atual != null ){
					div_atual.innerHTML = "";
					div_atual.style.display = "none";
		}
                
        if (  f.hd_atual_kappa.value == identificador_div_kappa ){ //É o mesmo que ja esta aberto, vamos fechar ele e em seguida setar zerado.
            
             f.hd_atual_kappa.value = "";
             div_retorno.style.display = "none";
             return false;
        }
                
    }
    
    
    
  
    
     var url = ar[5]+"library/kappa/ajax_grid_kappa.php?id_registro="+id_registro+
            "&nome_tabela="+nome_tabela+"&id_componente_template="+id_componente_template+
            "&id_pai="+id_pai+"&id_ticket="+f.id_ticket.value+"&acao=responder&id_usuario="+f.id_usuario.value;
    
        var url_consulta = ar[5]+"library/kappa/ajax_grid_kappa.php?id_registro="+id_registro+
            "&nome_tabela="+nome_tabela+"&id_componente_template="+id_componente_template+
            "&id_pai="+id_pai+"&id_ticket="+f.id_ticket.value+"&id_usuario="+f.id_usuario.value;
    
    if ( f.url_ajax_responder != undefined ){
        f.url_ajax_responder.value = url;
        f.url_ajax.value = url_consulta;
        
    }
    
    if ( f.ajax_retorno_responder != undefined ){
        f.ajax_retorno_responder.value = div_retorno.id;
    }
    
      
    var div_url_ajax = document.getElementById("div_url_ajax");
    
    if ( div_url_ajax != null ){
        div_url_ajax.innerHTML = url + " ----- " + div_retorno.id;
    }
    
   
   if ( f.hd_atual_kappa != undefined ){
        f.hd_atual_kappa.value = div_retorno.id;
    }
    div_retorno.style.display = "";
    ajaxGet(url,div_retorno, null );
    
    
}




function mostrar_respostas_kappa(){
    var f = document.forms[0];
    
    var ar = arguments;
    
    var id_registro = ar[0];
    var nome_tabela = ar[1];
    var id_componente_template = ar[2];
    var id_pai = ar[3];
    var prefx = ar[6];
    
    
    f.id_registro.value = id_registro;
    f.nome_tabela.value = nome_tabela;
    f.id_componente_template.value = id_componente_template;
    f.id_pai.value = id_pai;
    f.prefixo.value = prefx;
    
    var div_retorno = document.getElementById(ar[4]);
    
      var hd_atual_kappa = f.hd_atual_kappa.value;
    
    if ( hd_atual_kappa != "" ){
        //Já temos um kappa aberto, vamos fecha-lo e abrir o nosso.
        
        var div_atual = document.getElementById(hd_atual_kappa);
        
        if ( div_atual == null ){
            
                  // alert("não achei" + hd_atual_kappa );
                }else{
                div_atual.innerHTML = "";
                div_atual.style.display = "none";
            }
    }
    
    if ( div_retorno.innerHTML.toLowerCase().indexOf("não") >-1  || div_retorno.innerHTML.toLowerCase().indexOf("<img") >-1 ){
                if ( div_retorno.style.display != "none"){
                    div_retorno.style.display = "none";
                    div_retorno.innerHTML = "";
                    return;

                }
     }
    div_retorno.style.display = "";
    
    
    
    var url = ar[5]+"library/kappa/ajax_grid_kappa.php?id_registro="+id_registro+
            "&nome_tabela="+nome_tabela+"&id_componente_template="+id_componente_template+
            "&id_pai="+id_pai+"&id_ticket="+f.id_ticket.value+"&id_usuario="+f.id_usuario.value;
    
    var div_url_ajax = document.getElementById("div_url_ajax");
    
    if ( div_url_ajax != null ){
        div_url_ajax.innerHTML = url;
    }
    
    if ( f.url_ajax != undefined )
        f.url_ajax.value = url;
    
    if ( f.ajax_retorno != undefined ){
        f.ajax_retorno.value = div_retorno.id;
    }
    ajaxGet(url,div_retorno, null );
}

function reload_comentario(){
    
       var f = document.forms[0];
       
       //alert("localizador_" + f.prefixo.value);
       
       var p_localizador = document.getElementById("localizador_load_" + f.prefixo.value);
       
       if ( p_localizador == null ){
           
           alert("Não me achei");
           return;
       }
       
       var ar_localizadores = p_localizador.value.split(',');
       
       var str_div_barra = ar_localizadores[0];
       var str_div_responder = ar_localizadores[1];
       var str_div_grid = ar_localizadores[2];
  
        var url = f.url_ajax.value;
        
       //alert(" ----> Grid para recarregar : " + str_div_grid );
        if ( str_div_grid != "" ){
            
            var div_retorno = document.getElementById( str_div_grid );
            
             if ( div_retorno == null ){
                 str_div_grid = str_div_grid.replace("gridgrid","grid");
                 div_retorno = document.getElementById( str_div_grid );
             }
            
           // alert( div_retorno );
            if ( div_retorno != null ){
                div_retorno.style.display = "";
                 ajaxGet(url,div_retorno, null );
                 //alert(" ----> GRID --> " + div_retorno.id );
             }
        }
  
  
        var div_barra = document.getElementById(str_div_barra);
        ajaxGet(url+"&acao=barra",div_barra, null );
  
    
       // alert(" ---->barra : " + str_div_barra);
       // alert(" ----> " + url);
       // alert(" ----> " + div_barra.id );
    
        var div_resposta_kappa_comentario = document.getElementById("tabela_"+f.prefixo.value);
        
        if ( div_resposta_kappa_comentario != null ){
			    div_resposta_kappa_comentario.className = "alert alert-success";
                div_resposta_kappa_comentario.innerHTML = "Coment&aacute;rio registrado com sucesso!";
        }
}



  function setNotaKappa2(prefixo, nota ){                                                    
                 var f = document.forms[0];
                 
                 
                 for ( var i = 1; i <= 5; i++){
                     
                     var td = document.getElementById(prefixo + "td_nota"+i.toString() );
                     //botoes_kappa_1_ativo
                     td.className = "td_bt_nota";
                     
                     var img = document.getElementById(prefixo + "imgKappa"+i.toString() );
                     
                     if ( img != null ){
                         
                         img.src = "../painel/images/botoes_kappa_"+i.toString()+".png";
                     }
                    
                   
                    
                     
                     if ( i == nota ){
                         
                                    var comentario_nota = document.getElementById(prefixo +"comentario_nota");
                         
                                    //td.className = "td_bt_nota_sel";
                                    if ( comentario_nota != null ){
                                               comentario_nota.value = i.toString();
                                    }
                                    if ( img != null ){
                                            img.src = "../painel/images/botoes_kappa_"+i.toString()+"_ativo.png";
                                    }
                                    
                               }
                    
                 }
        
}
       
