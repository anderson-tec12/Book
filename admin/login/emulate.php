<?

require_once("../config.php");
require_once("../ap_padrao.php");
require_once("../inc_usuario.php");


require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../library/SessionCliente.php");
require_once("../persist/Parameters.php");
require_once("../inc_usuario.php");
require_once("../inc_ticket.php");

$retorno = "retorno.php";

$caminho_raiz = realpath(".");

$tipo = request("tipo");

$acao  = request("acao");

if ( $tipo != ""){
    
    $arq = "tx_test_". $tipo.".txt";
    
    $texto = Util::lerArquivo($caminho_raiz."\\". $arq);
            
    //die($texto);
    $obj =  unserialize($texto);
    
    $_SESSION["ses_oauth_user"] = $obj;
    $_SESSION["ses_oauth_user_tipo"] = $tipo;
    
    header("Location: retorno.php");
    die("");
}

if ( $acao == "login" && request("email") != "" ){
    
    $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
      $usuario = Usuario::getUserByEmail($oConn, request("email") );
      
      if ( count($usuario) > 0 ){
          
          
                            @session_start();
                             SessionFacade::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"], "cliente",
                                     "");
								
                             $_SESSION["st_Mensagem"] = "Login realizado com sucesso!|Clique abaixo para acessar o portal do Poss&iacute;vel Acordo";
							 
			     SessionCliente::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"],"cliente", 
                                      $usuario["imagem"]);
                             
                             SessionCliente::setMensagem( "Login realizado com sucesso!|Clique abaixo para acessar o portal do Poss&iacute;vel Acordo");
                             //die("pare");
                             //header("Location: mensagem.php");
                             
                                      
         SessionCliente::setValorSessao("include","");
        SessionCliente::setMensagem(""); 
        SessionCliente::setValorSessao("ticket_id","");
                             
                             
    $oConn->disconnect();
                             die("<script>"
                                     . "if ( parent != null ) { "
                                     . "parent.document.location.href='/sistema/painel/painel_controle.php'; } else {  document.location.href='../mensagem/mensagem.php';   } </script> ");
                             
          
          
          
      }
      
    $oConn->disconnect();
    
}

if ( $acao == "email" && request("email") != ""){
    $email =  request("email");
    $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
    $usuario = Usuario::getUserByEmail($oConn, $email);
    
    Usuario::enviaEmailVerificacao($oConn, $usuario["id"]);
    
    echo("FEITO!");
    $oConn->disconnect();
}
if ( $acao == "ticket" && request("id_ticket") != ""){

    $email = request("email"); 
    
    $cod = ticket::geraCodigoVerificacao(request("id_ticket"), $email);
    
    $parametros = "?cod=".$cod."-".request("id_ticket")."&em=".$email."&tp=convite";
    
    die("<script> document.location.href='verifica.php".$parametros."'; </script> ");
}
?>