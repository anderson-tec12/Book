<?php
	require_once("inc_usuario.php");
	$id = Util::request("id");
	$acao =  Util::request("acao");
	$ispostback =  Util::request("ispostback");
	$registro = $oConn->describleTable("usuario");

	if ( $ispostback ){
		if ( $id != "" )	   
	    	$registro = connAccess::fastOne($oConn, "usuario"," id = " . $id );
			connAccess::preencheArrayForm($registro, $_POST, "id");
			$prefixo = "";
                $registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") ); 				 
                $registro["nome"] = Util::request($prefixo."nome"); 
                $registro["sobrenome"] = Util::request($prefixo."sobrenome"); 
                $registro["nome_completo"] = Util::request($prefixo."nome")." ".Util::request($prefixo."sobrenome") ;
                $registro["data_cadastro"] = Util::dataPg( Util::request($prefixo."data_cadastro") );               
                $registro["email"] = Util::request($prefixo."email"); 
                $registro["email2"] = Util::request($prefixo."email2"); 
                $registro["imagem"] = Util::request($prefixo."imagem"); 
                $registro["identificacao_facebook"] = Util::request($prefixo."identificacao_facebook"); 
                $registro["identificacao_twitter"] = Util::request($prefixo."identificacao_twitter"); 
                $registro["identificacao_microsoft"] = Util::request($prefixo."identificacao_microsoft"); 
                $registro["identificacao_google"] = Util::request($prefixo."identificacao_google"); 
                $registro["cpf"] = Util::request($prefixo."cpf"); 
                $registro["rg"] = Util::request($prefixo."rg"); 
                $registro["telefone"] = Util::request($prefixo."telefone"); 
                $registro["telefone2"] = Util::request($prefixo."telefone2"); 
                $registro["verificado_email"]  = Util::numeroBanco( Util::request($prefixo."verificado_email") ); 	
                $registro["verificado_senha"]  = Util::numeroBanco( Util::request($prefixo."verificado_senha") ); 	
                $registro["codigo_verificacao"] = Util::request($prefixo."codigo_verificacao"); 
                //$registro["senha"] = Util::request($prefixo."senha"); 
                $registro["endereco"] = Util::request($prefixo."endereco"); 
                $registro["id_municipio"]  = Util::numeroBanco( Util::request($prefixo."id_municipio") ); 	
                $registro["municipio"] = Util::request($prefixo."municipio"); 
                $registro["uf"] = Util::request($prefixo."uf"); 
                $registro["obs"] = Util::request($prefixo."obs"); 
               // $registro["metadados"] = Util::request($prefixo."metadados"); 
    }

	if ( $acao == "SAVE" ){
		connAccess::nullBlankColumns( $registro );	
		if (! $registro["id"] ){
	    	$registro["id"] = connAccess::Insert($oConn, $registro, "usuario", "id", true);
		}else{
		  connAccess::Update($oConn, $registro, "usuario", "id");
          // die ( " conclui ");
		}
		$_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
		$ispostback = "";      
        $acao = "LOAD";
		$id = $registro["id"];
	}

	if ( $acao == "DEL" && $id != "" ){
            
                $sql = " delete from usuario_imagem where id_usuario = ". $id;
                connAccess::executeCommand($oConn, $sql);
                
                $sql = " delete from usuario_dado where id_usuario = ". $id;
                connAccess::executeCommand($oConn, $sql);
            
		$registro = connAccess::fastOne($oConn, "usuario"," id = " . $id );
		connAccess::Delete($oConn, $registro, "usuario", "id");
		$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
		$id = "";
    	$registro = $oConn->describleTable("usuario");
		$ispostback = "";
	}

	if ( $acao == "LOAD" && $id != "" ){
		$registro = connAccess::fastOne($oConn, "usuario"," id = " . $id );
	}
?>

<? 
	Util::mensagemCadastro(85);
?>
<div class="row">
	<div class="col-xs-7">

<h1 class="sistem-title">Cadastro de Usuários</h1>
<p>Preencha os campos abaixo para realizar o cadastro.<br>
Campos com * são de preenchimento obrigatório.</p>
<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
<div class="fieldBox">
	<input type="hidden" name="acao" value="<?php echo $acao ?>">
	<input type="hidden" name="ispostback" value="1">
	<input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"]?>">
	<input type="hidden" name="id" value="<?php echo $registro["id"] ?>">
  	<input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">
	
	
	<? $eh_primarykey = True; 
        $visible_in_html = "";
        if ( $eh_primarykey && $registro["id"] == "" ) {
            $visible_in_html = " style='display:none' ";
        }  
    ?>        
	<div <? echo ($visible_in_html); ?> id="tr_id" >
		<div class="form-group">
			 <div <? if ( $registro['id'] == "" ) { ?> style='display:none' <? } ?> >
	    		<label for="id">ID</label> &nbsp;
	     		<span class='mostrapk'><?= $registro['id'] ?></span>
			</div>
		</div>
	</div>
	
    <? $eh_primarykey = False; 
       	$visible_in_html = "";
       	if ( $eh_primarykey && $registro["nome"] == "" ) {
       		$visible_in_html = " style='display:none' ";
       }
    ?>     
	<div <? echo ($visible_in_html); ?> id="tr_nome" >
		<div class="form-group">
			<label for="nome">Nome<span class="campoObrigatorio" > * </span></label>
	        <input type="text" class="form-control" name="nome" value="<?= $registro["nome"]  ?>">
					             
			<label for="sobrenome">Sobrenome<span class="campoObrigatorio" > * </span></label>
	        <input type="text" class="form-control" name="sobrenome" value="<?= $registro["sobrenome"]  ?>">	
		</div>
	</div>
	
	<? $visible_in_html = " style='display:none' "; ?>
	<div  <? echo ($visible_in_html); ?> id="tr_nome_completo">
		<div class="form-group">
			<label for="nome_completo">Nome Completo<span class="campoObrigatorio"  style="display:none" > * </span></label>
         	<input type="text" class="form-control" name="nome_completo" value="<?= $registro["nome_completo"]  ?>"   maxlength="300">
		</div>
	</div>
	
	<? $eh_primarykey = False; 
       $visible_in_html = "";
       if ( $eh_primarykey && $registro["data_cadastro"] == "" ) {
          	$visible_in_html = " style='display:none' ";
       }
    ?>        
	<div <? echo ($visible_in_html); ?> id="tr_data_cadastro">
		<div class="form-group">
		    <label for="data_cadastro">Data de Cadastro<span class="campoObrigatorio" style="display:none" > * </span></label>
    		<input type="text" class="temData form-control" name="data_cadastro" value="<?=Util::PgToOut( $registro["data_cadastro"], true) ?>" onkeypress="return mascaraData(event)" class="temData">
		</div>
	</div>
	
	<? $eh_primarykey = False; 
       $visible_in_html = "";
       if ( $eh_primarykey && $registro["email"] == "" ) {
          $visible_in_html = " style='display:none' ";
       }
    ?>        
	<div <? echo ($visible_in_html); ?> id="tr_email">
		<div class="form-group">
			<label for="email">Email<span class="campoObrigatorio"> * </span></label>
			<input type="text" class="form-control" name="email" value="<?= $registro["email"]  ?>">
			<label for="email2">Email alternativo<span class="campoObrigatorio" style="display:none" > * </span></label>
			<input type="text" class="form-control" name="email2" value="<?= $registro["email2"]  ?>">
		</div>
	</div>
	
	<? $eh_primarykey = False; 
       $visible_in_html = "";
       if ( $eh_primarykey && $registro["imagem"] == "" ) {
          $visible_in_html = " style='display:none' ";
       }
       
    ?>
	<div <? echo ($visible_in_html); ?> id="tr_imagem">
		<div class="form-group">
        	<div class="row">
        		<div class="col-xs-10">
            		<label for="imagem">Arquivo de imagem (ou gravatar)
            			<span class="campoObrigatorio" style="display:none" > * </span>
					</label>
                            <input type="text" class="form-control" name="imagem" readonly="readonly" value="<?= $registro["imagem"]  ?>">
        		</div>
				<div class="col-xs-2">
            		<? if ( $registro["imagem"] != "" && strpos(" ". $registro["imagem"], "url:")){ ?>
         			<img src="<?=str_replace("url:","",$registro["imagem"])?>" height="50" >
					<? } ?>
                                
                                <? if ( $registro["imagem"] != "" && strpos(" ". $registro["imagem"], "arquivo:")){ ?>
         			<img src="<?= K_RAIZ_DOMINIO ."files/user/".$registro["id"]."/". str_replace("arquivo:","",$registro["imagem"])?>" height="50" >
					<? } ?>
            	</div><!-- imagem -->
			</div><!-- End Row -->
        </div>      
	</div>

	
	<? $visible_in_html = " style='display:none' " ?>        
	<div  <? echo ($visible_in_html); ?> id="tr_identificacao_facebook" >
		<div class="form-group">
		    <label for="identificacao_facebook">
		    	Identificação - Perfil Facebook<span class="campoObrigatorio" style="display:none" > * </span>
			</label>
			<input type="text" class="form-control" name="identificacao_facebook" value="<?= $registro["identificacao_facebook"]  ?>">
		</div>
	</div>
	
	<? $visible_in_html = " style='display:none' "; ?>     
	<div <? echo ($visible_in_html); ?> id="tr_identificacao_twitter">
		<div class="form-group">
			<label for="identificacao_twitter">
				Identificação - Perfil Twitter<span class="campoObrigatorio" style="display:none" > * </span>
			</label>
	     	<input type="text" class="form-control" name="identificacao_twitter" value="<?= $registro["identificacao_twitter"]  ?>">
		</div>
	</div>
	
	<? $visible_in_html = " style='display:none' "; ?>       
	<div <? echo ($visible_in_html); ?> id="tr_identificacao_microsoft" >
		<div class="form-control">
			<label for="identificacao_microsoft">Identificação - Perfil Microsoft
				<span class="campoObrigatorio" style="display:none" > * </span>
			</label>
         	<input type="text" class="form-control" name="identificacao_microsoft" value="<?= $registro["identificacao_microsoft"]  ?>">
		</div>
	</div>
	
	<? $visible_in_html = " style='display:none' ";?>	    
	<div <? echo ($visible_in_html); ?> id="tr_identificacao_microsoft" >
		<div class="form-control">
		    <label for="identificacao_microsoft">
		    	Identificação - Perfil Microsoft<span class="campoObrigatorio" style="display:none" > * </span>
			</label>
	     	<input type="text" class="form-control" name="identificacao_microsoft" value="<?= $registro["identificacao_microsoft"]  ?>">
		</div>
	</div>
	
	<? $visible_in_html = " style='display:none' "; ?>   
	<div  <? echo ($visible_in_html); ?> id="tr_identificacao_google" >
		<div class="form-control"> 
		    <label for="identificacao_google">
		    	Identificação - Perfil Google<span class="campoObrigatorio"  style="display:none" > * </span>
         	</label>
         	<input type="text" class="form-control" name="identificacao_google" value="<?= $registro["identificacao_google"]  ?>">
		</div>
	</div>
	
	<? $eh_primarykey = False; 
       $visible_in_html = "";
       if ( $eh_primarykey && $registro["cpf"] == "" ) {
          $visible_in_html = " style='display:none' ";
       } 
    ?>        
	<div  <? echo ($visible_in_html); ?> id="tr_cpf" >
		<div class="row">
			<div class="col-xs-6">
				<label for="cpf">CPF<span class="campoObrigatorio"  style="display:none" > * </span></label>
     			<input type="text" class="form-control"  name="cpf" value="<?= $registro["cpf"]  ?>">
			</div>
			<div class="col-xs-6">
				<label for="rg">RG<span class="campoObrigatorio"  style="display:none" > * </span></label>
     			<input type="text" class="form-control" name="rg" value="<?= $registro["rg"]  ?>">
			</div>
		</div><!-- End Row -->
	</div>
	<? $eh_primarykey = False; 
       $visible_in_html = "";
           
       if ( $eh_primarykey && $registro["telefone"] == "" ) {
          $visible_in_html = " style='display:none' ";
       }
           
    ?>        
	<div <? echo ($visible_in_html); ?> id="tr_telefone" >
		<div class="row">
			<div class="col-xs-6">
				<label for="telefone">Telefone<span class="campoObrigatorio"  style="display:none" > * </span></label>
		    	<input type="text" class="form-control" name="telefone" value="<?= $registro["telefone"]  ?>">
			</div>
			<div class="col-xs-6">
				<label for="telefone2">Telefone 2<span class="campoObrigatorio"  style="display:none" > * </span></label>
				<input type="text" class="form-control" name="telefone2" value="<?= $registro["telefone2"]  ?>">
			</div>
		</div>	
	</div>
	<? $visible_in_html = ""; // style='display:none' "; ?>        
	<div  <? echo ($visible_in_html); ?> id="tr_verificado_email">
		<div class="form-control">
	    	<label for="verificado_email">Verificado Email<span class="campoObrigatorio"  style="display:none" > * </span></label>
                <select name="verificado_email" id="verificado_email">
                         <? Util::populaCombo("0", "Não", $registro["verificado_email"]); ?>
                         <? Util::populaCombo("1", "Sim", $registro["verificado_email"]); ?>
                </select>
        </div>	
	</div>
	<? $visible_in_html = " style='display:none' "; ?>        
	<div <? echo ($visible_in_html); ?> id="tr_verificado_senha" >
		<div class="form-control">
		    <label for="verificado_senha">Senha verificada / Criada<span class="campoObrigatorio"  style="display:none" > * </span></label>
        	<input type="text" class="form-control" name="verificado_senha" value="<?=Util::numeroTela( $registro["verificado_senha"], false) ?>" onkeypress=" return SoNumero(event)">
		</div>			 	
	</div>

	<? $visible_in_html = " style='display:none' ";?>        
	<div <? echo ($visible_in_html); ?> id="tr_codigo_verificacao" >
		<div class="form-control">
			<label for="codigo_verificacao">Codigo Verificacao<span class="campoObrigatorio"  style="display:none" > * </span></label>
			<input type="text" class="form-control" name="codigo_verificacao" value="<?= $registro["codigo_verificacao"]  ?>">
		</div>	
	</div>

	<? $visible_in_html = " style='display:none' "; ?>        
	<div <? echo ($visible_in_html); ?> id="tr_senha" >
		<div class="form-control">
			<label for="senha">Senha encriptada<span class="campoObrigatorio"  style="display:none" > * </span></label>
     		<input type="text" class="form-control" name="senha" value="<?= $registro["senha"]  ?>">
        </div>	
	</div>
	<? $eh_primarykey = False; 
       $visible_in_html = "";   
       if ( $eh_primarykey && $registro["endereco"] == "" ) {
           $visible_in_html = " style='display:none' ";
        }     
    ?>        
	<div <? echo ($visible_in_html); ?> id="tr_endereco" >
        <label for="endereco">Endereço<span class="campoObrigatorio"  style="display:none" > * </span></label>
		<textarea class="form-control" rows="3" name="endereco"><?= $registro["endereco"]  ?></textarea>
	</div>

	<? $visible_in_html = " style='display:none' ";?>        
	<div  <? echo ($visible_in_html); ?> id="tr_id_municipio" >
		<div class="form-control">
	    	<label for="id_municipio">Município<span class="campoObrigatorio"  style="display:none" > * </span></label>
        	<input type="text" class="form-control" name="id_municipio" value="<?=Util::numeroTela( $registro["id_municipio"], false) ?>" onkeypress=" return SoNumero(event)">
		</div>			 	
	</div>
	<div class="row">
		<? $eh_primarykey = False; 
	       $visible_in_html = "";
	       if ( $eh_primarykey && $registro["municipio"] == "" ) {
	              $visible_in_html = " style='display:none' ";
	        }
	    ?>
	    <div class="col-xs-10">       
			<div <? echo ($visible_in_html); ?> id="tr_municipio">
	            <label for="municipio">Município<span class="campoObrigatorio"  style="display:none" > * </span></label>
				<input type="text" class="form-control" name="municipio" value="<?= $registro["municipio"]  ?>">	
			</div>
		</div><!-- End Col -->
		<? $eh_primarykey = False; 
	       	$visible_in_html = ""; 
	        if ( $eh_primarykey && $registro["uf"] == "" ) {
	        	$visible_in_html = " style='display:none' ";
	        }    
	    ?>
	    <div class="col-xs-2">      
			<div <? echo ($visible_in_html); ?> id="tr_uf" >
				<label for="uf">UF<span class="campoObrigatorio"  style="display:none" > * </span></label>
		        <input type="text" class="form-control" name="uf" value="<?= $registro["uf"]  ?>">
		    </div>
	    </div><!-- End Col -->   
	</div><!-- End Row -->

	<? $eh_primarykey = False; 
    	$visible_in_html = "";   
        if ( $eh_primarykey && $registro["obs"] == "" ) {
        	$visible_in_html = " style='display:none' ";
        }       
    ?>        
	<div <? echo ($visible_in_html); ?> id="tr_obs" >
        <label for="obs">Observações<span class="campoObrigatorio"  style="display:none" > * </span></label>
		<textarea name="obs" rows="3" class="form-control"><?= $registro["obs"]  ?></textarea>
	</div>

	<? $visible_in_html = " style='display:none' ";?>        
	<div <? echo ($visible_in_html); ?> id="tr_metadados" >
		<label>MetaDados - RedeSocial<span class="campoObrigatorio"  style="display:none" > * </span></label>
		<input type="text" class="form-control" name="metadados" value="<?= $registro["metadados"]  ?>">
	</div>
	<div>
	<br>
	   <!--div class="divMsgObrigatorio"><?php //echo constant("K_MSG_OBR")?></div-->    
		<?php showButtons($acao,true); 
			$enBtGrupo = " disabled ";
			try { 
	   			$id = $registro["id"];
	
	   		if ( $id > 0)
	      		$enBtGrupo = "";
	
			} catch (Exception $exp){}
		?>
	</div>
</div><!-- End FiledBox -->
</form>
<div class="interMenu">
	<?php botaoVoltar("index.php?mod=listar&pag=". Util::request("pag") . "&tipo=". Util::request("tipo")  ) ?>
</div>
</div><!-- End Col -->
</div><!-- End Row -->
<script>
function salvar()
   {
      var f = document.forms[0];

	   
	    
         if (isVazio(f.nome ,'Informe Nome!')){ return false; }		
		
 
         if (isVazio(f.sobrenome ,'Informe Sobrenome!')){ return false; }		
		
 
         if (isVazio(f.email ,'Informe Email!')){ return false; }		
		
	
	
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