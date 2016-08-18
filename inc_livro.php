<?php

$tipo = Util::request("tipo");
$id = Util::request("id");

if ( $tipo == "capitulo" && $id != ""){
    
    capitulo::mostraCapitulo($id);
    
    
}


if ( $tipo == "pagina" && $id != ""){
    
    componente_template::mostraPagina($id);
    
}

