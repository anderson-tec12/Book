
<!-- Front Alexandre "Imagem de fundo e o modelo de marcação" 
<div class="content-maps">
	<div class="popups" style="margin: 300px 0 0 600px;">
		<img class="post-fogo" src="img/icon_post_1.png">
		<span>
			<div class="content-popup">
				<img class="img-post" src="img/img.jpg">
				<h3>Ótimo lugar para passar a tarde</h3>
				<h5>Av. Cachoeira da Marta, nº 485, Botucatu, SP</h5>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit morbi id bibendum massa, vitae porta dui. Maecenas ultrices id ipsum eu fringilla, donec accumsan aliquet dui.</p>
				<a href="#" target="blank">Leia mais no Livro »</a>
				<div class="user-name">
					<img class="avatar avatar-mini" src="img/avatar.jpg">
					<div class="name">Isabelly Fernanda 22/10/2015</div>
				</div>
				<div class="icon-buttons">
					<a class="iframe-modal hint--left icon-comment" data-hint="Enviar Comentário" href=""></a>
					<a class="iframe-modal-small hint--left icon-chat" data-hint="Enviar Mensagem" href=""></a>
				</div>
			</div>
		</span>
	</div>
</div>



-->
<style>
 /* Zoom Vertical    /*  */
.rangers input[type=range]
{
    writing-mode: bt-lr; /* IE */
    -webkit-appearance: slider-vertical; /* WebKit */
    width: 8px;
    height: 175px;
    padding: 0 5px;
}
.adjust{
        width: auto;
}
</style>


<!-- Front Rafa e Bira -->
<div class="rangers">
	<span id="valBox">1</span><br>
        <input id="range" orient="vertical" value="1" type="range" min="0.25" max="2" step="0.25"
               onchange="mudaZoom(this)"
               >
</div>

<div id="canvas-mask" class="dragdealer">
	<div class="handle" onmousemove="getPos(event)" ondblclick="registra(this)" onmouseout="stopTracking()"> 

		<img src="img/maps.jpg" alt="Map" class="adjust" id="draggable" >

		<div id="div_posicao"></div>

		<div id="div_adicionar" style="width: 200px; display:none; position: absolute; background: white; text-align: right">

			<div style="text-align: right; background: #CCCCCC">
				<input type="button" style="background: white" value="x" onclick="bt_esconder(this)">
			</div>

			<input type="text" name="add_nome" id="add_nome" placeholder="Informe o nome">
			<input type="button" name="btAdd" value="Adicionar" onclick="adicionar_registro(this)">

		</div>

	</div><!-- /handle-->
</div><!-- /canvas-mask -->
<div id="div_modelo_ponto" >

      <div style="width: 60px; height: 30px; z-index: 99; position: absolute; top: {top}; left: {left}" id="{id}">
	            
				<img src="img/bus.png" >
	  
	  </div>
</div>
<div id="div_pontos" >


</div>

<script src="js/dragdealer.js?k=000999"></script>
<script src="js/script.js?k=02222"></script>

  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 var G_Pontos = new Array();
  //Left, Top, Titulo, ID, Icone.
 G_Pontos[ G_Pontos.length ] = "100;200;Meu primeiro ponto;1;general";

 
 var CurrentZoom = 1;
 
 function mudaZoom(obj){
     
      var wImg = document.querySelector('.adjust').naturalWidth;
    var rel = obj.value;
    
    var novoTamanho = parseFloat(rel) * parseFloat( wImg );
    //alert( novoTamanho );
    //$('.adjust').css('width', novoTamanho.toString()+"px");
    
     var oImg =  document.getElementById("draggable");
     
     oImg.width = novoTamanho ;
    //  oImg.style.width = novoTamanho.toString()+"px";
     alert( oImg.width + " - " + novoTamanho  );
    
 }
 
 
/*
$("#range").on("input change", function() {
    var rel = $('#valBox').text();
	
	   var actualwidth = $('.adjust').css("width");
		var wImg = document.querySelector('.adjust').naturalWidth;
		var vals = (wImg / rel)/1000;
		console.log('vals', vals);
		$('.adjust').css('zoom', vals);
		
		document.getElementById("div_posicao").innerHTML= $('.adjust').css("zoom");
		CurrentZoom = $('.adjust').css("zoom");
		console.log('Tamanhos: ', actualwidth.toString() + " - " + $('.adjust').css("width") ); 
		if ( $('.adjust').css("width") != actualwidth ){
		//alert("eu");
		exibePontos();	
		}
});
 */
 var G_START_LEFT = 265;
 var G_START_TOP = 64;
 var G_DRAG_X = 0;
 var G_DRAG_Y = 0;
 
 
 function setPositionMap(){

        var elemen = document.getElementById("draggable");
        var bodyRect = document.body.getBoundingClientRect();
    elemRect = elemen.getBoundingClientRect();
    G_START_TOP   = elemRect.top - bodyRect.top;
    G_START_LEFT   = elemRect.left - bodyRect.left;
     
}
 function exibePontos(){
          setPositionMap();
     
	  document.getElementById("div_pontos").innerHTML = "";
	      for ( var i = 0; i < G_Pontos.length; i++ ){
			  
			  var myPoint = G_Pontos[ i ].split(";");
			  
			  document.getElementById("div_pontos").innerHTML +=  criaPonto( myPoint[0], myPoint[1], myPoint[2], myPoint[3], myPoint[4] );
		  }
	 
 }
 //Tag zoom não funciona como esperado..
 function criaPonto(left, top, titulo, id, icone ){
	 
	   CurrentZoom = $('.adjust').css("zoom");
	   
	   var fatorZoom = CurrentZoom;
	   
	   var txt_modelo =   document.getElementById("div_modelo_ponto").innerHTML;
	   
	   var pos_left = G_START_LEFT + (  parseInt(left) * fatorZoom );
	   var pos_top = G_START_TOP +  (parseInt(top) * fatorZoom );
	   
	   txt_modelo = txt_modelo.replace("{id}","g_point_"+id);
	   txt_modelo = txt_modelo.replace("{left}",pos_left.toString()+"px");
	   txt_modelo = txt_modelo.replace("{top}",pos_top.toString()+"px");
	 
	  return txt_modelo;
 }
 
 /*
 var canvasMask = new Dragdealer('canvas-mask', {
  x: 0,
  // Start in the bottom-left corner
  y: 0,
  vertical: true,
  horizontal: true,
  speed: 0.2,
  loose: true,
  //requestAnimationFrame: true
   callback: function(x, y) {
       G_DRAG_X = x;
	   G_DRAG_Y = y;
	   
   },
   
   dragStopCallback: function (x, y){
	    alert( G_DRAG_Y );
   }
  
});
 
 */
 
$(function() {
    $( "#draggable" ).draggable({
        
         drag: function() {
                exibePontos();
         }
    });
    //alert("deu certo? ");
  });

                exibePontos();
 
</script>