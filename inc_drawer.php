<div class="drawer-header">
  <a class="hint--right" data-hint="Protetores da Cuesta" href="#" target="blank">
		<img class="icon-livro" src="images/icon_heart.png">
	</a>
  <img class="drawer-logo" src="images/logo_atlas.png">
</div>

<section class="menu-vertical">
	<div class="user">
  <? if ( $id_usuario_logado != "" ) { ?>
		<!-- Logado -->
		<div class="icon-buttons">
			<a class="iframe-modal hint--left icon-edit" data-hint="Editar Perfil" href="pop_index.php?pag=editar_perfil"></a>
			<a class="hint--left icon-exit" data-hint="Sair" href="sair.php"></a>
		</div>
		<img class="avatar-small" src="<?= Usuario::mostraImagemUser($reg_usuario["imagem"], $reg_usuario["id"])?>">
		<h3><?= $reg_usuario["nome_completo"] ?></h3>
  <? } else { ?>
		<!-- Visitante -->
		<img class="avatar-small" src="img/user_defaut.png">
      <h3>Olá, faça seu <a class="iframe-modal-small" href="pop_index.php?pag=login">Login</a></h3>
  <? } ?>
	</div>
	<!-- Menu Left -->
	<div class="menu-left">
  <? capitulo::mostraMenu(); ?>
  <? if ( false ) { ?>
		<a href="#">
			<div class="menu-left-item menu1">
				<div class="icon"></div>
				<div class="title">Cachoeiras</div>
				<div class="description">Lorem ipsum dolor sit amet</div>
			</div>
		</a>
    <? } ?>
	</div>
</section>

<div class="developer">
	<a href="http://www.brasil.gov.br/" target="blank"><img class="financiadores" src="img/logo_governo_federal.png"></a>
	<a href="http://www.itapoty.org.br" target="blank"><img class="itapoty" src="img/itapoty.png"></a>
	<a href="http://www.zionsoftware.com.br" target="blank"><img src="img/zion.png"></a>
</div>
