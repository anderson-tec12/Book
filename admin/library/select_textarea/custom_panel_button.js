//Define a posição do cursor em x
var x = 0;
//Define a posição do cursor em y
var y = 0;
//Define a posição do scroll em z
var z = 0;
//Armazena o texto selecionado
var textSelected = "";
//Armazena o texto completo
var textComplete = "";
//Armazena o elemento que possui o texto selecionado
var elementSelect = null;
//Painel de opções
var panelButton = null;

//Ao carregar pagina executa a função loadWindow
window.onload = loadWindow;

//Função responsável por carregar eventos
function loadWindow(){
    //Adiciona evento ao rolar scroll
    window.addEventListener("scroll", hidePanel, false);
    //Adiciona evento ao movimentar mouse
    window.addEventListener("mousemove", updateCoordenadas, false);
    //Adiciona evento ao clicar
    window.addEventListener('click', mouseClick, false);
}

//Função acionada ao clicar com o mouse na tela
function mouseClick(e){
    //Carrega o texto selecionado
    this.textSelected = this.getTextSelected(elementSelect);
    //Verifica não se há texto selecionado
    if(textSelected == ""){
        //caso não haja texto selecionado esconde painel
        hidePanel();
    }
}

//Função responsavel por atualizar coordenadas da posição do mouse na tela
function updateCoordenadas(e) {
    //Verifica se o navegador é Netscape
    if (navigator.appName == 'Netscape'){
        x = e.pageX;
        y = e.pageY;  
    } else {
        x = event.clientX;
        y = event.clientY;
    }
    //Atualiza coordenada z (Posição do Scroll)
    z = (window.pageYOffset ? window.pageYOffset : document.scrollTop ? document.scrollTop : document.body.scrollTop) || 0;
    
//Imprime as coordenadas em que o mouse foi clicado
//var coor = "Coordenadas: (X: " + x + "px, Y:" + y + "px, Scroll:" + z + "px)";
//document.getElementById("mensagem").innerHTML = coor;

}

/*Função responsável por atualizar o elemento e o texto selecionado na interface gráfica*/ 
function setSelectText(idElementSelect){
    //Seta o elemento onde o texto foi selecionado
    elementSelect = document.getElementById(idElementSelect);   

    //Seta o valor selcionado na variável textSelected
    this.textSelected = this.getTextSelected(elementSelect);
    //Seta o valor na variavel textComplete
    this.textComplete = elementSelect.value.toString();
    
    
    $.ajax({
        type: 'POST',
        url: '../library/select_textarea/action.php',
        data: {
            texto: this.textComplete,
            texto_selecionado: this.textSelected,
            indice_inicial: this.indiceInicial,
            indice_final: this.indiceFinal,
            id_componente: idElementSelect
        }
    });
    
    //Apresenta o Painel de Opções
    this.showPanel();
  
}




/*Função acionada pela seleção do texto na tela*/ 
function getTextSelected(elementSelect){
    
    try{
    // Obtem o indice do inicio da seleção no componente
    var start = elementSelect.selectionStart;
    //  Obtem o indice final da seleção no componente
    var finish = elementSelect.selectionEnd;
    // Obtem o texto selecionado
    return elementSelect.value.substring(start, finish);
    
    }catch(Exp){}
}

/*Função responsável por esconder o painel de opções*/
function hidePanel(){
    //Pegando o painel de botões na tela
    panelButton = document.getElementById("customPanelButton");
    //Esconde o painel da tela via css
    panelButton.style.display = "none";
}

/*Função responsável por apresentar o painel de opções*/
function showPanel(){
    //Esconde painel para a atualização das coordenadas
    this.hidePanel();
    
    //distância que o scroll esta do topo
    scrollsize = document.body.scrollTop;
    
    //Pegando o painel de botões na tela
    panelButton = document.getElementById("customPanelButton");
    
    //Verifica o navegador do usuário
    if (navigator.appName == 'Netscape'){
        y_final = (parseInt(y - z));
    }else{
        y_final = (parseInt(y));
    }
    
    if ( elementSelect != null ){
        document.getElementById("custom_painel_link").href= document.getElementById(elementSelect.id+"_link").innerHTML;        
    }
    
    
    //Seta as coordenadas em que o painel deverá aparecer
    panelButton.style.top= y_final+"px";
    panelButton.style.left= x+"px";
    
    //Apresenta o painel na tela via css
    panelButton.style.display = "block";  
}

/*Função teste implementada para o botão 1*/
function btFalaciaClicked(){
    //Esconde painel de opções
    this.hidePanel();
      
    window.showModalDialog("pop_index.php?pag=falacias&amp;id_e=14&texto_selecionado=" + $texto);   
}

/*Função teste implementada para o botão 1*/
function bt2Clicked(){
    //Esconde painel de opções
    this.hidePanel();
    //Emite um alerta na tela com o texto selecionado
    alert("Texto Selecionado = "+this.textSelected);   
}
