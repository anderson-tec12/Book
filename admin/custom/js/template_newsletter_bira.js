$(function () {
    $("#sortable").sortable({
        revert: true
    });
});

/*CSS dos itens do layout*/
var css_titulo = "centro titulo form-control";
var css_titulo_tres_colunas = "centro titulo pequeno";
var css_subtitulo = "centro titulo form-control input-size-90";
var css_subtitulo_tres_colunas = "centro titulo pequeno";
var css_texto_editavel = "centro texto form-control input-size-90";
var css_texto_editavel_tres_colunas = "centro pequeno form-control input-size-30";
var css_texto_fixo = "centro texto form-control";
var css_texto_fixo_tres_colunas = "centro pequeno form-control";
var css_imagem = "btn form-control input-size-90 iframe_modal";
var css_imagem_tres_colunas = "btn btn-warning btn-block iframe_modal";
var css_botao = "btn form-control input-size-90 iframe_modal";
var css_botao_tres_colunas = "btn btn-warning btn-block iframe_modal";
var css_link = "centro texto form-control input-size-90";
var css_link_tres_colunas = "centro pequeno";
var css_remove_item = "btn btn-exclude";
var css_separator = "btn btn-warning btn-block";
var css_icone_item_newsletter = "centro";

/*Length dos itens do layout*/
var length_titulo = 400;
var length_subtitulo = 400;
var length_texto_editavel = 400;
var length_texto_fixo = 400;
var length_link = 400;

var blocoSelecionado = "";
var itemSelecionado = "";
var countItemNewsletter = 0;
var countItemSortable = 0;
var id_botao_imagem_selected = null;

function adicionarItem(tipo, texto, idItemNewsletter) {

    //alert(tipo);

    var valores = [];

    if (tipo == null) {
        tipo = document.getElementById("select_item").value;
    }

    if (texto != null) {
        valores = texto.split("!#");
    }

    var local = document.getElementById("sortable");

    var div_sortable = document.createElement("DIV");
    div_sortable.setAttribute('class', 'ui-state-default');
    div_sortable.setAttribute('id', "sortable_" + this.countItemSortable);

    this.addButtonRemoveSortable(div_sortable);

    this.addInputStatusItemNewsletter(div_sortable);
    this.addInputTipoSortable(div_sortable, tipo);

    this.addInputIdItemNewsletter(div_sortable, idItemNewsletter);

    this.addIconeItemNewsletter(div_sortable, css_icone_item_newsletter, tipo);

    switch (tipo) {
        case "titulo":
            this.addTextArea(div_sortable, css_titulo, valores[0] == null || valores[0] == "" ? "Título" : valores[0], length_titulo, tipo, false);
            break;
        case "subtitulo":
            this.addTextArea(div_sortable, css_subtitulo, valores[0] == null || valores[0] == "" ? "Subtítulo" : valores[0], length_subtitulo, tipo, false);
            break;
        case "texto_editavel":
            this.addTextArea(div_sortable, css_texto_editavel, valores[0] == null || valores[0] == "" ? "Texto Editável" : valores[0], length_texto_editavel, tipo, false);
            break;
        case "texto_fixo":
            this.addTextArea(div_sortable, css_texto_fixo, valores[0] == null || valores[0] == "" ? "Texto Fixo" : valores[0], length_texto_fixo, tipo, false);
            break;
        case "link":
            this.addInputText(div_sortable, css_link, valores[0] == null || valores[0] == "" ? "Link" : valores[0], length_texto_fixo, tipo, false);
            break;
        case "imagem":
            this.addImage(div_sortable, css_imagem, valores[0] == null || valores[0] == "" ? "Selecione a Imagem" : valores[0], false);
            break;
        case "separator":
            this.addSeparator(div_sortable, css_separator);
            break;
        case "relato":
            this.addBlocoRelato(div_sortable, valores);
            break;
        case "kappa":
            this.addBlocoKappa(div_sortable, valores);
            break;
        case "objetivo":
            this.addBlocoObjetivo(div_sortable, valores);
            break;
    }

    local.appendChild(div_sortable);

    this.countItemSortable++;
}

function addInputText(local, classe, texto, length, tipo, disabled) {

    if (texto == null || texto == "") {
        texto = "Texto";
    }

    if (length == null) {
        length = 50;
    }

    var inputText = document.createElement("INPUT");
    inputText.setAttribute('type', 'text');
    inputText.setAttribute('id', "item_" + this.countItemNewsletter);
    inputText.setAttribute('name', "item_" + this.countItemNewsletter);
    inputText.setAttribute('value', texto);
    inputText.setAttribute('maxlength', length);
    inputText.setAttribute('class', classe);

    if (disabled) {
        inputText.setAttribute('disabled', true);
    }

    local.appendChild(inputText);

    addInputSortableItem(local, tipo);

    this.countItemNewsletter++;
}

function addTextArea(local, classe, texto, length, tipo, disabled) {

    var textNode;

    if (texto == null || texto == "") {
        textNode = document.createTextNode("Texto");
    } else {
        textNode = document.createTextNode(texto);
    }

    var textarea = document.createElement("TEXTAREA");
    textarea.setAttribute('class', classe);
    textarea.setAttribute('id', "item_" + this.countItemNewsletter);
    textarea.setAttribute('name', "item_" + this.countItemNewsletter);
    textarea.appendChild(textNode);
    textarea.setAttribute('maxlength', length);

    if (disabled) {
        textarea.setAttribute('disabled', true);
    }

    local.appendChild(textarea);

    addInputSortableItem(local, tipo);

    this.countItemNewsletter++;
}

function addSeparator(local, classe) {

    var inputSeparator = document.createElement("INPUT");
    inputSeparator.setAttribute('type', 'text');
    inputSeparator.setAttribute('id', "item_" + this.countItemNewsletter);
    inputSeparator.setAttribute('name', "item_" + this.countItemNewsletter);
    inputSeparator.setAttribute('value', "Separador");
    inputSeparator.setAttribute('class', classe);
    inputSeparator.setAttribute('disabled', true);

    local.appendChild(inputSeparator);

    addInputSortableItem(local, "separator");

    this.countItemNewsletter++;
}

function addIconeItemNewsletter(local, classe, tipo) {

    var nomeIcone = document.getElementById('icone_' + tipo).value;

    //alert('icone_' + tipo);

    var icone = document.createElement("IMG");
    icone.setAttribute('class', classe);
    icone.setAttribute('src', 'http://possivelacordo.com.br/files/templates/newsletter/' + nomeIcone);

    //('http://possivelacordo.com.br/files/templates/newsletter/' + nomeIcone);

    local.appendChild(icone);

}

function addImage(local, classe, texto, disabled) {

    var inputImage = document.createElement("INPUT");
    inputImage.setAttribute('type', 'text');
    inputImage.setAttribute('id', "item_" + this.countItemNewsletter);
    inputImage.setAttribute('name', "item_" + this.countItemNewsletter);
    inputImage.setAttribute('class', classe);
    inputImage.setAttribute('value', texto);
    inputImage.setAttribute('data-toggle', "modal");
    inputImage.setAttribute('data-target', "#modal_imagens");
    inputImage.setAttribute('onclick', 'setIdButtonImageSelected(id)');
    inputImage.setAttribute('readonly', true);

    if (disabled) {
        inputImage.setAttribute('disabled', true);
    }

    local.appendChild(inputImage);

    addInputSortableItem(local, "image");

    this.countItemNewsletter++;
}

function addButton(local, classe, texto, disabled) {

    var inputImage = document.createElement("INPUT");
    inputImage.setAttribute('type', 'button');
    inputImage.setAttribute('id', "item_" + this.countItemNewsletter);
    inputImage.setAttribute('name', "item_" + this.countItemNewsletter);
    inputImage.setAttribute('class', classe);
    inputImage.setAttribute('value', texto);

    if (disabled) {
        inputImage.setAttribute('disabled', true);
    }

    local.appendChild(inputImage);

    addInputSortableItem(local, "botao");

    this.countItemNewsletter++;
}

function removeSortable(idSortable) {
    var sortable = document.getElementById("sortable_" + idSortable);
    var input_status_item_newsletter = document.getElementById("status_item_newsletter" + idSortable);
    input_status_item_newsletter.value = "excluido";
    sortable.style.display = "none";
}

function addButtonRemoveSortable(local) {

    var textNode = document.createTextNode("x");

    var spanRemove = document.createElement("SPAN");
    spanRemove.setAttribute('type', 'button');
    spanRemove.setAttribute('id', "remove_" + this.countItemNewsletter);
    spanRemove.setAttribute('name', "remove_" + this.countItemNewsletter);
    spanRemove.setAttribute('class', css_remove_item);
    spanRemove.setAttribute('onclick', "removeSortable(" + this.countItemSortable + ");");

    spanRemove.appendChild(textNode);

    local.appendChild(spanRemove);
}

function addInputTipoSortable(local, tipo) {

    var input_tipo_sortable = document.createElement("INPUT");

    input_tipo_sortable.setAttribute('type', 'hidden');
    input_tipo_sortable.setAttribute('id', "tipo_sortable_" + this.countItemSortable);
    input_tipo_sortable.setAttribute('name', "tipo_sortable_" + this.countItemSortable);
    input_tipo_sortable.setAttribute('value', tipo);

    local.appendChild(input_tipo_sortable);

}

function addInputIdItemNewsletter(local, idItemNewsletter) {

    var input_id = document.createElement("INPUT");
    input_id.setAttribute('type', 'hidden');
    input_id.setAttribute('id', "id_item_newsletter" + this.countItemSortable);
    input_id.setAttribute('name', "id_item_newsletter" + this.countItemSortable);

    if (idItemNewsletter != null) {
        input_id.setAttribute('value', idItemNewsletter);
    }

    local.appendChild(input_id);

}

function addInputStatusItemNewsletter(local) {

    var input_status = document.createElement("INPUT");
    input_status.setAttribute('type', 'hidden');
    input_status.setAttribute('id', "status_item_newsletter" + this.countItemSortable);
    input_status.setAttribute('name', "status_item_newsletter" + this.countItemSortable);

    input_status.setAttribute('value', "normal");

    local.appendChild(input_status);

}

function addInputSortableItem(local) {

    var input_sortable_item = document.createElement("INPUT");
    input_sortable_item.setAttribute('type', 'hidden');
    input_sortable_item.setAttribute('id', "sortable_item_" + this.countItemNewsletter);
    input_sortable_item.setAttribute('name', "sortable_item_" + this.countItemNewsletter);

    input_sortable_item.setAttribute('value', "sortable_" + this.countItemSortable);

    local.appendChild(input_sortable_item);

}

function addBlocoRelato(local, valores) {

    addSeparator(local, css_separator);

    var table = document.createElement('TABLE');
    var tblBody = document.createElement("TBODY");

    // Adiciona 3 imagens
    var row = document.createElement("tr");

    var j = 0;

    for (var i = 0; i < 3; i++) {
        var cell = document.createElement("td");
        addImage(cell, css_imagem_tres_colunas, valores[j] == null ? "Selecione a Imagem" : valores[j], false);
        row.appendChild(cell);
        j++;
    }

    tblBody.appendChild(row);

    row = document.createElement("tr");

    // Adiciona 3 Títulos        
    for (var i = 0; i < 3; i++) {
        cell = document.createElement("td");
        addInputText(cell, css_titulo_tres_colunas, valores[j] == null ? "Título" : valores[j], length_titulo, "titulo", false);
        row.appendChild(cell);
        j++;
    }

    tblBody.appendChild(row);

    row = document.createElement("tr");

    // Adiciona 3 Textos        
    for (var i = 0; i < 3; i++) {
        cell = document.createElement("td");
        addTextArea(cell, css_texto_fixo_tres_colunas, valores[j] == null ? "Texto" : valores[j], length_texto_editavel, "texto_fixo", false);
        row.appendChild(cell);
        j++;
    }

    tblBody.appendChild(row);

    table.appendChild(tblBody);

    local.appendChild(table);
}

function addBlocoKappa(local) {

    addSeparator(local, css_separator);
    addTextArea(local, css_titulo, "Você concorda, discorda, tem alguma ressalva a fazer sobre minha iniciativa de busca uma mediação para um acordo?", "subtitulo", false);
    addTextArea(local, css_titulo, "Por favor, clique nas opções abaixo para me dizer qual sua avaliação inicial:", "texto_fixo", false);

    var table = document.createElement('TABLE');
    var tblBody = document.createElement("TBODY");

    // Adiciona 3 imagens
    var row = document.createElement("tr");

    for (var i = 0; i < 5; i++) {
        var cell = document.createElement("td");
        addImage(cell, css_imagem_tres_colunas, "imagem kappa_" + (i + 1), true);
        row.appendChild(cell);
    }

    tblBody.appendChild(row);

    table.appendChild(tblBody);

    local.appendChild(table);

}

function addBlocoObjetivo(local, values) {
    addSeparator(local, css_separator);
    addTextArea(local, css_texto_editavel, values[0] == null ? "Texto 1 do Objetivo" : values[0], length_texto_editavel, "texto_editavel", false);
    addTextArea(local, css_texto_editavel, values[1] == null ? "Texto 2 do Objetivo" : values[1], length_texto_editavel, "texto_editavel", false);
    addTextArea(local, css_texto_editavel, values[2] == null ? "Texto 3 do Objetivo" : values[2], length_texto_editavel, "texto_editavel", false);
    addInputText(local, css_texto_fixo, "Pode por favor me ajudar nesta mediação?", length_texto_fixo, "texto_fixo", true);
    addButton(local, css_botao, "Clique aqui para aceitar este convite e acessar a plataforma do Possível Acordo", true);
    addInputText(local, css_texto_fixo, "Quer ler os detalhes de meu Objetivo ao buscar um acordo?Clique aqui", length_texto_fixo, "texto_fixo", true);
}

function setIdButtonImageSelected(idButton) {
    this.id_botao_imagem_selected = idButton;
}

function updateButtonImage(name_image) {

    var buttonImageSelected = document.getElementById(this.id_botao_imagem_selected);

    if (buttonImageSelected != null) {
        buttonImageSelected.value = name_image;
    }
}

function alertButtonSelected() {
    var button = document.getElementById(this.id_botao_imagem_selected);
    var modal = document.getElementById('modal_imagens');
    button.value = "Bisa";
}





