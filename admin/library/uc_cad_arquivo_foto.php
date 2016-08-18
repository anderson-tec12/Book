<?php
//Componente para cadastro de foto -> Ligado a tabela arquivo.
function exibe_CadastroFoto($tabela, $id_registro, $titulo_arquivo = "", $titulo = "Logo" , $path_virtual = "anexos/", $prefixo = "", $width = "300px"){
   global $oConn;
   $filtro = "";
   
 
   
   if ( $titulo_arquivo != "")
       $filtro.= " and titulo ='".$titulo_arquivo."' ";
   
   $registro = connAccess::fastOne($oConn, "arquivo", " id_registro = ". $id_registro. " and id_tabela='".$tabela."' ". $filtro);
   
   if (!is_array($registro) ){
       
       $registro = $oConn->describleTable("arquivo");
   }
    

?>
   <label><?=$titulo?></label>
		    <? if ( trim($registro["arquivo"]) != "" ){ ?>
        <div class="col-xs-12">
          <div class="form-group">
            <img src="<?=$path_virtual?><?=$registro["arquivo"]?>" class="img-thumbnail" id="<?=$prefixo?>mylogo">
          </div>
        </div>
        <div class="col-xs-2">
          <a href="#" class="action" data-original-title="Editar" data-toggle="tooltip" data-placement="top" title ="Remover <?=$titulo?>" onclick="<?=$prefixo?>removeLogo(this)">
            <span class="icon icon-action icon-remove2 text-danger"></span>
          </a>
        </div>
        <? } ?>
        <div class="col-xs-10">
           <input type="hidden" name="<?=$prefixo?>logo" value="<?= $registro["arquivo"]?>" >
           <div class="upload-file">
            <span class="icon icon-action icon-image text-new"></span>
            <em>Selecionar imagem</em>
            <input type="file" name="<?=$prefixo?>file_logo">
           </div>
        </div>
	<script type="text/javascript">
	function <?=$prefixo?>removeLogo( obj ){
	       
		obj.style.display = "none";
		document.getElementById("<?=$prefixo?>mylogo").style.display = "none";
	        document.forms[0].<?=$prefixo?>logo.value = "";
		
		alert("Salve o cadastro para confirmar a remoção da imagem!");
	}
	
	
	</script>    
 <?   

}

function salva_CadastroFoto($tabela,$id_registro, $hashNome ="", $titulo_arquivo = "", $prefixo = "", $pasta_virtual = "anexos/"){
       global $oConn;
   $filtro = "";
   
   if ( $titulo_arquivo != "")
       $filtro.= " and titulo ='".$titulo_arquivo."' ";
   
   $registro = connAccess::fastOne($oConn, "arquivo", " id_registro = ". $id_registro. " and id_tabela='".$tabela."' ". $filtro);
   
      
   if (!is_array($registro) ){
       
       $registro = $oConn->describleTable("arquivo");
   }
   if ( count($_FILES) > 0 && $_FILES[$prefixo."file_logo"]["tmp_name"] != "" ){
		
                       $arquivo = $_FILES[$prefixo."file_logo"];

   
                        $pasta = realpath($pasta_virtual);

                        $sep = "\\";

                        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                                //echo 'This is a server using Windows!';
                        } else {
                                //echo 'This is a server not using Windows!';
                           $sep = "/";
                        }
                        $registro["arquivo"] = $id_registro."_". $hashNome. $arquivo["name"];


                        move_uploaded_file( $arquivo["tmp_name"], $pasta .$sep. $registro["arquivo"] );
                        $registro["type"] =  $arquivo["type"];
                        $registro["titulo"] =$titulo_arquivo;
                        $registro["id_tabela"] = $tabela;
                        $registro["id_registro"] = $id_registro;
                        $registro["tamanho"] =  $arquivo["size"];
                     
                        connAccess::nullBlankColumns( $registro );
                        
                        if ( $registro["id"] != ""){
                            connAccess::Update($oConn, $registro, "arquivo", "id");
                        }else{                            
                            connAccess::Insert($oConn, $registro, "arquivo", "id", true);                            
                        }
                       
                       
   }else{
       
         if ( $registro["id"] != "" && Util::request($prefixo."logo") == ""  ){          
             
             connAccess::executeCommand($oConn, " delete from arquivo where id = ". $registro["id"]);
         }
       
   }
   
}


?>
