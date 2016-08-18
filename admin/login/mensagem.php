<?
//session_start();
require_once("../config.php");
require_once("../library/Util.php");
require_once("../library/SessionCliente.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Possível Acordo</title>
<style>
ul{
      
        padding-left: 0px;
        margin-left: 0px;  
        
}        
ul li{
        
        list-style: none;
        
}   
body{
    
    
font-size: 15px;
font-weight: bold;
}
    
</style>
</head>
    <body>
        
        
<?php

 if ( SessionCliente::getMensagem() != "") {
     
     echo ( SessionCliente::getMensagem() );
     SessionCliente::setMensagem("");
 }

Util::mensagemCadastro();
?>

    </body>        
    
</html>