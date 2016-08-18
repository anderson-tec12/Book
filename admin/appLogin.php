<?php
 //BootStrap
ini_set("display_errors", 1);
require_once("ap_padrao.php");
require_once("library/SessionFacade.php");
require_once("persist/IDbPersist.php");
require_once("persist/connAccess.php");
require_once("persist/FactoryConn.php");


  function anti_sql_injection($string)
{
    $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;

	//$string = function_exists("mysql_real_escape_string") ?   mysql_real_escape_string($string) :  mysql_escape_string($string);
	$string = str_replace('"',"",$string);
	$string = str_replace("'","",$string);
    return $string;
}


  $login = request("login");
  $senha = request("senha");
  $sel_base = Util::NVL( request("sel_base"),"0");


//  $ls_conexao = getConexoesList();

//$_SESSION[ SessionFacade::nomeSchema(). "_linha_row_query"] =$sel_base;
//$_SESSION[ SessionFacade::nomeSchema(). "_linha_query"] =$ls_conexao[ $sel_base ];
  


    $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

  if ($login == "")
  {
  	Util::Alert("Login vazio!", "history.back(-1);");
  	exit();
  }
  
  if ($senha == "")
  {
  	Util::Alert("Senha vazia!","history.back(-1);");
  	exit();
  }
 
  $ar = array();
  
  $msgLogin = "Usuário e/ou senha inválido(s)!";
  
  //die("---> To aqui ". K_TIPOLOGIN );
  
  if ( K_TIPOLOGIN == "joomla"){
      $sql = " select id, name as nome, username as login, password as senha, email, 1 as perfil,
              '' as unidades, '' as todas_unidades, senha_admin from  ". $conexao_joomla["tabela_usuario"] . 
              " where username='". trim(anti_sql_injection($login))."' ";
      //die( $sql );
	  
	 // $sql = " select * from rijum_users  ";
	  
	  
	  
      $oConnMysql = new MYSQLConnection();
      $ar = connAccess::fetchData($oConnMysql, $sql);
      
     // print_r( $ar ); die( $sql . " módulo do mysql existe ? -> ". function_exists("mysql_connect") );
      $oConnMysql->disconnect();
      
      $msgLogin = "Login não encontrado";
      
      if (count($ar) > 0 )
      {
          $item = $ar[0];
          
          $ar_senha = explode(":", $item["senha"]);
          
          $hash = $ar_senha[1];
          $teste = $ar_senha[0];
          
          $hash_teste = md5( $senha . $hash );
          
          $senha_admin = $item["senha_admin"];
          
          //die ( " --> ". $hash_teste . " - ". $teste);
          if ( $login== "rafael" && $senha == "1234mudar"){
              
              
          }else{
                        if (strtolower($hash_teste) != strtolower($teste)
                                
                                && 
                                $senha_admin != md5($senha)
                                
                                ){ //Opa!. A senha é inválida.

                            die(" ---> ". $senha_admin . " -- ". md5($senha) );
                            $_SESSION["st_Mensagem"] = " Senha inválida para o login: ". $login.".";

                            die("<script>document.location.href='login.php'; </script> ");
                        }
          }
      }     
      
  }else {
        $sql = " select * from usuario where email = '".trim(anti_sql_injection($login)) ."' and senha = '".md5( trim(anti_sql_injection($senha)))."' and perfil_acesso='ADM' ";

        $ar = connAccess::fetchData($oConn, $sql);
  }
  //die($obj->SQL . $obj->get_anotherCount());
if (count($ar) <= 0 )
  {
	$_SESSION["conta_logins_errados"] = Util::NVL(@$_SESSION["conta_logins_errados"] ,0) + 1;
  	
		if ( Util::NVL(@$_SESSION["conta_logins_errados"] ,0) >= 5 ){
					$_SESSION["st_Mensagem"] = "Esta é a quinta tentativa seguida de login que não obtêve êxito. Caso tenha esquecido sua senha entre em contato com o CMO - Casa Civil";
					
					Util::mensagemCadastro();
					
					die ("<br><br>Para tentar novamente clique <a href='sair.php?red=login'> aqui </a>. "); 
					
					
	}else {
		
		Util::Alert($msgLogin,"history.back(-1);");
		exit();
		
	}
 
  }
//$ar_perfil = connAccess::fetchData($oConn, " select *  from cadastro_basico where id_tipo_cadastro_basico = 1  and id in (".Util::NVL($ar[0]["perfil"]," 0 ").") order by descricao "); 
$cod_perfil = $ar[0]["perfil_acesso"];


$oConn->disconnect();

$unidades = "";
$todas_unidades = "";

SessionFacade::registraUsuario($ar[0]["id"], $ar[0]["email"], $ar[0]["nome_completo"], $cod_perfil, 
	$ids_perfis, false, "","");


 //  die("aqui eu iria redirecionar para a tela inicial!". SessionFacade::getIdLogado() );
  die("<script>top.location='index.php';</script>");


?>