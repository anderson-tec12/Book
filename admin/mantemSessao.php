<?php
session_start();
require("library/SessionFacade.php");


$_SESSION["_confirma_situacao"] = "Eu continuo online.";

$qtde = 0;

if ( @$_SESSION["_qtde_sessoes"] == ""){
    
    $_SESSION["_qtde_sessoes"] = 0;
}

$qtde =  $_SESSION["_qtde_sessoes"];
$qtde++;

if ( @$_GET["remove"] == "1"){
    SessionFacade::destroy();
}


if ( ! SessionFacade::usuarioLogado() ){
                      
                          $valor = array_keys($_COOKIE);
                            echo("<br><br>TESTE DE KEYS<pre>");print_r($valor); echo("</pre><br>Item 0:".$valor[0]."<br>");
                         //   $teste = stripslashes($valor[0]);
                            
                            //str_replace('\\"', '"', $valor[0]);
                          $ar = unserialize( stripslashes( $_COOKIE["cookie_user_prod"] ) );
                                  
                                  //unserialize($teste);
                         
                          echo("<br>array do cookies -->". $_COOKIE["cookie_user_prod"] . "-----> ".  serialize(array("nome"=>"Teste","ID"=>"Ol�"))."<br><br> --->". $teste ." <br>agora vem o array --> ");
                          print_r( $ar );                          
                         
                          if (is_array($ar)){
		                     $_SESSION[ SessionFacade::nomeSchema() ."_usSes" ] = $ar;
                          }
                        
} else {
    
           
}
echo("<br><br>Teste de Sessão recebido -> ". $qtde . " eu continuo logado? -> ". SessionFacade::usuarioLogado());
echo("<br><br>Cookies <br><pre>");
print_r($_COOKIE);
 echo("</pre><br>chaves do cookies"); print_r( array_keys($_COOKIE));
$_SESSION["_qtde_sessoes"] = $qtde;


session_write_close();
?>