<?
session_start();

require_once("../library/Util.php");
require_once("../oAuth/config.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");
require_once("../library/SessionFacade.php");


require_once("../persist/Parameters.php");


$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

$cod =  Util::request("cod");
$em =  Util::request("em");
$tp =  Util::request("tp");

$bol_ok = false;
$msg = "";

$url_portal = constant("url_portal");

$metadados = null;

$lnk_portal  =''; //<a href="'.$url_portal.'" target="_self">aqui</a> ';

if (  $tp == "guia_link"  && $cod != "" && $em != "" )
{
         $email = $em;
         $hash = md5("1acordo.lnk.".$email);
         
         
         if ( $hash != $cod && Util::request("bypass") == ""){
             die("Hash inválido");
         }
         
         $lista = connAccess::fetchData($oConn, "select * from arquivo where id_registro = -1 and id_tabela='geral' and lower(titulo) like '%guia%' ");
         
         //print_r( $lista );
         if ( count($lista) > 0 ){
             
             $item = $lista[0];
                //echo("Solicitando o download do arquivo: ". $item["old_nome"]);
             
               	$file  =$item["arquivo"];
               	$nome_saida  =$item["old_nome"];

                $path_file = realpath("../../"). DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR."geral". DIRECTORY_SEPARATOR. $file;
                //die("pare");
                        header("Content-Type: application/save");
                        header("Content-Length:".   filesize($path_file));
                        header('Content-Disposition: attachment; filename="' . $nome_saida . '"');
                        header("Content-Transfer-Encoding: binary");header('Expires: 0');
                        header('Pragma: no-cache');

                           $fp = fopen("$path_file", "r"); 

                           if ( fpassthru($fp) )
                            {

                            }
                            fclose($fp);  
                        exit();
             
         }

}

if (  $tp == "convite"  && $cod != "" && $em != "" )
{
    
     $ar = explode("-", $cod);
    
     $verifica = ticket::geraCodigoVerificacao(@$ar[1], $em);
     
     // die("ooi" . $verifica . " - ". $cod);
     if ( $verifica == $ar[0] ){  //Código verificador está correto, o link partiu do site possível acordo.
         
      
         //Primeiro precisamos cadastrar esse cara x em seguida associa-lo ao convite que o mesmo fora associado.
          $usuario = Usuario::getUserByEmail($oConn, $em);
         
         // print_r( $usuario );
          if ( $usuario["id"] == ""  || $usuario["senha"] == "" ){
               //Criamos o cadastro deste cidadão.
              
              
              
                $usuario["obs"] = "Primeiro cadastro realizado através de link de convite. Convite: ".$ar[1]. " de " .
                             ticket::getDadosUsuarioResponsavelTicket($oConn, $ar[1]). " no email ".$em;
                
                $usuario["codigo_verificacao"] = Usuario::getCodigoVerificacaoUser( $usuario );
                $usuario["verificado_email"] = -1; //Esta rapaz está num status é que precisa ser indicado um nome e senha.
                
                $usuario["data_cadastro"] = Util::getCurrentBDdate();
                
                if ( trim( $usuario["email"] )  == "" )
                   $usuario["email"] = $em;
                
                connAccess::nullBlankColumns($usuario);
                if ( $usuario["id"] == "" ){
                      $usuario["id"] = connAccess::Insert($oConn, $usuario, "usuario", "id", true);
                }else{
                    connAccess::Update($oConn, $usuario, "usuario", "id");
                }
                $msg = "Obrigado por aceitar o convite!|Confirme seu Nome e crie sua Senha.";
          }
          
          $tipo_convite = "convidado";
          
          //Vamos localizar o email desse cara, junto ao ticket e ver qual foi o tipo de convite que ele recebeu...
          $sql  = " select tipo from newsletter where id_ticket = " . $ar[1] . " and email_list like '%".$em."%' order by id desc ";
          $tipo_convite_localizado = connAccess::executeScalar($oConn, $sql);
          
          $sql  = " select id_usuario from newsletter where id_ticket = " . $ar[1] . " and email_list like '%".$em."%' order by id desc ";
          $id_usuario_localizado = connAccess::executeScalar($oConn, $sql);
          
          if ( $tipo_convite_localizado != ""){
              $tipo_convite = $tipo_convite_localizado;
          }
          
          $id_participante_ticket =  ticket::adicionaParticipante($oConn, @$ar[1], $usuario["id"], $tipo_convite, $id_usuario_localizado); // Esta adicionado como um convidado..
          
          
        
          if ( $usuario["verificado_email"] == 1 ){              
               $msg = "Obrigado por aceitar o convite!|Clique no botão abaixo para ir para o painel de controle.";
          }else{
              
              $usuario["verificado_email"] = -1;
              $usuario["codigo_verificacao"] = Usuario::getCodigoVerificacaoUser( $usuario );
              
                if ( trim( $usuario["email"] )  == "" )
                   $usuario["email"] = $em;
              
              connAccess::nullBlankColumns($usuario);
              connAccess::Update($oConn, $usuario,"usuario","id");
              
               $msg = "Obrigado por aceitar o convite!|Confirme seu Nome e crie sua Senha.";
          }         
          
          $metadados = array("origem"=>"convite" ,
              "id_user" => $usuario["id"],"nome"=>$usuario["nome"],
              "verificado_email" => $usuario["verificado_email"],
              "codigo_verificacao" => $usuario["codigo_verificacao"],
              "convite_id"=> $ar[1],"convidado_por"=> ticket::getDadosUsuarioResponsavel($oConn, $ar[1]), "msg"=> $msg,
              "tipo_convite"=> $tipo_convite);
          
          
          
     }else{
          $msg = "Dados inválidos!";
     }
     
    
    
}else {

    
    
                if ( $cod != "" && $em != ""){

                    $ar = explode("-", $cod);

                    if (@$ar[1] != ""){

                        $usuario = connAccess::fastOne($oConn, "usuario", " id = ". $ar[1]);

                        if (is_array($usuario) && count($usuario) > 0 ){

                            
                            if (  trim( $usuario["codigo_verificacao"]) == ""){
                                  $usuario["codigo_verificacao"] = Usuario::getCodigoVerificacaoUser( $usuario );
                            
                                  
                                        connAccess::nullBlankColumns($usuario);
                                        
                                        connAccess::Update($oConn, $usuario, "usuario", "id");
                            }
                            
                            if ( $usuario["codigo_verificacao"] == $ar[0]){

                                if (! $usuario["verificado_email"] ||  $usuario["senha"] == ""){
                                        $usuario["verificado_email"] = 1;
                                        
                                        connAccess::nullBlankColumns($usuario);
                                        
                                        connAccess::Update($oConn, $usuario, "usuario", "id");
                                        $bol_ok = true;
                                        //$msg = "Usuário validado com sucesso!. Obrigado. <br><Br>Clique ". $lnk_portal . " para acessar o portal do Possível Acordo.";
                                        
                                        $msg_padrao_confirmado = 
                                              Usuario::getMensagemPadrao("msg_cadastro_ativado_email",
                                                      "Obrigado por confirmar seu E-mail");
                                        
                                        $origem = "sucesso";
                                        $msg = "Obrigado!|Seu cadastro foi feito com sucesso. Você já pode começar a usar a plataforma 1Acordo.|Acesse sua área restrita";
                                        
                                         if ( $usuario["senha"] == "" ){                                            
                                             $msg = "Obrigado!| Seu cadastro foi feito com sucesso.<br>Você já pode começar a usar a plataforma 1Acordo, crie sua Senha:";  
                                             
                                             $origem = "sem_senha";
                                             
                                             $id_profissional = connAccess::executeScalar($oConn, " select id from profissional where id_usuario = ". 
                                                     $usuario["id"]);
                                             
                                             if ( $id_profissional != "" ){
                                                 $origem = "profissional";
                                             }
                                             
                                             
                                        }
                                        
                                        
                                            $metadados = array("origem"=>$origem ,
                                                "id_user" => $usuario["id"],"nome"=>$usuario["nome"],
                                                "verificado_email" => $usuario["verificado_email"],
                                                "codigo_verificacao" => $usuario["codigo_verificacao"],
                                                 "msg"=> $msg,"senha"=>$usuario["senha"] );

                                        
                                        
                                }else{
                                    
                                     //$msg = "Seu usuário já esta validado. Obrigado. <br><Br>Clique ". $lnk_portal . " para acessar o portal do Possível Acordo.";
                                     $msg = "Seu e-mail já esta validado!|Você já pode começar a usar a plataforma 1Acordo.|Acesse sua área restrita";
                                     
                                     $origem = "ja_validado";
                                     
                                     $metadados = array("origem"=>$origem ,
                                                "id_user" => $usuario["id"],"nome"=>$usuario["nome"],
                                                "verificado_email" => $usuario["verificado_email"],
                                                "codigo_verificacao" => $usuario["codigo_verificacao"],
                                                 "msg"=> $msg,"senha"=>$usuario["senha"] );
                                     
                                }
                            }else{
                                $msg = "Dados inválidos!";
                            }
                        }else{

                                $msg = "Dados inválidos!";
                        }

                    }else{

                                $msg = "Dados inválidos!";
                    }



                }
   
}

SessionFacade::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"], "cliente","");

$oConn->disconnect();

//die ( $msg . ",,,,,," );
if ( $msg != ""){
    
    $_SESSION["st_Mensagem"] = $msg; 
    $_SESSION["st_Mensagem02"] = $msg;     
    $_COOKIE["st_Mensagem"] = $msg;
   // SessionCliente::setMensagem($msg);
    
   // print_r(  $_SESSION["st_Mensagem"]  );
   // echo("<br>".$_SESSION["st_Mensagem"]."<br>");
   // print_r( $_SESSION  );
    if ( !is_null($metadados)){
          $_SESSION["st_MsgMetadados"] = $metadados;
    }
    session_write_close();
    
    function guidv4()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
    
    //header("Location: ../mensagem/mensagem.php");   
    //die(" ");
    die("<script>document.location.href='../../mensagem/mensagem.php?sess=".session_id()."&guid=".guidv4()."'; </script>");
}