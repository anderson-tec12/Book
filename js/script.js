$("#range").mousemove( function(e){
	$("#valBox").html($(this).val());
});

$("#range").change( function(e){
	$("#valBox").html($(this).val());
});



// $("#range").change( function(e){
// 	var lupa = 2; 
// 	lupa / fator_lupa + 'px';
// 	$("#valBox").html($(this).val());
// 	$('img.adjust').css('zoom':);
// });

// var entidade = document.querySelector('.adjust');
// // Altere o número para a apliação/redução desejada
// var fator_lupa = 2;
// entidade.onmouseover = function () { this.style.width = (this.clientWidth * fator_lupa) + "px"; };
// entidade.onmouseout = function () { this.style.width = (this.clientWidth / fator_lupa) + "px"; }




// Bind event on the wrapper element to prevent it when a drag has been made
// between mousedown and mouseup (by stopping propagation from handle)
$('#canvas-mask').on('click', '.menu a', function(e) {
	e.preventDefault();
	var anchor = $(e.currentTarget);
	canvasMask.setValue(anchor.data('x'), anchor.data('y'));
});



var x, y;
var posx, posy;

function getPos(e){
	var doc = document.documentElement;

	x=e.clientX;
	y=e.clientY + (window.pageYOffset || doc.scrollTop);
	var cursor="Your Mouse Position Is : " + x + " and " + y ;
	document.getElementById("div_posicao").innerHTML=cursor
}

function stopTracking(){
	document.getElementById("div_posicao").innerHTML="";
}

function registra( obj ){
	posx = x;
	posy = y;

	var add_nome = document.getElementById("add_nome");
	var div_adicionar = document.getElementById("div_adicionar");
	div_adicionar.style.top = posy.toString() + "px";
	div_adicionar.style.left = posx.toString() + "px";
	div_adicionar.style.display = "";
	add_nome.value = "";
	add_nome.focus();
  // alert( div_adicionar.style.marginTop ); 
}



 function bt_esconder(obj ){
 	var div_adicionar = document.getElementById("div_adicionar");
 	div_adicionar.style.display = "none";

 }
