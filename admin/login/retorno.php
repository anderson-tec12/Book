<?
session_start();
require_once("../library/Util.php");
require_once("../oAuth/config.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");
require_once("../library/SessionCliente.php");



require_once("../persist/Parameters.php");
require_once("../inc_profissional.php");
require_once("../painel/newsletter/mensagem_sistema/ms_cabecalho.php");
require_once("../painel/newsletter/mensagem_sistema/ms_rodape.php");


function request($key){
    
    return Util::request($key);
}


$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

//print_r(  $auth_config );
$nome_sessao = $auth_config["session_name"];
$tipo = $_SESSION[  $nome_sessao  ."_tipo" ];
$acao = request("acao");

$msg_dados = "";

 //die ( $url_final_retorno );
$url_final_retorno = @$auth_config["url_final_retorno"];

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
die( "---> ". $string );
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

if ( $acao == ""){
        if ( $_SESSION[$nome_sessao]  && $tipo != "" ){

            $obj_userSession =  $_SESSION[$nome_sessao] ;
            $email = Usuario::getEmailFromObj($obj_userSession, $tipo);
            if ( $email != "" ){

                $email = trim($email);

                $usuario = Usuario::getUserByEmail($oConn, $email);

                Usuario::setDataFromOAuth($usuario, $obj_userSession, $tipo);

                $usuario["verificado_email"] = Util::NVL( $usuario["verificado_email"] , 0 );

                
                if ( $tipo == "facebook"){
                        $usuario["nome"] = utf8_decode( $usuario["nome"] );
                        $usuario["sobrenome"] = utf8_decode( $usuario["sobrenome"] );
                        $usuario["nome_completo"] =  utf8_decode( $usuario["nome_completo"] );
                }
                

                connAccess::nullBlankColumns( $usuario);

                $verificado_email = $usuario["verificado_email"];
                $cadastrar = false;

                if (! @$usuario["id"]){///Usuário ainda não cadastrado.. vamos criar ele.

                    $usuario["id"] = connAccess::Insert( $oConn, $usuario, "usuario", "id",  true);
                    $cadastrar = true;
                }else{

                    $verificado_email = $usuario["verificado_email"];
                     connAccess::Update( $oConn, $usuario, "usuario", "id");

                    //print_r( $usuario ); die("   <<<<<  ");
                }
                
                if ( $usuario["codigo_verificacao"] == ""){
                       $usuario["codigo_verificacao"] = Usuario::getCodigoVerificacaoUser( $usuario );
                       connAccess::nullBlankColumns( $usuario);
                       connAccess::Update( $oConn, $usuario, "usuario", "id");
                
                }
                if ( $usuario["imagem"] != "" ){
                    
                    $arp = explode(":", $usuario["imagem"]);
                    
                    Usuario::adicionarListaImagem($usuario["id"], $arp[1], $arp[0], 1, "");
                }

                
                if ( ! $verificado_email ){
                    Usuario::enviaEmailVerificacao($oConn, $usuario["id"]);

                        if ( $cadastrar ){
                                 $msg_dados = "Obrigado por se cadastrar!|Um e-mail de confirmação foi enviado para " . $usuario["email"]. ", é necessário
                                               ativar a sua conta através do link enviado por e-mail.";
                                 
                                 $msg_dados = "Obrigado por se cadastrar!|Enviamos uma mensagem para seu e-mail (" . $usuario["email"]. "). Basta clicar no botão de acesso seguro que vem nesta mensagem e pronto! Você já está cadastrado e pode usar.
                                                 <br><br>Se quiser voltar para nossa página inicial, clique no botão abaixo.";
                        }else{
                                 $msg_dados = "Obrigado por se cadastrar!|Um e-mail de confirmação foi enviado para " . $usuario["email"]. ", é necessário
                                               ativar a sua conta através do link enviado por e-mail.";            
                                 
                                 
                                 $msg_dados = "Obrigado por se cadastrar!|Enviamos uma mensagem para seu e-mail (" . $usuario["email"]. "). Basta clicar no botão de acesso seguro que vem nesta mensagem e pronto! Você já está cadastrado e pode usar.
                                                 <br><br>Se quiser voltar para nossa página inicial, clique no botão abaixo.";
                        }

                }else{  // já foi cadastrado, e clicou para cá sem querer.. vamos redirecionar.

                    
                    SessionCliente::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"],"cliente",  $usuario["imagem"]);
                    
                    
                    if ( $url_final_retorno != "" ){

                          $oConn->disconnect();
                          header("Location: ". $url_final_retorno);
                    }else{

                         $msg_dados = "<div class='mensagem'> Usuário já cadastrado e verificado com sucesso! </div> ";     
                          header("Location: ../../portal/index.php");     die("");      
                    }

                }
        }else{
            
            echo("<b>ERRO:</b> Seu e-mail no ". $tipo . " não foi retornado. Isso significa que é preciso que você confirme seu e-mail no ". $tipo. " para que ele libere seu acesso.");
            die(" ");
            
            
        }
}else{
    
    
}

$oConn->disconnect();
if ( $msg_dados != ""){
    
    $_SESSION["st_Mensagem"] = $msg_dados ;
    header("Location: ../mensagem/mensagem.php"); die(" ");
}

//header("Location: ". $url_final_retorno); die(" ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta charset="UTF-8">
<title>LOGIN</title>
<style>
ul{
      
        padding-left: 0px;
        margin-left: 0px;  
        
}        
ul li{
        
        list-style: none;
        
}   
    
</style>
</head>

<body>
     <?= $msg_dados; ?>  
</body>
</html>
<? } ?>

<?


function mostraTabela( $arr ){

		echo '<table border=1>';
		
			echo '<tr>';
		foreach($arr as $key=>$valor)
			{
			echo "<th>$key</th>";
			
			}
			echo '</tr>';
		
			echo '<tr>';
		foreach($arr as $item)
			{
			echo "<td>$item</td>";
			
			echo '';
			}
			echo '</tr>';

		echo '</table>';
		

}

?>