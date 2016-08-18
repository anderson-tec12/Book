<?php
/*
echo( $_SERVER['SCRIPT_NAME'] . " -- ". 
         strpos(" ".$_SERVER['SCRIPT_NAME'],"pop_index.php" ). " - " .
         SessionFacade::usuarioLogado());  */

if ( !SessionFacade::usuarioLogado() ){
    
     if ( strpos(" ".$_SERVER['SCRIPT_NAME'],"pop_index.php" )){
         die(" <script>document.location.href='pop_index.php?pag=login'; </script>");
     }
    
}


$id_usuario_logado =  SessionFacade::getIdLogado();

if ( $id_usuario_logado == "")
    $id_usuario_logado = "0";

?>
