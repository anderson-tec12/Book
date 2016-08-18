<?php
require_once("inc_marcacao_tipo.php");


$id = Util::request("id");
$acao =  Util::request("acao");
$ispostback =  Util::request("ispostback");

$registro = $oConn->describleTable("marcacao_tipo");


if ( $ispostback ){
	
	
	if ( $id != "" )	   
	    $registro = connAccess::fastOne($oConn, "marcacao_tipo"," id = " . $id );
	
	connAccess::preencheArrayForm($registro, $_POST, "id");
	
	$prefixo = "";
	
	         
                    $registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") ); 	
					 
		      
 $registro["nome"] = Util::request($prefixo."nome"); 
              
 $registro["imagem"] = Util::request($prefixo."imagem"); 
              
 $registro["status"] = Util::request($prefixo."status"); 
              
	
}

if ( $acao == "SAVE" ){
	  
	connAccess::nullBlankColumns( $registro );	
	 
	if ( ! @$registro["id"] ){
	
	     $registro["id"] = connAccess::Insert($oConn, $registro, "marcacao_tipo", "id", true);
	}else{
		  connAccess::Update($oConn, $registro, "marcacao_tipo", "id");
		}
		
                
                
                
                if ( count($_FILES) > 0 && $_FILES["file_logo"]["tmp_name"] != "" ){
		
                        $arquivo = $_FILES["file_logo"];

                        if ( !file_exists(realpath("../") . DIRECTORY_SEPARATOR . "files". DIRECTORY_SEPARATOR . "marcacao_tipo")){
                            
                            mkdir(realpath("../") . DIRECTORY_SEPARATOR . "files". DIRECTORY_SEPARATOR . "marcacao_tipo");
                        }
                        
                       
                        
                        $pasta = realpath("../files/marcacao_tipo");

                        $sep = DIRECTORY_SEPARATOR;


                        move_uploaded_file( $arquivo["tmp_name"], $pasta .$sep. $registro["id"]."_". $arquivo["name"]);

                        $registro["imagem"] = $registro["id"]."_". $arquivo["name"];

                        connAccess::nullBlankColumns( $registro );	
                        connAccess::Update($oConn, $registro, "marcacao_tipo", "id");
                        ///print_r( $_FILES );die("<<<");	
                }

                
                
                
                
		$_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
		$ispostback = "";
		
		$acao = "LOAD";
		$id = $registro["id"];
	
}

if ( $acao == "DEL" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "marcacao_tipo"," id = " . $id );
	connAccess::Delete($oConn, $registro, "marcacao_tipo", "id");
	
	$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
	
	$id = "";
    $registro = $oConn->describleTable("marcacao_tipo");
	$ispostback = "";
	
}

if ( $acao == "LOAD" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "marcacao_tipo"," id = " . $id );

}

?>
<? 
 Util::mensagemCadastro(85);
?>
<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>" enctype="multipart/form-data">
<div class="row">
	<div class="col-xs-12">
		<h1 class="sistem-title">Cadastro de Categoria de Marcação</h1>
		<p>Preencha o campo abaixo para realizar o cadastro.<br>
		Campo com * é de preenchimento obrigatório.</p>
                <div class="row">
<table cellpadding="0" cellspacing="0" style="margin-left: 20px; width: 85%" >
    
	<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
				<input type="hidden" name="pag" value="<?php echo Util::request("pag") ?>" >
				<input type="hidden" name="mod" value="<?php echo Util::request("mod") ?>" >
				<input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >
	  
  
  
					<input type="hidden" name="acao" value="<?php echo $acao ?>">
					<input type="hidden" name="ispostback" value="1">
					<input type="hidden" name="id" value="<?php try{ echo $registro["id"]; } catch(Exception $exp){} ?>">
		  			<input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">
  
    
        <? $eh_primarykey = True; 
           $visible_in_html = "";
           
           if ( $eh_primarykey && $registro["id"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }
           
        ?>        
			<tr  
           <? echo ($visible_in_html); ?>
      id="tr_id" >
			    <td><div  <? if ( $registro['id'] == "" ) { ?> style='display:none' <? } ?> >
						<label for="id">ID</label> &nbsp;
				 		<span class='mostrapk'><?= $registro['id'] ?></span>
					</div>
				</td>
			
			</tr>
			
			 

        
        <? $eh_primarykey = False; 
           $visible_in_html = "";
           
           if ( $eh_primarykey && $registro["nome"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }
           
        ?>        
			<tr  
           <? echo ($visible_in_html); ?>
      id="tr_nome" >
			    <td>
                                
                                <div class="form-group">
						<label for="descricao">Nome</label>  <span class='campoObrigatorio'> *</span>	
			         	<input type="text" class="form-control" name="nome" value="<?= $registro["nome"] ?>">
                                
                                </div>
				</td>
			
			</tr>
			
		
			 

        
        <? $eh_primarykey = False; 
              $visible_in_html = " style='display:none' ";
           
           if ( $eh_primarykey && $registro["status"] == "" ) {
              $visible_in_html = " style='display:none' ";
           }
           
        ?>        
			<tr  
           <? echo ($visible_in_html); ?>
      id="tr_status" >
			    <td>status<span class="campoObrigatorio"  style="display:none" > * </span>
				    <br>
         
        
         <input type="text"  name="status" value="<?= $registro["status"]  ?>"   maxlength="">
        
		      
				</td>
			
			</tr>
                        <tr>
                            
                            <td >
		       <label>Imagem</label>
			   <? if ( trim($registro["imagem"]) != "" ){ ?>
	
	<img src="images/delete.png"  border="0" title ="Remover Imagem"  style="border:none; cursor:pointer" onclick="removeLogo(this)">
	<br>
	<img src="../files/marcacao_tipo/<?=$registro["imagem"]?>" width="120" border="0"  style="border:none" id="mylogo">
	
	
				<? } ?>
	<input type="hidden" name="imagem" value="<?= $registro["imagem"]?>" ><br>
	<input type="file" name="file_logo" style="width: 300px" >
	
	<script type="text/javascript">
	function removeLogo( obj ){
	       
		obj.style.display = "none";
		document.getElementById("mylogo").style.display = "none";
	    document.forms[0].imagem.value = "";
		
		alert("Salve o cadastro para confirmar a remoção da logo!");
	}
	
	
	</script>
				
		 </td>
                            
                        </tr>
			 
   <tr>
	  <td  align="right" >
					<!-- <div class="divMsgObrigatorio"><?php //echo constant("K_MSG_OBR")?></div> -->   
	<?php showButtons($acao,true); 
	
	$enBtGrupo = " disabled ";

	try
	{ 
	   $id = $registro["id"];
	
	   if ( $id > 0)
	      $enBtGrupo = "";
	
	} catch (Exception $exp){}
	?>  
	</td>
	</tr>
	
</table>
</div>
</div>
</div>
</form>
<div class="interMenu">
	<?php botaoVoltar("index.php?mod=listar&pag=". Util::request("pag") . "&tipo=". Util::request("tipo")  ) ?>
</div>

<script>
function salvar()
   {
      var f = document.forms[0];

	   
	   
	
	
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