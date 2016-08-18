var raiz_sistema = "";
var prefixo = "";

function hideModalMenuCircular() {
    mascara_modal = document.getElementById("mascara");
    modal = document.getElementById("menu_circular");

    mascara_modal.style.display = "none";
    modal.style.display = "none";
}

function showModalMenuCircular(idModulo, grupo, prefixo) {

    if (prefixo != null) {
        this.prefixo = prefixo;
    }

    if (grupo == null) {
        grupo = "";
    }

    mascara_modal = document.getElementById("mascara");
    modal = document.getElementById("menu_circular");

    mascara_modal.style.display = "block";
    modal.style.display = "block";

    if (idModulo !== this.idModuloAtual) {

        modal.innerHTML = "<div class='carregando'><div/>";

        this.idModuloAtual = idModulo;

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                modal.innerHTML = xmlhttp.responseText;
                $('#rotatescroll').tinycircleslider({interval: false, dotsSnap: true});
            }
        }

        xmlhttp.open("GET", this.raiz_sistema + "library/menu_circular/modulo_ajax_menu_circular.php?id=" + idModulo + "&grupo=" + grupo, true);

        xmlhttp.send();
    }

}

function clickAdicionarItem(idItem, multselect) {

    if (multselect == null) {
        multselect = false;
    }

    var inputTemplatesAdicionados = document.getElementById(this.prefixo + "_templates_adicionados");
    var inputIdModulo = document.getElementById(this.prefixo + "_id_modulo");
    var idModulo = inputIdModulo.value;
    inputTemplatesAdicionados.value = idItem;

    var body = document.getElementById(this.prefixo + '_div_templates_adicionados');
    body.innerHTML = "<div class='carregando'><div/>";

    var mascara_modal = document.getElementById("mascara");
    mascara_modal.style.display = "none";

    var menu_circular = document.getElementById('menu_circular');
    menu_circular.style.display = "none";

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            body.innerHTML = xmlhttp.responseText;

            if (typeof atualizaTelaAposSelecionarTemplate === 'function') {
                atualizaTelaAposSelecionarTemplate(prefixo);
            }
        }
    }

    xmlhttp.open("GET", this.raiz_sistema + "painel/modulos/ajax_modulo_adicionar_template.php?itens=" + idItem + "&id_modulo=" + idModulo, true);

    xmlhttp.send();

}

function clickConcluirSelecao() {

    var inputTemplatesAdicionados = document.getElementById(this.prefixo + "_templates_adicionados");
    var inputIdModulo = document.getElementById(this.prefixo + "_id_modulo");

    var idModulo = inputIdModulo.value;
    var templatesAdicionados = inputTemplatesAdicionados.value;

    var body = document.getElementById(this.prefixo + 'div_templates_adicionados');
    body.innerHTML = "<div class='carregando'><div/>";

    var mascara_modal = document.getElementById("mascara");
    mascara_modal.style.display = "none";

    var menu_circular = document.getElementById('menu_circular');
    menu_circular.style.display = "none";

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            body.innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET", this.raiz_sistema + "painel/modulos/ajax_modulo_adicionar_template.php?itens=" + templatesAdicionados + "&id_modulo=" + idModulo, true);

    xmlhttp.send();
}

function selecionarItemMultselect(idCheck, idItem) {
    if (typeof updateItensSelecionados == 'function') {
        updateItensSelecionados(idCheck, idItem);
    }
}

function setRaizSistemaMenuCircular(url) {
    this.raiz_sistema = url;
}

function updateItensSelecionados(idCheck, idItem) {

    var input_itens = document.getElementById(this.prefixo + "_templates_adicionados");

    var checkbox = document.getElementById(idCheck);

    if (checkbox.checked == 1) {
        if (input_itens.value.indexOf(idItem) === -1) {
            input_itens.value += idItem + ',';
        }
    } else {
        input_itens.value = input_itens.value.replace(idItem + ',', '');
    }
}