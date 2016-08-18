var raiz_sistema = "";

function hideModalMenuCircular() {
    mascara_modal = document.getElementById("mascara");
    modal = document.getElementById("menu_circular");

    mascara_modal.style.display = "none";
    modal.style.display = "none";
}

function showModalMenuCircular(idFerramenta, tipo) {

    if (tipo == null) {
        tipo = "";
    }
    
    //alert(tipo);

    mascara_modal = document.getElementById("mascara");
    modal = document.getElementById("menu_circular");

    mascara_modal.style.display = "block";
    modal.style.display = "block";

    if (idFerramenta !== this.idFerramentaAtual) {

        modal.innerHTML = "<div class='carregando'><div/>";

        this.idFerramentaAtual = idFerramenta;

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                modal.innerHTML = xmlhttp.responseText;
                $('#rotatescroll').tinycircleslider({interval: false, dotsSnap: true});
            }
        }

        xmlhttp.open("GET", this.raiz_sistema + "library/menu_circular/ajax_menu_circular.php?id=" + idFerramenta + "&tipo=" + tipo, true);

        xmlhttp.send();
    }
}

function clickAdicionarItemFerramenta(idItemFerramenta, multselect) {

    if (multselect == null) {
        multselect = false;
    }

    var inputItensAdicionados = document.getElementById("itens_adicionados");
    var inputIdFerramenta = document.getElementById("id_ferramenta");
    var idFerramenta = inputIdFerramenta.value;

    inputItensAdicionados.value = idItemFerramenta;

    var body = document.getElementById('div_itens_adicionados');
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

    xmlhttp.open("GET", this.raiz_sistema + "painel/ferramentas/ajax_adicionar_item_ferramenta.php?itens=" + idItemFerramenta + "&id_ferramenta=" + idFerramenta, true);

    xmlhttp.send();

}

function clickConcluirSelecaoFerramenta() {

    var inputItensAdicionados = document.getElementById("itens_adicionados");
    var inputIdFerramenta = document.getElementById("id_ferramenta");

    var idFerramenta = inputIdFerramenta.value;
    var itensAdicionados = inputItensAdicionados.value;

    var body = document.getElementById('div_itens_adicionados');
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

    xmlhttp.open("GET", this.raiz_sistema + "painel/ferramentas/ajax_adicionar_item_ferramenta.php?itens=" + itensAdicionados + "&id_ferramenta=" + idFerramenta, true);

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

    var input_itens = document.getElementById('itens_adicionados');

    var checkbox = document.getElementById(idCheck);

    if (checkbox.checked == 1) {
        if (input_itens.value.indexOf(idItem) === -1) {
            input_itens.value += idItem + ',';
        }
    } else {
        input_itens.value = input_itens.value.replace(idItem + ',', '');
    }
}