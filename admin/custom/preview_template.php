<?php
require_once("../ap_padrao.php");
require_once("../library/ArrayList.php");
require_once("../library/SessionFacade.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php"); 
require_once("inc_componente_template_item.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<link href="<?= K_RAIZ ?>images/estilo.css?v=7" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?= K_RAIZ ?>javascript/validacampos.js?t=2"></script>
	<script type="text/javascript" src="<?= K_RAIZ ?>javascript/selectbox.js"></script>
</head>
<body>
  <?
  
  
    $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
  
  $id = Util::request("id");
  
  if ( $id != "" ){
      
      $lista = componente_template_item::getComponenteTemplate($id);
      
      if ( count($lista) > 0 ){
          
          $registro = $lista[0];
          
          $cor= $registro["cor"];
          $imagem1 = $registro["imagem01"];
          $imagem2 = $registro["imagem02"];
          
          ?>
          <h3>Ícone 1</h3>
          <div style="color: #<?=$cor?>" >
              <table>
                  <tr>
                      <td>
                          <img src="<?= K_RAIZ_DOMINIO ?>files/icons/<?= $imagem1 ?>">
                      </td>
                      <td style="color: #<?=$cor?>">
                          <?= $registro["nome"] ?>
                      </td>
                  </tr>
                  
              </table>
          
          </div>
    
    <h3>Ícone 2</h3>
          <div  >
              <table style="background: #<?=$cor?>; color: white">
                  <tr>
                      <td>
                          <img src="<?= K_RAIZ_DOMINIO ?>files/icons/<?= $imagem2 ?>">
                      </td>
                      <td style="color: white">
                          <?= $registro["nome"] ?>
                      </td>
                  </tr>
                  
              </table>
          
          </div>
          <?
          
          
          
      }
      
  }
  
  $oConn->disconnect();
  ?>
    
    
</body>
</html>