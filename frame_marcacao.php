<?

session_start();

require_once("admin/library/Util.php");
require_once("admin/library/SessionFacade.php");
//require_once("admin/library/SessionCliente.php");
require_once("admin/oAuth/config.php");
require_once("admin/config.php");
require_once("admin/persist/IDbPersist.php");
require_once("admin/persist/connAccess.php");
require_once("admin/persist/FactoryConn.php");
require_once("admin/inc_usuario.php");


$oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));


$id = Util::request("id");
$acao = Util::request("acao");
$retorno = Util::request("retorno");

if ( $acao == "mostrar" && $id != "" ){ 
//die("ooi ");
    
    $registro = connAccess::fastOne($oConn,"marcacao"," id = ". $id );
?>

<div class="box-line" id="<?=$retorno?>">
    <div class="box-line" style="width: 300px; border: none">
				<div class="content-popup">
					<div class="icon-post-box"></div>
					<h3><?=$registro["titulo"]?></h3>
                                        <? if ( trim($registro["localizacao"]) != "" ) { ?>
					<h5><?=$registro["localizacao"]?></h5>
                                        <? } ?> 
                                        
                                        
                                        <? if ( trim($registro["imagem"]) != "" ) { ?>
                                           <img width="90" src="files/marcacao/<?= $registro["imagem"]?>" >
                                        <? } ?>
					<!-- Max 170 caracteres -->
					<p><?=$registro["texto"]?></p>
                                        <?
                                         $user = Usuario::getUser($registro["id_usuario"]);
                                        ?>
					<div class="user-name">
						<img class="avatar avatar-mini" src="<?= Usuario::mostraImagemUser($user["imagem"], $registro["id_usuario"])?>">
                                                <div class="name"><?=$user["nome_completo"]?> <?= Util::PgToOut($registro["data_cadastro"], true) ?></div>
					</div>
				</div>
        </div>
</div>

<script type="text/javascript">
    <? if ( $retorno != "") { ?>
    var div = document.getElementById("<?= $retorno ?>");
       
       if ( parent != null ){
           //alert( div );
           var divP = parent.document.getElementById("<?= $retorno ?>");
            
            divP.innerHTML = div.innerHTML;
            //alert( divP.innerHTML);
            if ( parent.currentPopup != undefined ){
                  //    parent.currentPopup.update();   
             }
       }
    
    <? } ?>
    
</script>  
<?

}


$oConn->disconnect();

?>