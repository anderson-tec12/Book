<?php
require_once("admin/library/Util.php");
require_once("admin/library/SessionFacade.php");
require_once("admin/library/SessionCliente.php");
require_once("admin/oAuth/config.php");
require_once("admin/config.php");
require_once("admin/persist/IDbPersist.php");
require_once("admin/persist/connAccess.php");
require_once("admin/persist/FactoryConn.php");
require_once("admin/inc_usuario.php");

$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));
$acao = Util::request("acao");
$id = Util::request("id");
$token = Util::request("token");

if ( $acao == "ver" && $id != "") { 
  $retorno = "popup_map_".$id;
  $registro = connAccess::fastOne($oConn,"marcacao"," id = ". $id );
  if ( count($registro) <= 0 )
    die(" ");
  $registro_tipo_marcacao  =  connAccess::fastOne($oConn,"marcacao_tipo"," id = ". $registro["id_tipo_marcacao"] );

?>

  <div id="retorno">
    <div id="<?=$retorno?>">
      
      <div class="content-popup">
        <? if ( trim($registro["imagem"]) != "" ) { ?>
        <img class="img-post" src="files/marcacao/<?= $registro["imagem"]?>">
        <? } ?>
        <h3><?=$registro["titulo"]?></h3>
        <? if ( trim($registro["localizacao"]) != "" ) { ?>
        <h5><?=$registro["localizacao"]?></h5>
        <? } ?> 
        <p><?=$registro["texto"]?></p>
        <?
          $user = Usuario::getUser($registro["id_usuario"]);
        ?>
        <? if (  trim( $registro["url_livro"] ) != "" ) { ?>
        <a href="<?=$registro["url_livro"]?>" target="blank">Leia mais no Livro »</a>
        <? } ?>
         
        <div class="user-name">
          <img class="avatar avatar-mini" src="<?= Usuario::mostraImagemUser($user["imagem"], $registro["id_usuario"])?>">
          <div class="name"><?=$user["nome_completo"]?> <?= Util::PgToOut($registro["data_cadastro"], true) ?></div>
        </div>
        <div class="icon-buttons">
            <? 
            $conta_comentario = connAccess::executeScalar($oConn,
                    " select count(*) from avaliacao_kappa where id_registro = ".$registro["id"]  . " and nome_tabela='marcacao' " );
            
            if ( SessionFacade::usuarioLogado() || $conta_comentario > 0  ) { ?>
                    <a class="iframe-modal hint--left icon-comment" onclick="abrirModalComentario('<?= $registro["id"] ?>')" data-hint="Comentários" href="#"></a>
            <? } ?>
          <!-- Os 2 abaixo é somente para logados -->
          <a class="hint--left icon-chat" data-hint="Enviar Mensagem" href=""></a>
          <a class="iframe-modal hint--left icon-edit" data-hint="Editar" href=""></a>
        </div>
      </div>

    </div>
  </div>

<script type="text/javascript">
  var div = parent.document.getElementById("<?=$retorno?>");
  div.innerHTML = document.getElementById("<?=$retorno?>").innerHTML;
  if ( parent.currentPopup != null){
    var currentPopup =   parent.currentPopup; 
    currentPopup.setContent( document.getElementById("retorno").innerHTML);
    currentPopup.update();
  }
</script>

<? } ?>