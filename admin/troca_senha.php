<?php
//BootStrap
//session_start();
require_once("ap_padrao.php");
require_once("library/SessionFacade.php");
require_once("persist/IDbPersist.php");
require_once("persist/connAccess.php");
require_once("persist/MySQLConnection.php");
require_once("persist/resumo.php");
require_once("persist/Parameters.php");

$oConn = new MYSQLConnection();


if ( ! SessionFacade::usuarioLogado() ){
	die("<script>document.location.href='login.php'; </script>");
}
/* TODO: Add code here */
if ( request("lembrete") == "1" && request("nova_senha") != "" ){
	
	$user = connAccess::fastOne($oConn,$conexao_joomla["tabela_usuario"]," id = " . SessionFacade::getIdLogado());
	//echo("<br> --> ". $user["senha_admin"] . " -- ". md5( request("senha") ));
	if ( $user["senha_admin"] == md5( request("senha") ) ){
		connAccess::executeCommand($oConn," update ".$conexao_joomla["tabela_usuario"]." set senha_admin = '". 
				md5( str_replace("'","''", request("nova_senha")))."' where id  =" . 
				SessionFacade::getIdLogado());
				
				
		if ( request("debug") == "1" ){
		
			echo("<br> update usuario set ".$conexao_joomla["tabela_usuario"]." = '". 
					str_replace("'","''", request("nova_senha"))."' where id  =" . 
					SessionFacade::getIdLogado());	
			
		}
				
		
		$_SESSION["st_Mensagem"] = "Senha alterada com sucesso!";
	}else{
		
		$_SESSION["st_Mensagem"] = "Senha anterior não confere!";
		
		if ( request("debug") == "1" ){
			
			print_r ($user);	
			
		}
		
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LOGIN</title>

    <link href="fonts/styletype.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

<script src="javascript/validacampos.js" type="text/javascript"></script>
</head>

<body>
<form method="post" action="troca_senha.php" name="frm">
<center>
<?
Util::mensagemCadastro();
?>
    <div class="bs-example">
 <table style="width:550px; border: solid 1px #999999; margin-top:10px;" align="center" border="0" >

     <tr>
	    <td  colspan="2" >
	    <div class="menu_superior"  >
		 TROCA SENHA</div>		
       
		
		</td>
	 </tr>

     <tr>
	    <td >Informe senha atual </td>
		<td> <input type="password" name="senha" value="" style="width: 100px"> </td>
	  </tr>	
	    <tr>
	    <td >Informe nova senha</td>
		<td> <input type="password" name="nova_senha" value="" style="width: 100px"> </td>
	  </tr>	
	 <tr>
	    <td >Confirme nova senha</td>
		<td> <input type="password" name="nova_senha_conf" value="" style="width: 100px"> </td>
	  </tr>	
	 <tr>
	    <td  colspan="2" align="right">
	    <input type="button" class="botao" value=" Troca Senha " onclick="Troca()"  />
		<input type="hidden" name="lembrete" value="1">
		
		<input type="hidden" name="debug" value="<?=request("debug")?>">
		
		</td>
		</tr>
		</table>

    </div>
</form>
</body>
</html>
<script>
function Troca(){

   var f= document.forms[0];

    if (isVazio(f.senha,"Informe a senha atual!"))
      return false;
	
	
    if (isVazio(f.nova_senha,"Informe a nova senha!"))
      return false;
	
	
    if (isVazio(f.nova_senha_conf,"Confirme a nova senha!"))
      return false;
	
	if ( f.nova_senha.value != f.nova_senha_conf.value ){
	
	      alert("Nova senha n�o confere!");
		  return false;
	}
	
	 f.submit();
}


</script>
