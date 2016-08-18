<?php
require_once("inc_componente_template.php");


$id = Util::request("id");
$acao =  Util::request("acao");
$ispostback =  Util::request("ispostback");

$registro = $oConn->describleTable("componente_template");


if ( $ispostback ){	
	
	if ( $id != "" )	   
	    $registro = connAccess::fastOne($oConn, "componente_template"," id = " . $id );
	
	connAccess::preencheArrayForm($registro, $_POST, "id");
	
	$prefixo = "";
	
	         
                    $registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") );					 
		      
 $registro["nome"] = Util::request($prefixo."nome"); 
              
 $registro["descricao"] = Util::request($prefixo."descricao"); 
              
 $registro["instrucoes_uso"] = Util::request($prefixo."instrucoes_uso"); 
              
 $registro["modulos"] = Util::request($prefixo."modulos"); 
              
         
                    $registro["id_icone1"]  = Util::numeroBanco( Util::request($prefixo."id_icone1") );					 
		      
         
                    $registro["id_icone2"]  = Util::numeroBanco( Util::request($prefixo."id_icone2") );					 
		      
	
}

if ( $acao == "SAVE" ){
	  
	connAccess::nullBlankColumns( $registro );	
	 
	if (! @$registro["id"] ){
	
	     $registro["id"] = connAccess::Insert($oConn, $registro, "componente_template", "id", true);
	}else{
		  connAccess::Update($oConn, $registro, "componente_template", "id");
		}
		
		$_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
		$ispostback = "";
		
		$acao = "LOAD";
		$id = $registro["id"];
	
}

if ( $acao == "DEL" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "componente_template"," id = " . $id );
	connAccess::Delete($oConn, $registro, "componente_template", "id");
	
	$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
	
	$id = "";
    $registro = $oConn->describleTable("componente_template");
	$ispostback = "";
	
}

if ( $acao == "LOAD" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "componente_template"," id = " . $id );

}

?>
<? 
 Util::mensagemCadastro(85);
?>

<div class="row">
	<div class="col-xs-8">
		<h1 class="sistem-title">Template</h1>
		<p>Campos com * são de preenchimento obrigatório.</p>

					<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
					<div class="fieldBox">
						  
						  <input type="hidden" name="acao" value="<?php echo $acao ?>">	  
						  <input type="hidden" name="ispostback" value="1">
						  <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"]?>">  
						  <input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">
						 
					
        <? $eh_primarykey = True; 
           $visible_in_html = ' style="display:none" ';
           
           if ( $eh_primarykey && $registro["id"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id" >
				<div class="form-group">
			    	<label for="id">ID<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
        
        <input type="text"  name="id" value="<?=Util::numeroTela( $registro["id"], false) ?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["nome"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_nome" >
				<div class="form-group">
			    	<label for="nome">Template<span class="campoObrigatorio" > *</span></label>
			  		         
                                 <input type="text"  name="nome" value="<?= $registro["nome"]  ?>"   maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["descricao"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_descricao" >
				<div class="form-group">
			    	<label for="descricao">Descrição<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="descricao" value="<?= $registro["descricao"]  ?>"   maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["instrucoes_uso"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_instrucoes_uso" >
				<div class="form-group">
			    	<label for="instrucoes_uso">Instruções de Uso<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="instrucoes_uso" value="<?= $registro["instrucoes_uso"]  ?>"   maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["modulos"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_modulos" >
				<div class="form-group">
			    	<label for="modulos">Módulos<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="modulos" value="<?= $registro["modulos"]  ?>"   maxlength="">        
		      
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

	   
	    
         if (isVazio(f.nome ,'Informe Template!')){ return false; }		
		
	
	
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