
var raiz_sistema = "";

var bodyAnterior = null;

var nota_botao_kappa_ativo = null;

function avaliar_responder_click($idKappaPai, divResposta, tipoAvaliacao) {

    var body = document.getElementById(divResposta);

    if (body.innerHTML == "") {
        //body.innerHTML = "<div class='carregando'><div/>";

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                body.innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", this.raiz_sistema + "library/kappa/kappa_votacao/ajax_gera_nova_avaliacao_kappa_votacao.php?id_pai=" + $idKappaPai + "&tipo=" + tipoAvaliacao, true);

        xmlhttp.send();

        if (this.bodyAnterior !== null) {
            this.bodyAnterior.innerHTML = "";
        }

    } else {
        body.innerHTML = "";
    }

    this.bodyAnterior = body;
}

function setNotaKappa(idPai, nota) {

    var comentario_nota = document.getElementById("kappa_comentario_nota_" + idPai);

    if (comentario_nota != null) {
        comentario_nota.value = nota;
    }

    var img_nota_ativar = document.getElementById("kappa_comentario_img_Kappa_" + nota + "_" + idPai);
    img_nota_ativar.src = "../painel/images/botoes_kappa_" + nota + "_ativo.png";

    if (this.nota_botao_kappa_ativo != null && this.nota_botao_kappa_ativo != nota) {
        var img_nota_desativar = document.getElementById("kappa_comentario_img_Kappa_" + this.nota_botao_kappa_ativo + "_" + idPai);
        img_nota_desativar.src = "../painel/images/botoes_kappa_" + this.nota_botao_kappa_ativo + ".png";
    }

    this.nota_botao_kappa_ativo = nota;

}

function salvar_avaliacao_kappa(id_kappa_pai, tipo_avaliacao) {

    var body = document.getElementById('div_avaliacoes_kappa');

    var id_registro = document.getElementById('id_registro_base_kappa').value;
    var nome_tabela = document.getElementById('nome_tabela_base_kappa').value;
    var id_usuario_avaliado = document.getElementById('id_usuario_avaliado').value;
    var nota = document.getElementById('kappa_comentario_nota_' + id_kappa_pai).value;
    var ressalva = document.getElementById('kappa_comentario_ressalva_' + id_kappa_pai).value;

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

    var url = this.raiz_sistema + "library/kappa/kappa_votacao/ajax_salva_avaliacao_kappa_votacao.php?>";

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            body.innerHTML = xmlhttp.responseText;

            if (typeof atualizacaoJSPosKappa == 'function') {
                alerta({title: "", text: "Salvo com sucesso!", type: "success"}, function () {
                    atualizacaoJSPosKappa();
                });
            }
        }
    }

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(dados);

}

function mostrar_respostas(nome_div) {

    var div_principal_respostas_finais = document.getElementById('div_kappa_principal_respostas_finais');

    if (div_principal_respostas_finais !== null && div_principal_respostas_finais !== undefined) {
        div_principal_respostas_finais.style.display = 'none';
    }

    var div = document.getElementById(nome_div);

    if (div.style.display == 'block') {
        div.style.display = 'none';
    } else {
        if (div.innerHTML != "") {
            div.style.display = 'block';
        }
    }

}

function mostrar_respostas_finais() {
    var div_principal = document.getElementById('div_kappa_principal');

    if (div_principal !== null && div_principal !== undefined) {
        div_principal.style.display = 'none';
    }

    var div_principal_respostas_finais = document.getElementById('div_kappa_principal_respostas_finais');

    if (div_principal_respostas_finais !== null && div_principal_respostas_finais !== undefined) {
        div_principal_respostas_finais.style.display = 'block';
    }
}

function setRaizSistemaKappaVotacao(url) {
    this.raiz_sistema = url;
}

