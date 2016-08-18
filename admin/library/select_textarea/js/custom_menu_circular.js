//Armazena o texto selecionado
var textSelected = "";
//Armazena o elemento que possui o texto selecionado
var elementSelect = null;
//Painel de opções
var panelButton = null;

function clickAdicionar(idTemplateSelected){
         
    var f = document.forms[0];
    
    //alert( textSelected );
    f.idTemplateSelected.value = idTemplateSelected.toString();
    f.text_selected.value = textSelected;
    f.retorno.value = "drop-esquerda";
    
    var old_action = f.action;
        
    f.target="frame_menu";
    f.action="../painel/pre_analise/ajax_pre_analise_panel.php";
    f.submit();
        
    f.action = old_action;
    f.target="_self";
    
    //Esconde o panel
    hidePanel();

}

/*Função responsável por atualizar o elemento e o texto selecionado na interface gráfica*/ 
function setSelectText(idElementSelect){
    //Seta o elemento onde o texto foi selecionado
    elementSelect = document.getElementById(idElementSelect);    
    //Seta o valor selcionado na variável textSelected
    this.textSelected = this.getTextSelected(elementSelect);
    //Apresenta o Painel de Opções
    this.showPanel();
}

/*Função acionada pela seleção do texto na tela*/ 
function getTextSelected(elementSelect){
    // Obtem o indice do inicio da seleção no componente
    var start = elementSelect.selectionStart;
    //  Obtem o indice final da seleção no componente
    var finish = elementSelect.selectionEnd;
    // Obtem o texto selecionado
    return elementSelect.value.substring(start, finish);
}

/*Função responsável por esconder o painel de opções*/
function hidePanel(){
    
    //Pegando o painel de botões na tela
    panelButton = document.getElementById("menu_circular");
    //Pegando o painel de botões na tela
    mascara = document.getElementById("modal_menu_circular");
    //Esconde o painel da tela via css
    panelButton.style.display = "none";
    //Esconde a mascara
    //$('#mascara').hide();
    mascara.style.display = "none";
    
    
//$('#mascara').hide();
}

/*Função responsável por apresentar o painel de opções*/
function showPanel(){
    //Esconde painel para a atualização das coordenadas
    this.hidePanel();
    
    //distância que o scroll esta do topo
    scrollsize = document.body.scrollTop;
    
    //Pegando o painel de botões na tela
    panelButton = document.getElementById("menu_circular");
    //Pegando o painel de botões na tela
    mascara = document.getElementById("modal_menu_circular");
    
    //Apresenta o painel na tela via css
    panelButton.style.display = "block";  
    mascara.style.display = "block";  
    
}

//Ação ao clicacar na modal_menu_circular
$(document).ready(function(){
    
    $("#modal_menu_circular").click( function(){
        hidePanel();
    });

});
