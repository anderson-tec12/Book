var f = null;

function respoder_kappa() {

    var ar = arguments;

    var id_registro = ar[0];
    var nome_tabela = ar[1];
    var id_componente_template = ar[2];
    var id_pai = ar[3];
    var div_retorno = document.getElementById(ar[4]);
    var prefx = ar[6];
    var identificador_div_kappa = ar[7];
    var nome_form = ar[8];

    this.oculta_kappa_antigo(nome_form);

    if (id_pai == null || id_pai == "") {
        this.define_formulario(nome_form);
    }

    var p_modal_nao_sei = "1";

    // alert( document.getElementById(prefx+"modal_nao_sei") );

    if (document.getElementById(prefx + "modal_nao_sei") != null && document.getElementById(prefx + "modal_nao_sei") != undefined) {
        p_modal_nao_sei = document.getElementById(prefx + "modal_nao_sei").value;
    }


    this.f.id_registro.value = id_registro;
    this.f.nome_tabela.value = nome_tabela;
    this.f.id_componente_template.value = id_componente_template;
    this.f.id_pai.value = id_pai;
    this.f.prefixo.value = prefx;
    // alert(f.prefixo.value);
    var hd_atual_kappa = this.f.hd_atual_kappa.value;
    var div_retorno = document.getElementById(identificador_div_kappa);

    if (hd_atual_kappa != "") {
        //Já temos um kappa aberto, vamos fecha-lo e abrir o nosso.

        var div_atual = document.getElementById(hd_atual_kappa);

        if (div_atual != null) {
            div_atual.innerHTML = "";
            div_atual.style.display = "none";
        }

        if (this.f.hd_atual_kappa.value == identificador_div_kappa) { //É o mesmo que ja esta aberto, vamos fechar ele e em seguida setar zerado.

            this.f.hd_atual_kappa.value = "";
            div_retorno.style.display = "none";
            return false;
        }

    }

    var p_localizador = document.getElementById("localizador_load_" + this.f.prefixo.value);


    var url = ar[5] + "library/kappa/ajax_grid_kappa.php?id_registro=" + id_registro +
            "&nome_tabela=" + nome_tabela + "&id_componente_template=" + id_componente_template +
            "&id_pai=" + id_pai + "&id_ticket=" + this.f.id_ticket.value + "&acao=responder&id_usuario=" + this.f.id_usuario.value +
            "&modal_nao_sei=" + p_modal_nao_sei + "&localizador_load=" + p_localizador.value;

    var url_consulta = ar[5] + "library/kappa/ajax_grid_kappa.php?id_registro=" + id_registro +
            "&nome_tabela=" + nome_tabela + "&id_componente_template=" + id_componente_template +
            "&id_pai=" + id_pai + "&id_ticket=" + this.f.id_ticket.value + "&id_usuario=" + this.f.id_usuario.value +
            "&modal_nao_sei=" + p_modal_nao_sei + "&localizador_load=" + p_localizador.value;

    if (this.f.url_ajax_responder != undefined) {
        this.f.url_ajax_responder.value = url;
        this.f.url_ajax.value = url_consulta;
    }

    if (this.f.ajax_retorno_responder != undefined) {
        this.f.ajax_retorno_responder.value = div_retorno.id;
    }


    var div_url_ajax = document.getElementById("div_url_ajax");

    if (div_url_ajax != null) {
        div_url_ajax.innerHTML = url + " ----- " + div_retorno.id;
    }


    if (this.f.hd_atual_kappa != undefined) {
        this.f.hd_atual_kappa.value = div_retorno.id;
    }
    div_retorno.style.display = "";
    ajaxGet(url, div_retorno, null);


}

function oculta_kappa_antigo(nome_novo_form) {
    if (this.f != null && f.name != nome_novo_form) {
        var hd_atual_kappa = this.f.hd_atual_kappa.value;
        var div_atual = document.getElementById(hd_atual_kappa);

        if (div_atual != null) {
            div_atual.innerHTML = "";
            div_atual.style.display = "none";
        }
    }
}

function define_formulario(nome_form) {
    //alert(nome_form);
    if (nome_form !== null && nome_form !== "") {
        this.f = document.forms[nome_form];
    } else {
        this.f = document.forms[0];
    }
}

function mostrar_respostas_kappa() {

    var ar = arguments;

    var id_registro = ar[0];
    var nome_tabela = ar[1];
    var id_componente_template = ar[2];
    var id_pai = ar[3];
    var prefx = ar[6];
    var nome_form = ar[8];

    this.oculta_kappa_antigo(nome_form);

    if (id_pai == null || id_pai == "") {
        define_formulario(nome_form);
    }

    this.f.id_registro.value = id_registro;
    this.f.nome_tabela.value = nome_tabela;
    this.f.id_componente_template.value = id_componente_template;
    this.f.id_pai.value = id_pai;
    this.f.prefixo.value = prefx;

    var p_modal_nao_sei = "1";

    // alert( document.getElementById(prefx+"modal_nao_sei") );

    if (document.getElementById(prefx + "modal_nao_sei") != null && document.getElementById(prefx + "modal_nao_sei") != undefined) {
        p_modal_nao_sei = document.getElementById(prefx + "modal_nao_sei").value;
    }

    //alert(ar[4]);

    var div_retorno = document.getElementById(ar[4]);

    var hd_atual_kappa = this.f.hd_atual_kappa.value;

    if (hd_atual_kappa != "") {
        //Já temos um kappa aberto, vamos fecha-lo e abrir o nosso.

        var div_atual = document.getElementById(hd_atual_kappa);

        if (div_atual == null) {

            // alert("não achei" + hd_atual_kappa );
        } else {
            div_atual.innerHTML = "";
            div_atual.style.display = "none";
        }
    }
    if (div_retorno != null) {
        if (div_retorno.innerHTML.toLowerCase().indexOf("não") > -1 || div_retorno.innerHTML.toLowerCase().indexOf("<img") > -1) {
            if (div_retorno.style.display != "none") {
                div_retorno.style.display = "none";
                div_retorno.innerHTML = "";
                return;

            }
        }
    } else {

        alert("Não me achei: " + ar[4]);
        return;
    }
    div_retorno.style.display = "";


    var p_localizador = document.getElementById("localizador_load_" + this.f.prefixo.value);

    var url = ar[5] + "library/kappa/ajax_grid_kappa.php?id_registro=" + id_registro +
            "&nome_tabela=" + nome_tabela + "&id_componente_template=" + id_componente_template +
            "&id_pai=" + id_pai + "&id_ticket=" + this.f.id_ticket.value + "&id_usuario=" + this.f.id_usuario.value +
            "&modal_nao_sei=" + p_modal_nao_sei + "&localizador_load=" + p_localizador.value;

    var div_url_ajax = document.getElementById("div_url_ajax");

    if (div_url_ajax != null) {
        div_url_ajax.innerHTML = url;
    }

    if (this.f.url_ajax != undefined)
        this.f.url_ajax.value = url;

    if (this.f.ajax_retorno != undefined) {
        this.f.ajax_retorno.value = div_retorno.id;
    }
    ajaxGet(url, div_retorno, null);
}

function reload_comentario() {

    var p_localizador = document.getElementById("localizador_load_" + this.f.prefixo.value);

    if (p_localizador == null) {

        alert("Não me achei" + "localizador_load_" + this.f.prefixo.value);
        return;
    }

    var ar_localizadores = p_localizador.value.split(',');

    var str_div_barra = ar_localizadores[0];
    var str_div_responder = ar_localizadores[1];
    var str_div_grid = ar_localizadores[2];

    var url = this.f.url_ajax.value;

    //alert(" ----> Grid para recarregar : " + str_div_grid );
    if (str_div_grid != "") {

        var div_retorno = document.getElementById(str_div_grid);

        if (div_retorno == null) {
            str_div_grid = str_div_grid.replace("gridgrid", "grid");
            div_retorno = document.getElementById(str_div_grid);
        }

        // alert( div_retorno );
        if (div_retorno != null) {
            div_retorno.style.display = "";
            ajaxGet(url, div_retorno, null);
            //alert(" ----> GRID --> " + div_retorno.id );
        }
    }


    var div_barra = document.getElementById(str_div_barra);
    ajaxGet(url + "&acao=barra", div_barra, null);


    // alert(" ---->barra : " + str_div_barra);
    // alert(" ----> " + url);
    // alert(" ----> " + div_barra.id );

    var div_resposta_kappa_comentario = document.getElementById("tabela_" + this.f.prefixo.value);

    if (typeof atualizacaoJSPosKappa == 'function') {
        alerta({title: "", text: "Salvo com sucesso!", type: "success"}, function () {
            atualizacaoJSPosKappa();
        });
    } else {
        if (div_resposta_kappa_comentario != null) {
            div_resposta_kappa_comentario.className = "alert alert-success";
            div_resposta_kappa_comentario.innerHTML = "Coment&aacute;rio registrado com sucesso!";
        }
    }
}

function setNotaKappa2(prefixo, nota) {

    for (var i = 1; i <= 5; i++) {

        var td = document.getElementById(prefixo + "td_nota" + i.toString());
        //botoes_kappa_1_ativo
        td.className = "td_bt_nota";

        var img = document.getElementById(prefixo + "imgKappa" + i.toString());

        if (img != null) {

            img.src = "../painel/images/botoes_kappa_" + i.toString() + ".png";
        }




        if (i == nota) {

            var comentario_nota = document.getElementById(prefixo + "comentario_nota");

            //td.className = "td_bt_nota_sel";
            if (comentario_nota != null) {
                comentario_nota.value = i.toString();
            } else {
                alert("não me achei: " + prefixo + "comentario_nota");
            }
            if (img != null) {
                img.src = "../painel/images/botoes_kappa_" + i.toString() + "_ativo.png";
            } else {

                alert("não me achei: " + prefixo + "imgKappa" + i.toString());
            }

        }

    }

}

//Processamento do kappa após clicar no botão salvar.
function kappa_processa(frm, prefixo, eventButton) {

    var p_comentario_nota = document.getElementById(prefixo + "comentario_nota");
    var botao_salvar = document.getElementById(prefixo + "_btSalvar");
    var p_modal_nao_sei = document.getElementById(prefixo + "modal_nao_sei");

    if (p_modal_nao_sei != null && p_modal_nao_sei.value == "1") {
        if (p_comentario_nota.value == "3") { //Vou abrir o modal perguntando se ele quer usar a ferramenta "não entendi".

            showModalKappa(frm, prefixo, eventButton);
            return false;
        }
    }

    if (p_modal_nao_sei == null) {
        //   alert("não me achei ==> " + prefixo + "modal_nao_sei");

    }
    return true; //Continua com a função normalmente.


}

function showModalKappa(frm, prefixo, eventButton) {

    var modal_fundo_kappa = document.getElementById("modal_fundo_kappa");
    var menu_sub_kappa = document.getElementById("menu_sub_kappa");

    if (eventButton != null) {

        var scrollLeft = (window.pageXOffset !== undefined) ? window.pageXOffset : (document.documentElement || document.body.parentNode || document.body).scrollLeft;
        var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;


        //    alert( eventButton.clientY + " - " + scrollTop );
        var topMarg = scrollTop + eventButton.clientY - 150;
        menu_sub_kappa.style.top = topMarg.toString() + "px";
        // 
    }
    //eventButton.X
    var url = "ferramentas/kappa/ajax_nao_entendi.php?prefixo=" + prefixo + "&id_registro=" +
            frm.id_registro.value + "&nome_tabela=" + frm.nome_tabela.value; //pop_index.php?pag=kappa3_comp_nao_entendi_importante&comp=kappa";

    if (frm.objeto_kappa != undefined)
        url += "&obj=" + frm.objeto_kappa.value;

    url += "&id_ticket=" + frm.id_ticket.value;
    url += "&comp=" + frm.comp.value;
    url += "&pag=" + frm.pag.value;

    if (document.getElementById("url_origem") != null) {
        url += "&url_origem=" + encodeURIComponent(document.getElementById("url_origem").value);
    }


    // ajaxPost(url,menu_sub_kappa,"<div class='carregando'></div>", null, frm, null );
    ajaxGet(url, menu_sub_kappa, "<div class='carregando'></div>", null);



    modal_fundo_kappa.style.display = "block"; // mascara.
    menu_sub_kappa.style.display = "block";
}

function hideModalKappa() {

    var modal_fundo_kappa = document.getElementById("modal_fundo_kappa");
    var menu_sub_kappa = document.getElementById("menu_sub_kappa");

    modal_fundo_kappa.style.display = "none"; // mascara.
    menu_sub_kappa.style.display = "none";
}