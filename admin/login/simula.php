<?
session_start();
require_once("../config.php");
require_once("../library/Util.php");
require_once("../library/SessionFacade.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");

$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

 $acao = Util::request("acao");

  if ( $acao == "senha" ){
                           
                           $usuario["nome"] = Util::request("nome");
                           
                           if ( $usuario["nome_completo"] == "" )
                               $usuario["nome_completo"] = Util::request("nome");
                           
                           $usuario["senha"] = md5( Util::request("senha") );
                           $usuario["verificado_email"] = 1;
                           
                           if ( $usuario["origem_cadastro"] == "")
                               $usuario["origem_cadastro"] = "convite";
                           
                          
                           connAccess::nullBlankColumns($usuario);
                           connAccess::Update($oConn, $usuario, "usuario", "id");
                           
                           // print_r( $usuario ); echo("<br>");
                           // print_r( $_POST );
                           // die(" ");
                           
                           
                       }
                       if ( $acao == "login" && Util::request("email") != ""){
                           
                           $usuario = Usuario::getUserByEmail($oConn, Util::request("email"));
                           
                           $usuario["verificado_email"] = 1;
                           
                           if ( $usuario["origem_cadastro"] == "")
                               $usuario["origem_cadastro"] = "convite";
                           connAccess::nullBlankColumns($usuario);
                           connAccess::Update($oConn, $usuario, "usuario", "id");
                       }
                       
                       
                       //SessionCliente::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"],"cliente",  $usuario["imagem"]);
                       SessionFacade::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"],"cliente",  $usuario["imagem"]);
                     
                       
                       header("Location: ../../index.php" );
                       $oConn->disconnect();
                       die("redireciona");


                       $oConn->disconnect();


?>
<h1>Simular acesso</h1>
<br>
<a href="simula.php?acao=profissional">Acesso do profissional</a>
<br><br>
<a href="simula.php?acao=convite">Entrada por convite</a>