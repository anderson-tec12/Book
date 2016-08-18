<? require_once("inc_protecao_usuario.php"); ?>
<?
$javascript_load = "";

$acao = Util::request("acao");
$msg = "";
if ($acao == "editar") {

	Usuario::EditPerfil($id_usuario_logado);
	$msg = "Dados de perfil editados com sucesso!";

	$_SESSION["st_Mensagem"] = $msg;
	$_SESSION["st_MensagemClass"] = "";
}
$registro = Usuario::getUser($id_usuario_logado);

$_SESSION["pagina_anterior"] = $_SERVER['SCRIPT_NAME'];
$_SESSION["parametros_pagina_anterior"] = $_REQUEST;
?>

<script src="admin/javascript/validacampos.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>

<form  method="post" name="form_editar_perfil"  >

	<input type="hidden" name="ispostback" value="1">
	<input type="hidden" name="pag" value="<?= Util::request("pag") ?>" >
	<input type="hidden" name="acao" value="">
	<input type="hidden" name="id_usuario" value="<?=$id_usuario_logado ?>">
	<input type="hidden" name="token" value="<?= Usuario::getToken($id_usuario_logado) ?>">
	<input type="hidden" name="tipo" value="<?=$tipo?>" >

	<div class="container">
		<div class="cboxIframe container12 pop_post">

			<h1>Editar Perfil</h1>
			<?
				Util::mensagemCadastro();
			?>
			<div class="column6">
				<div class="form-group">
					<label>Nome completo *</label>
					<input type="text" class="form-control" placeholder="Digite seu nome" name="nome_completo" maxlength="300" value="<?= $registro["nome_completo"] ?>">
				</div>

				<div class="form-group">
					<label>Sobre mim *</label>
					<input type="text" class="form-control" placeholder="Até 300 caracteres" 
					name="obs" maxlength="300" value="<?= $registro["obs"] ?>"
					>
				</div>

				<div class="form-group column3" style="margin-right: 40px;">
					<label>Data de Nascimento</label>
					<input type="text" class="form-control" placeholder="00/00/0000"
                                               onkeypress="return MascaraData(this, event)" maxlength="10" 
					name="data_nascimento" value="<?= Util::PgToOut(  $registro["data_nascimento"], true) ?>">
				</div>
				
				<div class="form-group column3">
					<label>Telefone</label>
					<input type="text" class="form-control" placeholder="(00) 0000-0000"
					name="telefone" maxlength="15" value="<?= $registro["telefone"] ?>" onkeypress="return MascaraTelefone(this, event)"
					>
				</div>
			</div>

			<div class="column6">
				<div class="form-group">
					<label>E-mail *</label>
					<input type="text" class="form-control" placeholder="Digite seu e-mail"
					name="email" maxlength="300" value="<?= $registro["email"] ?>"
					>
				</div>

				<div class="form-group column3" style="margin-right: 40px;">
					<label>Nova senha</label>
					<input type="password" class="form-control"  name="senha" maxlength="30" value=""  autocomplete="off">
				</div>

				<div class="form-group column3">
					<label>Confirmar senha</label>
					<input type="password" class="form-control" name="confirmar_senha"  maxlength="30" value="" autocomplete="off">
				</div>

				<div class="form-group column3" style="margin-right: 40px;">
					<label>Cidade</label>
					<input type="text" class="form-control" placeholder="Digite sua cidade" name="municipio" maxlength="300" value="<?= $registro["municipio"] ?>">
				</div>

				<div class="column3">
					<label>Estado</label>

					<?
					$sql = " select * from geral.tb_estados order by uf asc ";
					$lista = connAccess::fetchData($oConn, $sql);
					?>

					<select class="form-control" name="estado">
						<option selected="" value="">Selecione</option>
						<?php
						//$lista = connAccess::fastQuerie($oConn, "geral.tb_estados", "", " uf asc ");
						Util::CarregaComboArray($lista, "uf", "uf", $registro["uf"]);
						?>
					</select>
				</div>
			</div>

			<div class="box-add-img-profile">
				<?
				$user = $registro;
				require_once("inc_editar_perfil_imagem.php");
				?>
			</div>

			<div class="column12">
				<input type="button" class="btn" value="Salvar" onclick="fn_salvar()">
			</div>

		</div><!-- /cboxIframe -->
	</div><!-- /container -->

</form>

<script type="text/javascript">
	// Modal
	$(document).ready(function () {
		parent.$.fn.colorbox.resize( {
			innerWidth: 980,
			innerHeight: $(document).height()
		});
	});

	// Upload
	$("#file_image").change(function() {
		$(this).prev().html($(this).val());
	});

	function fn_salvar() {

		var f = document.forms[0];


		if (isVazio(f.nome_completo, "Informe seu nome!"))
			return false;


		if (isVazio(f.email, "Informe seu e-mail!"))
			return false;

		if (isVazio(f.data_nascimento, "Informe sua data de nascimento!"))
			return false;

		if (f.data_nascimento.value.length < 10 ){

			alert("Informe a data no formato: dia/mes/ano, como o exemplo: 01/08/1996 ");
			return false;
		}    


		var ar = f.data_nascimento.value.split("/");

		if (!eData(f.data_nascimento.value)) {

			alerta("", "A data de nascimento " + f.data_nascimento.value + " e inválida!. Por favor informe a data correta.");
			f.data_nascimento.focus();
			return false;
		}


		if (f.senha.value != "") {

			if (isVazio(f.confirmar_senha, "Confirme sua nova senha!"))
				return false;


			if (f.senha.value != f.confirmar_senha.value) {

				alerta("Atenção!", "Nova Senha e Confirmar Senha não são iguais!");
				return false;
			}

		}

		f.acao.value = "editar";
		f.submit();
	}
	try{
      $(function() {
        $(".temData").datepicker({ changeYear: true });
       //$( "#accordion" ).accordion();
      });
	  }catch(Exp){}
</script>