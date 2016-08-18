<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<div id="box_user">
    <h1>
      <?= Util::NVL( $nome_usuario,"Fulano"); ?>
    </h1>
    <div class="box_img_user">
      <? if ( $id_usuario_logado ){ ?>
      <img id="current_profile_image" class="img" src="<?= $img_usuario ?>"/>
      <? } else { ?>
      <img id="current_profile_image" class="img" src="../painel/images/box_img_user.jpg"/>
      <?  } ?>
    </div>
    <a class="button_box_user button" href="painel_controle.php?pag=inc_editar_perfil">Editar Perfil</a>
</div>

</body>
</html>