<?php
require_once("../ap_padrao.php");
require_once("../library/SessionFacade.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../persist/resumo.php");
require_once("../persist/Parameters.php");
require_once("../itens_menu.php");
require_once("../inc_comboempresa.php");
require_once("inc_componente_template.php");


  $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
  
  
$acao2 = Util::request("acao2");
$id = Util::request("id");
$id_retorno = Util::request("id_retorno");
$id_item_componente = Util::request("id_item_componente");

$bl_nova_id = false;
?>

<script type="text/javascript">
  function atualizaParentInput(campo, valor){
    parent.document.getElementById(campo).value = valor; 
  }

  function atualizaParentInner(campo, valor){
    if ( parent.document.getElementById(campo) != null ){
      parent.document.getElementById(campo).innerHTML = valor;
    }
  }  
  
  </script>


<?
if ( $acao2 == "edit_item"){
    
    if ( !$id  ){
        
        //die("pauu");
                      $registro = $oConn->describleTable("custom.componente_template");
                       componente_template::carregaForm($registro);
        
                        connAccess::nullBlankColumns($registro);
                       $registro["status"] = "rascunho";
                       
                       $id  = connAccess::Insert($oConn, $registro, "custom.componente_template", "id", true);
                       $bl_nova_id = true;
    }
    //print_r( $_POST );
    if ( $id_item_componente != "" && $id != "" ){
        
                      $item = $oConn->describleTable("custom.componente_template_item");
                      $item["id_componente_template"] = $id;
                      $item["id_item_componente"] = $id_item_componente;
                      $item["status"] = "rascunho";
                       connAccess::nullBlankColumns($item);
                      $item["id"] = connAccess::Insert($oConn, $item, "custom.componente_template_item", "id", true);
                      
                      if ( $bl_nova_id ){
                          ?>
                           <script type="text/javascript">
                                      atualizaParentInput("id","<?= $id ?>");
                           </script>
                          <?
                      }
                      if ( $item["id"] && $id_retorno != ""){ 
                                    
                          $sql_item =  " select i.*, ti.id as id_item from custom.componente_template_item ti "
                                    ."  left join custom.item_componente i on i.id = ti.id_item_componente "
                                    ."  where ti.id = ".$item["id"]." order by ti.ordem ";
                          
                          $lista_itens = connAccess::fetchData($oConn, $sql_item);
                          
                          echo("<br>". $sql_item );
                          
                          $item = $lista_itens[0];
                          ?>
                           
                          <?   componente_template::mostraDragDivGrande($item); // $id_retorno
                          
                          $id_final = "div_comp_". $item["id_item"];
                          ?> 
                          <script type="text/javascript">
                                  atualizaParentInner("<?=$id_retorno?>", document.getElementById("<?= $id_final ?>").innerHTML );
                                  
                                  parent.document.getElementById("<?= $id_retorno ?>").id = "<?= $id_final ?>";
                           </script>
                          <?                         
                      }
        
        
    }
    
    
}

if ( $bl_nova_id && false ){
      ?> 
       <script type="text/javascript">
           
           atualizaParentInput("id","<?= $id?>");
       </script>
                          <?
}




  $oConn->disconnect();
?>


