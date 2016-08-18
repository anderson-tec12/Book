
var raiz_sistema = "";

var bodyAnterior = null;

var nota_botao_kappa_ativo = null;

var myMap = new Map();

function avaliar_responder_click($idKappaPai, divResposta, tipoAvaliacao, nomeKappa, idRegistro, nomeTabela, idUsuarioAvaliado) {

    var body = document.getElementById(divResposta);

    if (body.innerHTML == "") {
        //body.innerHTML = "<div class='carregando'><div/>";

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                body.innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", this.raiz_sistema + "library/kappa/kappa_rounds/ajax_gera_nova_avaliacao_kappa_rounds.php?id_pai=" + $idKappaPai + "&tipo=" + tipoAvaliacao + "&nome_kappa=" + nomeKappa + "&id_registro=" + idRegistro + "&nome_tabela=" + nomeTabela + "&id_usuario_avaliado=" + idUsuarioAvaliado, true);

        xmlhttp.send();

        if (this.bodyAnterior !== null) {
            this.bodyAnterior.innerHTML = "";
        }

    } else {
        body.innerHTML = "";
    }

    this.bodyAnterior = body;
}

function setNotaKappa(nomeKappa, nota) {

    var comentario_nota = document.getElementById("kappa_comentario_nota_" + nomeKappa);

    if (comentario_nota != null) {
        comentario_nota.value = nota;
    }

    var img_nota_ativar = document.getElementById("kappa_comentario_img_Kappa_" + nota + "_" + nomeKappa);
    img_nota_ativar.src = "../painel/images/botoes_kappa_" + nota + "_ativo.png";

    if (this.myMap.get(nomeKappa) !== undefined && this.myMap.get(nomeKappa) !== nota) {
        var img_nota_desativar = document.getElementById("kappa_comentario_img_Kappa_" + this.myMap.get(nomeKappa) + "_" + nomeKappa);
        img_nota_desativar.src = "../painel/images/botoes_kappa_" + this.myMap.get(nomeKappa) + ".png";
    }

    this.myMap.set(nomeKappa, nota);

}

function salvar_avaliacao_kappa(id_kappa_pai, tipo_avaliacao, nomeKappa) {

    var body = document.getElementById('div_kappa_' + nomeKappa);

    if (body === null || body === undefined) {
        body = document.getElementById('div_kappa');
    }

    if (body === null || body === undefined) {
        alert('Atenção: div pai do kappa não foi definida!');
        return;
    }

    var id_registro = document.getElementById('id_registro_base_kappa_' + nomeKappa).value;
    var nome_tabela = document.getElementById('nome_tabela_base_kappa_' + nomeKappa).value;
    var id_usuario_avaliado = document.getElementById('id_usuario_avaliado_' + nomeKappa).value;
    var nota = document.getElementById('kappa_comentario_nota_' + nomeKappa).value;
    var ressalva = document.getElementById('kappa_comentario_ressalva_' + nomeKappa).value;

    if (nota === "" || nota === null) {
        alerta("Atenção", "informe a nota!", "warning");
        return;
    }

    if (ressalva === "" || ressalva === null) {
        alerta("Atenção", "informe a ressalva!", "warning");
        return;
    }

    if (tipo_avaliacao == null || tipo_avaliacao == undefined) {
        tipo_avaliacao = '';
    }


    var dados = "id_pai=" + id_kappa_pai + "&tabela=" + nome_tabela + "&nota=" + nota + "&ressalva=" + ressalva + "&id_registro=" + id_registro + "&tipo=" + tipo_avaliacao + "&id_usuario_avaliado=" + id_usuario_avaliado;

    var url = this.raiz_sistema + "library/kappa/kappa_rounds/ajax_salva_avaliacao_kappa_rounds.php";

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            body.innerHTML = xmlhttp.responseText;

            if (typeof atualizacaoJSPosKappa == 'function') {
                alerta({title: "", text: "Salvo com sucesso!", type: "success"}, function () {
                    atualizacaoJSPosKappa(nomeKappa);
                });
            }
        }
    }

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(dados);

}

function mostrar_respostas(nomeKappa) {

    var div_principal_respostas_finais = document.getElementById('div_respostas_finais_' + nomeKappa);

    if (div_principal_respostas_finais !== null && div_principal_respostas_finais !== undefined) {
        div_principal_respostas_finais.style.display = 'none';
    }

    var div = document.getElementById('div_grid_kappa_' + nomeKappa);

    if (div.style.display == 'block') {
        div.style.display = 'none';
    } else {
        if (div.innerHTML != "") {
            div.style.display = 'block';
        }
    }

}

function mostrar_respostas_finais(nomeKappa) {
    var div_principal = document.getElementById('div_grid_kappa_' + nomeKappa);

    if (div_principal !== null && div_principal !== undefined) {
        div_principal.style.display = 'none';
    }

    var div_principal_respostas_finais = document.getElementById('div_respostas_finais_' + nomeKappa);

    if (div_principal_respostas_finais !== null && div_principal_respostas_finais !== undefined) {
        if (div_principal_respostas_finais.style.display == 'block') {
            div_principal_respostas_finais.style.display = 'none';
        } else {
            div_principal_respostas_finais.style.display = 'block';
        }
    }
}

function setRaizSistemaKappaRounds(url) {
    this.raiz_sistema = url;
}

