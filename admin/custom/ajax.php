<?php
require_once("../library/Util.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");
require_once("../inc_ticket.php");
require_once("../library/upload/UploadFile.php");
require_once("../library/upload/inc_arquivo.php");

require_once("inc_modulo.php");
require_once("inc_ferramenta.php");

$token = Util::request("tokken");
$id_usuario = Util::request("id_usuario");
$id_usuario_logado = Util::request("id_usuario");
$id_ticket =  Util::request("id_ticket");
$mes =  Util::request("mes");
$ano =  Util::request("ano");
$byajax =  Util::request("byajax"); //Controla se veio numa requisição ajax, ou não.
$id_ticket =  Util::request("id_ticket");
$acao  = Util::request("acao");
$acao2  = Util::request("acao2");
$id  = Util::request("id");
$id  = Util::request("id");
$id_arquivo = Util::NVL(@$_POST["id_arquivo"], Util::request("id_arquivo"));


$tipo =  Util::request("tipo");


$oConn = FactoryConn::getConn(K_CONN_TYPE);
echo($acao. " === ". count($_FILES));
if ( $acao == "upload" ){
    
      if (count($_FILES) > 0 && isset ($_FILES["file_imagem"])  && $_FILES["file_imagem"]["name"] != ""  ){
          echo("Vou finalizar a imagem.");
                        $dir = realpath("../../"). DIRECTORY_SEPARATOR . "files" . DIRECTORY_SEPARATOR. "config".DIRECTORY_SEPARATOR;
                        echo("<br>". $dir );
                        $obj_uploadPdf = new UploadFile();
                        $obj_uploadPdf->force_received_file = true;
                     
                        $obj_uploadPdf->doUploadFile($_FILES["file_imagem"], $dir); 
                        $url =  K_RAIZ_DOMINIO."files/config/".$obj_uploadPdf->getNomeArquivoSalvo();
                             echo( $url );
                             
                             $width = 0; $height = 0;
                             list($width, $height) = @getimagesize($dir . $reg_arquivo["arquivo"] );
                             
                            if ( $acao2 != "" ){
                                
                                $ar = explode("|", $acao2);
                                $nome_campo = $ar[0];
                                 
                                $prefixo_campo = explode("_", $nome_campo);
                                $id_seq_campo = explode("-", $prefixo_campo[1]);
                                
                                $nome_width = $prefixo_campo[0]."_".( ((int)$id_seq_campo[0])+3);
                                $nome_height = $prefixo_campo[0]."_".( ((int)$id_seq_campo[0])+5);
                                
                                echo("--->". $nome_width . "---". $nome_height);
                                           // 116 -> 119 e 121
                                ?>
                               <script type="text/javascript">
                                   
                                   if ( parent != null ){
                                       var campoRetorno = parent.document.getElementById("<?=$nome_campo?>");
                                       campoRetorno.value = "<?=$url?>";
                                       
                                       <? if ( $width ) { ?>
                                       var campoWidth = parent.document.getElementById("<?=$nome_width?>");
                                       if ( campoWidth != null ){
                                           campoWidth.value = "<?=$width?>";
                                       }
                                       
                                       var campoHeight = parent.document.getElementById("<?=$nome_height?>");
                                       if ( campoHeight != null ){
                                           campoHeight.value = "<?=$height?>";
                                       }
                                       <? } ?>
                                   }
                               </script>

                                <?
                                
                            }
                            
                        }
                        
    }



$oConn->disconnect();