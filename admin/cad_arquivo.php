<?php
require_once("inc_arquivo.php");


$id = Util::request("id");
$acao =  Util::request("acao");
$ispostback =  Util::request("ispostback");

$registro = $oConn->describleTable("arquivo");


if ( $ispostback ){	
	
	if ( $id != "" )	   
	    $registro = connAccess::fastOne($oConn, "arquivo"," id = " . $id );
	
	connAccess::preencheArrayForm($registro, $_POST, "id");
	
	$prefixo = "";
	
	         
                    $registro["id"]  =  Util::request($prefixo."id");					 

                $registro["arquivo"] = Util::request($prefixo."arquivo"); 
                $registro["type"] = Util::request($prefixo."type"); 
                $registro["id_tabela"] = "geral"; // Util::request($prefixo."id_tabela"); 
                $registro["titulo"] = Util::request($prefixo."titulo"); 
                //$registro["tamanho"] = Util::numeroBanco( Util::request($prefixo."tamanho") ); 	
               $registro["id_registro"]  = -1; // Util::numeroBanco( Util::request($prefixo."id_registro") );					 
                //$registro["old_nome"] = Util::request($prefixo."old_nome"); 
                //$registro["id_ticket"]  = Util::numeroBanco( Util::request($prefixo."id_ticket") );					 
		      
	
}

if ( $acao == "SAVE" ){
	  
	connAccess::nullBlankColumns( $registro );	
	 
	if (! @$registro["id"] ){
	
	     $registro["id"] = connAccess::Insert($oConn, $registro, "arquivo", "id", true);
	}else{
		  connAccess::Update($oConn, $registro, "arquivo", "id");
		}
		
                
                
		//---------------------------------------
			if ( count($_FILES) > 0 && $_FILES["file_logo"]["tmp_name"] != "" ){
				
				$arquivo = $_FILES["file_logo"];
				
                                //die ( realpath(K_VIRTUALPATH_LOGO. "anexos/banner") );
				if (! is_dir(  realpath("../files") . DIRECTORY_SEPARATOR . "geral" )){
                                        //rmdir($prefixo, $context)
                                    //die ( "---> ". realpath("../files") . DIRECTORY_SEPARATOR . "geral" );
				       mkdir( 	realpath("../files") . DIRECTORY_SEPARATOR . "geral" );
				}
				
				$pasta = realpath("../files") . DIRECTORY_SEPARATOR . "geral";
				
				$sep = DIRECTORY_SEPARATOR;
				
                                $final_name = $arquivo["name"];
                                $final_name = str_replace("ç", "c", $final_name);
                                $final_name = str_replace("Ç", "c", $final_name);
                                $final_name = Util::devolve_acentos($final_name);
                                $final_name = Util::removeAcentos($final_name);
                                $final_name = str_replace(" ", "_", $final_name);
                                $final_name = strtolower($final_name);
                                
                               // print_r( $arquivo );
                               // die($final_name . " -- ");
                               
				if (file_exists($pasta .$sep. $final_name)){
                                    
                                    unlink( $pasta .$sep. $final_name );
                                }
                                $final_file = $final_name;
				
				move_uploaded_file( $arquivo["tmp_name"], $pasta .$sep. $final_file);
				
                                //die ( $pasta .$sep. $registro["id"]."_". $arquivo["name"] );
				//$registro["imagem"] = $registro["id"]."_". $arquivo["name"];
				$registro["old_nome"] = $arquivo["name"];
				$registro["arquivo"] = $final_file;
				$registro["type"] = $arquivo["type"];
				$registro["tamanho"] = $arquivo["size"];
                                
                                
				connAccess::nullBlankColumns( $registro );	
				connAccess::Update($oConn, $registro, "arquivo", "id");
				
			}
		
                
                
                
		$_SESSION["st_Mensagem"] = "Arquivo salvo com sucesso!";
		$ispostback = "";
		
		$acao = "LOAD";
		$id = $registro["id"];
	
}

if ( $acao == "DEL" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "arquivo"," id = " . $id );
	connAccess::Delete($oConn, $registro, "arquivo", "id");
	
	$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
	
	$id = "";
    $registro = $oConn->describleTable("arquivo");
	$ispostback = "";
	
}

if ( $acao == "LOAD" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "arquivo"," id = " . $id );

}

?>
<? 
 Util::mensagemCadastro(85);
?>

<div class="row">
	<div class="col-xs-8">
		<h1 class="sistem-title">arquivo</h1>
		<p>Campos com * são de preenchimento obrigatório.</p>

					<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>" enctype="multipart/form-data">
					<div class="fieldBox">
						  
						  <input type="hidden" name="acao" value="<?php echo $acao ?>">	  
						  <input type="hidden" name="ispostback" value="1">
						  <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"]?>">  
						  <input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">
						 
					
        <? $eh_primarykey = True; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["id"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id" >
                    <div class="form-group">
                        <label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>

                        <span class='mostrapk'><?= $registro['id'] ?></span>
                        <input type="hidden"  name="id" class="form-control" value="<?= $registro["id"] ?>" 
                               maxlength="">


                    </div>
                </div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["arquivo"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_arquivo" >
				<div class="form-group">
			    	<label for="arquivo">Arquivo<span class="campoObrigatorio" > *</span></label>
                                 
                                 
                             <?    
                                 
                                 
                                 
                                    $eh_primarykey = False; 
           $visible_in_html = "";
           
           if ( $eh_primarykey && $registro["imagem"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }
           
               function guidv4()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
           
           $chave = guidv4();
        ?>        
	
			   <? if ( trim($registro["arquivo"]) != "" ){ ?>

                                        <img src="<?= K_RAIZ ?>images/delete.png"  border="0" title ="Remover Logo"  style="border:none; cursor:pointer" onclick="removeLogo(this)">
                                        <br>
                                        <a href="../../files/geral/<?=$registro["arquivo"]?>?t=<?=$chave?>" target="_blank" id="mylogo"> <?=$registro["old_nome"]?> </a>
                                    
                                                                <? } ?>
                                        <input type="hidden" name="arquivo" value="<?= $registro["arquivo"]?>" ><br>
                                        <input type="file" name="file_logo" style="width: 300px" >

                                        <script type="text/javascript">
                                        function removeLogo( obj ){

                                                obj.style.display = "none";
                                                document.getElementById("mylogo").style.display = "none";
                                                 document.forms[0].arquivo.value = "";

                                                alert("Salve o cadastro para confirmar a remoção do arquivo!");
                                        }


                                        </script>
				
		    
                                 
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
              $visible_in_html = " style='display:none' ";
           
           if ( $eh_primarykey && $registro["type"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_type" >
				<div class="form-group">
			    	<label for="type">Tipo/Mime<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="type" value="<?= $registro["type"]  ?>"  class="form-control" maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
              $visible_in_html = " style='display:none' ";
           
           if ( $eh_primarykey && $registro["id_tabela"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id_tabela" >
				<div class="form-group">
			    	<label for="id_tabela">Tabela<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="id_tabela" value="<?= $registro["id_tabela"]  ?>"  class="form-control" maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["titulo"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_titulo" >
				<div class="form-group">
			    	<label for="titulo">Título/Legenda<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="titulo" value="<?= $registro["titulo"]  ?>"  class="form-control" maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
              $visible_in_html = " style='display:none' ";
           
           if ( $eh_primarykey && $registro["tamanho"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_tamanho" >
				<div class="form-group">
			    	<label for="tamanho">Tamanho<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
        
        <input type="text"  name="tamanho" value="<?=Util::numeroTela( $registro["tamanho"], false) ?>" onkeypress=" return Numerico(event)" 
                     class="form-control" maxlength="">
					 
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
              $visible_in_html = " style='display:none' ";
           
           if ( $eh_primarykey && $registro["id_registro"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id_registro" >
				<div class="form-group">
			    	<label for="id_registro">ID Registro<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
        
        <input type="text"  name="id_registro" class="form-control" value="<?=Util::numeroTela( $registro["id_registro"], false) ?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = ' style="display:none" ';
           
           if ( $eh_primarykey && $registro["old_nome"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_old_nome" >
				<div class="form-group">
			    	<label for="old_nome">old_nome<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="old_nome" value="<?= $registro["old_nome"]  ?>"  class="form-control" maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = ' style="display:none" ';
           
           if ( $eh_primarykey && $registro["id_ticket"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id_ticket" >
				<div class="form-group">
			    	<label for="id_ticket">id_ticket<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
        
        <input type="text"  name="id_ticket" class="form-control" value="<?=Util::numeroTela( $registro["id_ticket"], false) ?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      
				</div>
			</div>
			 

					<!-- <div class="divMsgObrigatorio"><?php //echo constant("K_MSG_OBR")?></div> -->    
								<?php showButtons($acao, true); 
									$enBtGrupo = " disabled ";
									try{ 
									   $id = $registro["id"];
									   if ( $id > 0)
										  $enBtGrupo = "";
									
									} catch (Exception $exp){}
								?>
					 </div><!-- End fieldBox -->
     
                    </form>
<div class="interMenu">
	<?php botaoVoltar("index.php?mod=listar&pag=". Util::request("pag") . "&tipo=". Util::request("tipo")  ) ?>
</div>
</div>
</div>
<script>
function salvar()
   {
      var f = document.forms[0];

	   
	    if ( f.arquivo.value == "" && f.file_logo.value == "" ){
                
                alerta("Informe o arquivo!");
                return false;
                
            }
        // if (isVazio(f.arquivo ,'Informe Arquivo!')){ return false; }		
		
	
	
	  f.acao.value = "<?php echo (  Util::$SAVE) ?>";
   	  f.submit();
   }
   

   function novo()
   {
   	    
      var f = document.forms[0];
   	  document.location = f.action;
	
   	
   }
	
   function excluir()
   {
   	
   	  var f =   document.forms[0];
   	  
   	   
   	  if (f.id.value == "")
   	  {
   	      alert("Selecione um registro para excluir!");
   	      return;
   	  }
   	  
	  
	  f.acao.value = "<?php echo Util::$DEL?>";
   	  f.submit();
   }
</script>