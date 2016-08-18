<?
session_start();
require_once("../config.php");
require_once("../library/Util.php");
require_once("../library/SessionCliente.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");
require_once("../inc_ticket.php");
require_once("../library/acao_ticket/acao_ticket.php");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

$complementoUrl = "";

$ar_msg = array();

if (array_key_exists("st_Mensagem", $_SESSION) && $_SESSION["st_Mensagem"] != "") {
	$ar_msg = explode("|", $_SESSION["st_Mensagem"]);

	$_SESSION["st_Mensagem"] = "";
} else {


	$ar_msg = explode("|", SessionCliente::getMensagem());
	SessionCliente::setMensagem("");
}


$acao = Util::request("acao");
$id_user = Util::request("id_user");
$codigo_verificacao = Util::request("codigo_verificacao");
$verificado_email = Util::request("verificado_email");
$origem = Util::request("origem");
$convidado_por = Util::request("convidado_por");

//print_r( $_POST ); echo("<br><br>"); print_r( $_SESSION["st_MsgMetadados"] ) ; die(" -- ");
if ($acao != "" && $id_user != "" && $codigo_verificacao != "" && $origem != "") {



	$usuario = connAccess::fastOne($oConn, "usuario", " id =  " . $id_user);

	$codigo_teste = Usuario::getCodigoVerificacaoUser($usuario);

	$convite_id = Util::request("convite_id");

	if ($codigo_teste == $codigo_verificacao) {
		if ($acao == "senha") {

			$usuario["nome"] = Util::request("nome");

			if ($usuario["nome_completo"] == "")
				$usuario["nome_completo"] = Util::request("nome");

			$usuario["senha"] = md5(Util::request("senha"));
			$usuario["verificado_email"] = 1;

			if ($usuario["origem_cadastro"] == "")
				$usuario["origem_cadastro"] = "convite";


			connAccess::nullBlankColumns($usuario);
			connAccess::Update($oConn, $usuario, "usuario", "id");

            // print_r( $usuario ); echo("<br>");
            // print_r( $_POST );
            // die(" ");
		}
		if ($acao == "login") {

			$usuario["verificado_email"] = 1;

			if ($usuario["origem_cadastro"] == "")
				$usuario["origem_cadastro"] = "convite";
			connAccess::nullBlankColumns($usuario);
			connAccess::Update($oConn, $usuario, "usuario", "id");
		}


		SessionCliente::registraUsuario($usuario["id"], $usuario["email"], $usuario["nome_completo"], "cliente", $usuario["imagem"]);

		if ($origem == "profissional") {

			SessionCliente::setValorSessao("include", "inc_perfil_homologacao");
			SessionCliente::setMensagem("#origem:profissional|#include:inc_perfil_homologacao");
			SessionCliente::setValorSessao("include", "inc_perfil_homologacao");
			SessionCliente::setValorSessao("cnt", "1");
		}


        //::adicionaParticipante( $oConn, $convite_id, $usuario["id"], "convidado" );
		if ($convite_id != "") {
			ticket::adicionaParticipante($oConn, $convite_id, $usuario["id"], "convidado");
			SessionCliente::setValorSessao("convite_id", $convite_id);
			SessionCliente::setValorSessao("convidado_por", $convidado_por);
			SessionCliente::setValorSessao("include", "inc_convidado_primeiro_acesso_email");

			SessionCliente::setMensagem("#origem:convite|#convidado_por:" . $convidado_por . "|#include:inc_convidado_primeiro_acesso_email|#convite_id:" . $convite_id);

            $id_ticket = $convite_id; // connAccess::executeScalar($oConn," select id_ticket from survay.convite_ticket where id = " .  $convite_id);
            //Vamos registrar a falácia deste rapaz..
            acao_ticket::gravaLog($usuario["nome_completo"] . " aceitou o convite", "Convite", "Convite", "convite", $id_ticket, $usuario["id"], $id_ticket, "ticket", "Convidado por" . $convidado_por, "");

            $complementoUrl = "?pag=inc_primeiras_acoes_convidados&cnt=1";
        }

        header("Location:" . K_URL_PAINEL . $complementoUrl);
        $oConn->disconnect();
        die("redireciona");


        //Usuario::getCodigoVerificacaoUser($usuario)
    }
    $oConn->disconnect();
}


$mostraBotaoPortal = true;
$mostraBotaoPortalComLogin = false;
$mostraFormularioSenha = false;

if (is_array(@$_SESSION["st_MsgMetadados"])) {

	$arr = $_SESSION["st_MsgMetadados"];

	if ($arr["origem"] == "convite") {
		$mostraBotaoPortal = false;
		if ($arr["verificado_email"] < 1) {
			$mostraFormularioSenha = true;
		} else {
			$mostraBotaoPortalComLogin = true;
		}
	}

	if ($arr["origem"] == "sem_senha" || $arr["origem"] == "profissional") {
		$mostraBotaoPortal = false;

		if (@$arr["senha"] == "") {
			$mostraFormularioSenha = true;
		} else {
			$mostraBotaoPortalComLogin = true;
		}
	}

	if ($arr["id_user"] != "" && !$mostraFormularioSenha) {

		$my_senha = connAccess::executeScalar($oConn, " select senha from usuario where id = " . $arr["id_user"]);

        if ($my_senha == "") { //Ele não tem senha...
        	$mostraFormularioSenha = true;
        	$mostraBotaoPortalComLogin = false;
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>

	<title>Painel de Controle</title>

	<link href="/sistema/css/padrao.css" rel="stylesheet" type="text/css" media="all" />
	<link href="/sistema/mensagem/css/mensagem.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>

	<div id="campo">

		<div class="mensagem">
			<table align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="/portal" target="_top"><img class="logo_mensagem" src="../mensagem/images/logo_mensagem.png"/></a></td>
				</tr>

				<tr>
					<td><h1><?= @$ar_msg[0]; ?></h1></td>
				</tr>

				<tr>
					<td><p><?= @$ar_msg[1]; ?></p></td>
				</tr>

				<? if ($mostraBotaoPortal) { ?>
				<tr>
					<td><a class="bt_portal button" href="/portal">Portal</a></td>
				</tr>
				<? } ?>
			</table>


			<form method="post" name="frm_login_senha">
				<table align="center" border="0" cellspacing="0" cellpadding="0">
					<?
					if ($mostraBotaoPortalComLogin) {
						$arr = $_SESSION["st_MsgMetadados"];
						?>

						<tr>
							<td><a class="bt_portal button" href="#" onclick="redir_portal();">Painel de Controle</a>
								<input type="hidden" name="id_user" value="<?= $arr["id_user"] ?>" >
								<input type="hidden" name="verificado_email" value="<?= $arr["verificado_email"] ?>" >
								<input type="hidden" name="codigo_verificacao" value="<?= $arr["codigo_verificacao"] ?>" >
								<input type="hidden" name="convite_id" value="<?= @$arr["convite_id"] ?>" >
								<input type="hidden" name="acao" value="" >
								<input type="hidden" name="origem" value="<?= @$arr["origem"] ?>" >
								<input type="hidden" name="convidado_por" value="<?= @$arr["convidado_por"] ?>" >

								<script type="text/javascript">
									function redir_portal() {
										var frm = document.frm_login_senha;
										frm.acao.value = "login";
										frm.submit();
									}

								</script>

							</td>

							<? } ?>

							<?
							if ($mostraFormularioSenha) {
								$arr = $_SESSION["st_MsgMetadados"];
								?>
							</tr>

							<tr>
								<td><input type="text" placeHolder="Nome" name="nome" value="<?= $arr["nome"] ?>" class="input_text" style="margin: 20px 0 0 0;"/>
									<input type="hidden" name="id_user" value="<?= $arr["id_user"] ?>" >
									<input type="hidden" name="verificado_email" value="<?= $arr["verificado_email"] ?>" >
									<input type="hidden" name="codigo_verificacao" value="<?= $arr["codigo_verificacao"] ?>" >
									<input type="hidden" name="convite_id" value="<?= $arr["convite_id"] ?>" >
									<input type="hidden" name="origem" value="<?= $arr["origem"] ?>" >
									<input type="hidden" name="acao" value="" >
									<input type="hidden" name="convidado_por" value="<?= $arr["convidado_por"] ?>" ></td>
								</tr>
								<tr>
									<td><input type="password" placeHolder="Senha" name="senha" autocomplete="off"  class="input_text"/></td>
								</tr>
								<tr>

									<td><input type="button" class="bt_portal button" onclick="salvar_nome_senha();" value="Salvar"/>
										<script type="text/javascript">
											function salvar_nome_senha() {
												var frm = document.frm_login_senha;

												if (frm.nome.value.length < 3) {
													alert("Por favor!. Informe seu nome!");
													frm.nome.focus();
													return;
												}

												if (frm.senha.value == "") {

													alert("Por favor!. Informe sua senha!");
													frm.senha.focus();
													return;
												}

												if (frm.senha.value.length < 5) {
													alert("Sua senha é muito curta!. Deve ter pelo menos 5 caracteres!");
													frm.senha.focus();
													return;
												}

												frm.acao.value = "senha";
												frm.submit();

											}
										</script>

									</td>
								</tr>

								<? } ?>
							</table>
						</form>

					</div><!-- /mensagem -->
				</div><!-- /campo -->
				<?
				$oConn->disconnect();
				?>