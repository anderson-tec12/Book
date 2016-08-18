<link rel="stylesheet" href="js/leaflet/leaflet.css" />

<!-- Front Rafa e Bira -->
<div class="rangers" style="display:none">
	<span id="valBox">1</span><br>
        <input id="range" orient="vertical" value="1" type="range" min="0.25" max="2" step="0.25"
               onchange="mudaZoom(this)"
               >
</div>

<div id="canvas-mask" class="dragdealer">
	
</div><!-- /canvas-mask -->

		<div id="div_adicionar" style="width: 200px; display:none; position: absolute; background: white; text-align: right">

			<div style="text-align: right; background: #CCCCCC">
				<input type="button" style="background: white" value="x" onclick="bt_esconder(this)">
			</div>

                    
                    <input type="hidden" name="input_coord" id="input_coord" >
			<input type="text" name="add_nome" id="add_nome" placeholder="Informe o nome">
			<input type="button" name="btAdd" value="Adicionar" onclick="adicionar_registro(this)">

		</div>

<div id="div_modelo_ponto" style="display:none" >
    <!-- #ID#{gid}#ID# -->
    <div id="{id}" style="width: 500px" ><h1>{nome}</h1>
        <i>Carregando..</i> <br> <img src="img/loading.gif" >
    </div>
   
</div>
<iframe name="iframe_marcacao" id="iframe_marcacao" style="position: abolute; width: 400px; height: 200px; display: block; left: 20px; top: 20px" ></iframe>

<div id="div_pontos" style="display:none" >
<div class="handle" onmousemove="getPos(event)" ondblclick="registra(this)" onmouseout="stopTracking()"> 

		<img src="img/maps.jpg" alt="Map" class="adjust" id="draggable" >

		<div id="div_posicao"></div>


	</div><!-- /handle-->

</div>

<?
   $ls_marcacao = connAccess::fetchData($oConn, " select * from marcacao_tipo order by id asc ");
   $ls_pontos = connAccess::fetchData($oConn, " select * from marcacao order by id asc ");
?>

<script src="js/leaflet/leaflet.js"></script>
<script src="js/dragdealer.js?k=000999"></script>
<script src="js/script.js?k=0777"></script>

  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
     //http://leafletjs.com/reference.html
      
  var LeafIcon = L.Icon.extend({
    options: {
        shadowUrl: 'js/leaflet/icons/leaf-shadow.png',
        iconSize:     [38, 95],
        shadowSize:   [50, 64],
        iconAnchor:   [22, 94],
        shadowAnchor: [4, 62],
        popupAnchor:  [-3, -76]
    }
});  


  var MyIcon = L.Icon.extend({
    options: {
        //shadowUrl: 'js/leaflet/icons/leaf-shadow.png',
        iconSize:     [40, 40],
       // shadowSize:   [50, 64],
       // iconAnchor:   [22, 94],
       // shadowAnchor: [4, 62],
      //  popupAnchor:  [-3, -76]
    }
});    


var image_map = "<?=K_MAP_IMAGE?>";

var K_MAP_IMAGE_ZOOM = <?= K_MAP_IMAGE_ZOOM ?>;

if ( (screen.width - 265) > (<?=K_MAP_IMAGE_WIDTH?> * K_MAP_IMAGE_ZOOM) ){
    K_MAP_IMAGE_ZOOM = 1;
}

var image_height = String( (<?=K_MAP_IMAGE_HEIGHT ?> * K_MAP_IMAGE_ZOOM) );
var image_width =  String( (<?=K_MAP_IMAGE_WIDTH?> * K_MAP_IMAGE_ZOOM) ) ;
var Jq = null;
      
      //1594,2500
 // 1116,1750
 // 797 , 1250
		var map = L.map('canvas-mask', {
			crs: L.CRS.Simple,
                        doubleClickZoom: false
		});

		var bounds = [[0,0], [image_height , image_width]];
		var image = L.imageOverlay('img/'+ image_map, bounds).addTo(map);

                map.fitBounds(bounds);
                
//Exermplo de um ícone..
//var greenIcon = new LeafIcon({iconUrl: 'js/leaflet/icons/leaf-green.png'});

var G_HASH_LAYERS = {};

<? for ( $i = 0; $i < count($ls_marcacao); $i++ ) { 
    $item = $ls_marcacao[$i];
    
    ?>
    var icon<?=$item["id"]?> = new MyIcon({iconUrl: 'files/marcacao_tipo/<?=$item["imagem"]?>'});
    var g_layer<?=$item["id"]?> = L.layerGroup().addTo( map );
    
    G_HASH_LAYERS["<?=$item["id"]?>"] = g_layer<?=$item["id"]?>;
<? } ?>
   
var div_modelo_ponto = document.getElementById("div_modelo_ponto");

var str_modelo = div_modelo_ponto.innerHTML;
var txtPonto = "";
   
    <? for ( $i = 0; $i < count($ls_pontos); $i++ ) { 
               $item = $ls_pontos[$i];
               
               $lat = $item["leaf_lat"]; // * K_MAP_IMAGE_ZOOM;
               $lng = $item["leaf_lng"]; // * K_MAP_IMAGE_ZOOM;
               ?>
         <!-- Ponto -->
         txtPonto = str_modelo.replace("{id}","popup_map_<?= $item["id"] ?>");
         txtPonto = txtPonto.replace("{gid}","<?= $item["id"] ?>");
         txtPonto = txtPonto.replace("{nome}","<?= $item["titulo"] ?>");
         //
         
         var t_popup = L.popup( 
                 {  maxWidth: 550, maxHeight: 350  })
                    .setContent(txtPonto);
         //txtPonto
         var intlat =  parseInt( <?=$lat ?> * K_MAP_IMAGE_ZOOM);
         var intlng = parseInt( <?=$lng ?> * K_MAP_IMAGE_ZOOM);
       
         L.marker([intlat, intlng], {icon: icon<?=$item["id_tipo_marcacao"]?>}).bindPopup(t_popup).addTo(  g_layer<?= $item["id_tipo_marcacao"] ?> );
    
  <? } 
   // < ? = (int) $lat? >,< ? = (int)$lng? >
  ?>  
//L.marker([500,200 ], {icon: greenIcon}).bindPopup("Meu primeiro ícone <a href='#'>Link para algo</a>").addTo(map);
//$ls_pontos


function layer_filtro( obj , id ){
    
    var nova_classe = "icons-posts alpha";
    var opacidade = 0;
    
    if ( obj.className == "icons-posts alpha"){
        nova_classe = "icons-posts";
        opacidade = 1;
    }
   // alert( G_HASH_LAYERS[id.toString()] );
    obj.className  = nova_classe;
    
    if ( G_HASH_LAYERS[id.toString()]  != null){
        
          if ( opacidade == 0 ){
              map.removeLayer( G_HASH_LAYERS[id.toString()] );
          }else{
              if ( ! map.hasLayer( G_HASH_LAYERS[id.toString()] )){
                  map.addLayer( G_HASH_LAYERS[id.toString()] );
              }
          }
    }

    
    
}
function aviso_login(e ){
    
    alerta("É necessário estar logado para criar marcações no mapa.");
}

function onMapClick(e) {
    //alert("You clicked the map at " + e.latlng);
    //
    //alert("clicado em: " + e.originalEvent.x + " - " +  e.originalEvent.y );
    //L.marker([e.latlng.lat,e.latlng.lng ], {icon: greenIcon}).bindPopup("Criando um novo ponto na coordenada: " + 
      //       e.latlng.lat + " / " + e.latlng.lng ).addTo(map);
      
      if ( Jq == null ){
          Jq = $;
      }
      
      // registra02(e.originalEvent.x,  e.originalEvent.y - 60, e.latlng.lat, e.latlng.lng );
      Jq(document).ready(function () {
          var url = "pop_index.php?pag=criar_marcacao&lat="+e.latlng.lat.toString()+
                  "&lng="+e.latlng.lng.toString() +
                  "&eventX=" + e.originalEvent.x.toString() +
                  "&eventY=" + e.originalEvent.y.toString() + "&zoom=" + map.getZoom();
          
                  Jq.colorbox({href:url, width: 980, height:"85%", open: true, iframe: true});
      });
      
}
var currentPopup = null;

function onPopOpen(Pop) {
     //   alert(Pop);
    
    //Pop.popup.getContent()
     var HTML =  Pop.popup.getContent();
     var ID = getIDFromString(  HTML  ); 
    
    
     if ( Jq == null ){
          Jq = $;
      }
      
      // registra02(e.originalEvent.x,  e.originalEvent.y - 60, e.latlng.lat, e.latlng.lng );
      Jq(document).ready(function () {
          
                  var url = "pop_index.php?pag=criar_comentario&ID="+ID+"&retorno=popup_map_"+ ID;
          
                  Jq.colorbox({href:url, width: 980, height:"85%", open: true, iframe: true});
      });
    
    
    // var iframe_marcacao = document.getElementById("iframe_marcacao");
     
    // iframe_marcacao.src = "frame_marcacao.php?id=" + ID + "&acao=mostrar&retorno=popup_map_"+ ID;
     currentPopup = Pop.popup;
     map.closePopup(Pop.popup );
    //update() -> Método para chamar após o carregamento..
    
}

function onPopOpenWithoutLogin(Pop) {
     //   alert(Pop);
    
    //Pop.popup.getContent()
     var HTML =  Pop.popup.getContent();
     var ID = getIDFromString(  HTML  ); 
    
    
     if ( Jq == null ){
          Jq = $;
      }
          currentPopup = Pop.popup;
          rdn = Math.random().toString();
      var url = "ajax_marcacao.php?acao=ver&id="+ID+"&t="+rdn;
     var iframe_marcacao = document.getElementById("iframe_marcacao");
     
     iframe_marcacao.src = url;
     
    // alert( iframe_marcacao.src  );
    
}


function getIDFromString(txt){
    var ar = txt.split("#ID#");
    
    return ar[1];
    
    
}

<? if ( $id_usuario_logado != "" ) { ?>
//mymap.on('click', onMapClick);
map.on('dblclick', onMapClick);
map.on('popupopen', onPopOpenWithoutLogin);
<? } else { ?>


map.on('dblclick', aviso_login);
map.on('popupopen', onPopOpenWithoutLogin);
<? } ?>


//dblclick



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
 
 function registra02(  posx, posy , lat, long ){
	//posx = x;
	//posy = y;

	var add_nome = document.getElementById("add_nome");
	var div_adicionar = document.getElementById("div_adicionar");
	div_adicionar.style.top = posy.toString() + "px";
	div_adicionar.style.left = posx.toString() + "px";
	div_adicionar.style.display = "";
	add_nome.value = "";
	add_nome.focus();
        
        
	var input_coord = document.getElementById("input_coord");
        input_coord.value = lat.toString() + "|"+long.toString();
  // alert( div_adicionar.style.marginTop ); 
}

function adicionar_registro( obj ){
	var div_adicionar = document.getElementById("div_adicionar");
	var input_coord = document.getElementById("input_coord");
	div_adicionar.style.display = "none";
        var add_nome = document.getElementById("add_nome");
        var ar = input_coord.value.split("|");
        
        L.marker([ parseFloat(ar[0])  , parseFloat(ar[1]) ], {icon: greenIcon}).bindPopup( add_nome.value ).addTo(map);
      
        /*
	var div = document.createElement("div");
	div.style.top = posy.toString() + "px";
	div.style.left = posx.toString() + "px";
	div.style.position = "absolute";
	div.style.width = "40px";
	div.style.height = "40px";
	var add_nome = document.getElementById("add_nome");

	div.innerHTML = "<img src='img/bus.png' title='"+add_nome.value+"'>";
	div.style.display = "";

        document.body.appendChild(div);
          */
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
 

 
$(function() {
    $( "#draggable" ).draggable({
        
         drag: function() {
                exibePontos();
         }
    });
    //alert("deu certo? ");
  });
 */
            //    exibePontos();
 
 function abrirModalComentario(ID){
     
     
      if ( Jq == null ){
          Jq = $;
      }
      
      var rdn = Math.random().toString();
      
      // registra02(e.originalEvent.x,  e.originalEvent.y - 60, e.latlng.lat, e.latlng.lng );
      Jq(document).ready(function () {
          
                  var url = "pop_index.php?pag=criar_comentario&ID="+ID+"&retorno=popup_map_"+ ID+"&rdn="+rdn;
          
                  Jq.colorbox({href:url, width: 980, height:"85%", open: true, iframe: true});
      });
     
 }
</script>