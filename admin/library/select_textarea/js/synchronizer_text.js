//Variavel que armazena o texto absoluto
var texto = "";
//Variavel que armazena indice da pré analise
var id = 1;
//Array que armazena as pré analises inseridas
var listPreAnalise = [];
//Variavel que armazena a ultima posição do cursor
var oldPosCursor = 0;
//Variavel que armazena o textarea principal
var textAreaPrincipal = null;

//Função responsável por carregar o texto inicial e o textarea principal
function loadText(idTextArea){
    this.textAreaPrincipal = document.getElementById(idTextArea);
    this.texto = this.textAreaPrincipal.value;
}

function addSynchronizerSelectText(idPreAnalise, start, textSize, textSelected){
    
    //Variável que armazenará o final da seleção do texto
    var finish;
    
    //Verifica se o valor inicial foi passado por parametro
    if(start == null){
        // Obtem o indice do inicio da seleção no componente
        start = this.textAreaPrincipal.selectionStart;
        
        //  Obtem o indice final da seleção no componente
        finish = this.textAreaPrincipal.selectionEnd;
    }
    
    //Verifica se o tamano do texto foi passado por parametro
    if(textSize == null){
        //  Obtem o tamanho do texto selecionado
        textSize = finish - start;
    }
    
    if(textSelected == null){
        // Obtem o texto selecionado
        textSelected = this.textAreaPrincipal.value.substring(start, finish);
    }
    
    //Textarea a ser adicionado
    var textareaChildren = document.getElementById("relato_editar_"+idPreAnalise);
    
    //Cria nova Pré Analise
    var preAnalise = new PreAnalise(idPreAnalise, textSelected, start, textSize, textareaChildren);
    
    //Adiciona Pré Analise na Lista
    this.listPreAnalise[id] = preAnalise;    
    
    //incrementa o id
    id++;  
}

function preAnaliseFocusLost(idPreAnalise){
    
    //Pega o text area de preanalise com foco atual
    var textareaChildren = document.getElementById("relato_editar_"+idPreAnalise);
    
    //Verifica se a pré analise está vazia
    if(textareaChildren.value != ""){
    
        //Variavel que armazena a pré analise que esta sendo alterada
        var preAnaliseAtual = this.findRegistroById(idPreAnalise);    
        
        if(preAnaliseAtual != null){
        
            //Variavel que armazena o tamanho do texto anterior
            var oldSize = preAnaliseAtual.getSize();
    
            //Variavel que armazena o novo tamanho do texto
            var newSize = textareaChildren.value.length;
    
            //Variavel que armazena a quantidade de posições percorridas pelo cursor
            var differenceSize = parseInt(newSize - oldSize);
    
            //Atualiza o indice de todas as pré analises
            for (i = 1; i < this.listPreAnalise.length; i++) { 
        
                preAnaliseAux = this.listPreAnalise[i];
        
                if(preAnaliseAtual != preAnaliseAux){
                    if(preAnaliseAux.getStart() > preAnaliseAtual.getStart()){
                        preAnaliseAux.setStart(preAnaliseAux.getStart() + differenceSize);
                    }else if(preAnaliseAux.getStart() + preAnaliseAux.getSize() > preAnaliseAtual.getStart()){
                        preAnaliseAux.setSize(preAnaliseAux.getSize() + differenceSize);
                    }
        
                }
            }
    
            //alert(preAnaliseAux.getSize() - differenceSize);
            this.texto = this.texto.substr(0, preAnaliseAtual.getStart())+this.texto.substr(preAnaliseAtual.getStart()+oldSize, this.texto.length);
    
            //Seta novo valor na preanalise
            preAnaliseAtual.setText(textareaChildren.value);
    
            //Seta o novo tamanho na pré analise atual
            preAnaliseAtual.setSize(newSize);
    
            //Atualiza o texto base
            this.texto = this.texto.substr(0, preAnaliseAtual.getStart()) + preAnaliseAtual.getText() + this.texto.substr(preAnaliseAtual.getStart(), this.texto.length);    
    
            //Atualiza o conteúdo do text area principal
            this.textAreaPrincipal.value = this.texto;
        
            //Atualiza o conteúdo das pré analises
            updatePreAnalises();
        }
    
    }else{
        alert("Digite alguma coisa");
        textareaChildren.focus();
    }
}


//Função responsável por buscar a pré analise pelo id
function findRegistroById(id){
    for (i = 1; i < this.listPreAnalise.length; i++) { 
        if(this.listPreAnalise[i].getId() == id){
            return this.listPreAnalise[i];
        }
    }
}


function pressTextArea(event){
    
    //Variavel que armazena a posição nova do cursor
    var posCursor = this.textAreaPrincipal.selectionStart;
    
    //Variavel que armazena a quantidade de posições percorridas pelo cursor
    var difference = posCursor - this.oldPosCursor;
 
    //Variavel que armazenará a tecla pressionada
    var keyPress;
    
    //Resgata a tecla pressionada
    if (navigator.appName == 'Netscape'){
        keyPress = event.which;
    }else{
        keyPress = event.keyCode;
    }  
    
    //Verifica se deve atualizar os indices de acordo com a tecla pressionada
    if(isKeyUpdateIndices(keyPress)){
        
        //Atualiza os indices das pré analises
        for (i = 1; i < this.listPreAnalise.length; i++) { 
            
            preAnaliseAux = this.listPreAnalise[i];
            
            if(preAnaliseAux.getStart() == 0 && oldPosCursor === 0){
                preAnaliseAux.setSize(preAnaliseAux.getSize() + difference);
            }else if(preAnaliseAux.getStart() >= this.oldPosCursor){
                preAnaliseAux.setStart(preAnaliseAux.getStart() + difference);
            }else if(preAnaliseAux.getStart() + preAnaliseAux.getSize() >= this.oldPosCursor){
                preAnaliseAux.setSize(preAnaliseAux.getSize() + difference);
            }
            
        }
    }
    
    //Atualiza a posição do cursor
    this.oldPosCursor = posCursor;
    
    //Atualiza o conteúdo das pré analises
    this.updatePreAnalises();
    
}

//Função responsavel por verificar se os indices devem ser atualizados pela tecla pressionada
function isKeyUpdateIndices(keycode){
    if(keycode >=37 && keycode<=40 ){
        return false;
    }
    return true;
}

//Função responsável por atualizar a posição do cursor no textarea principal
function clickTextArea(){
    this.oldPosCursor = this.textAreaPrincipal.selectionStart;
}

//Função responsável por atualizar todas as pré analises na tela
function updatePreAnalises(){
    
    this.texto = this.textAreaPrincipal.value;
    
    for (i = 1; i < this.listPreAnalise.length; i++) { 
        preAnaliseAux = this.listPreAnalise[i];
        
        campo_editar = document.getElementById("relato_editar_"+preAnaliseAux.getId());
        campo_size = document.getElementById("relato_size_"+preAnaliseAux.getId());
        campo_start = document.getElementById("relato_start_"+preAnaliseAux.getId());
        
        campo_editar.value = this.texto.substr(preAnaliseAux.getStart(), preAnaliseAux.getSize());
        campo_size.value = preAnaliseAux.getSize();
        campo_start.value = preAnaliseAux.getStart();
    }
}

/*--------------------------------PRE ANALISE---------------------------------*/

function PreAnalise(id, text, start, textSize, element){
    this.id = id;
    this.text = text;
    this.start = start;
    this.textSize = textSize;
    this.element = element;
}

//Método responsável retornar o indice inicial da pré analise(onde começar no texto principal)
PreAnalise.prototype.getStart = function(){
    return this.start;
}

//Método responsável atualizar o valor para start
PreAnalise.prototype.setStart = function(start){
    this.start = start;
}

//Método responsável retornar o id 
PreAnalise.prototype.getId = function(){
    return this.id;
}

//Método responsável retornar o tamanho
PreAnalise.prototype.getSize = function(){
    return this.textSize;
}


//Método responsável atualizar o valor para tamanho
PreAnalise.prototype.setSize = function(size){
    this.textSize = size;
}

//Método responsável retornar o texto
PreAnalise.prototype.getText = function(){
    return this.text;
}

//Método responsável atualizar o valor para texto
PreAnalise.prototype.setText = function(text){
    this.text = text;
}


//Método responsável por atualizar inicio com inicio + 1 
PreAnalise.prototype.startIncrement = function(){
    this.start++;
}

//Método responsável por atualizar inicio com inicio - 1 
PreAnalise.prototype.startDecrement = function(){
    this.start--;
}


//Método responsável por atualizar tamanho do texto com tamanho + 1 
PreAnalise.prototype.textSizeIncrement = function(){
    this.textSize++;
}

//Método responsável por atualizar tamanho do texto com tamanho - 1 
PreAnalise.prototype.textSizeDecrement = function(){
    this.textSize--;
}

//Método responsável por atualizar texto
PreAnalise.prototype.updateText = function(text){
    this.text = text;
}
/*----------------------------------------------------------------------------*/