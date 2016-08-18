<?php
	//require_once("ap_config.php");
	require_once("inc_cadastro_basico.php");
	require_once("inc_grafico.php");
	require_once("persist/ParametersByItem.php");
	$id = Util::request("id");
	$acao =  Util::request("acao");
	$ispostback =  Util::request("ispostback");
	$tipo = Util::NVL(  Util::request("tipo"), 1 );
	$registro = $oConn->describleTable("cadastro_basico");
	if (  $ispostback ){
		if ( $id != "" && $acao == "SAVE" )	   
		    $registro = connAccess::fastOne($oConn, "cadastro_basico"," id = " . $id );
		    connAccess::preencheArrayForm($registro, $_POST, "id");
		
		 	    $registro['id'] =  Util::request('id');  
		 	    $registro['descricao'] =  Util::request('descricao');  
		 	    $registro['codigo'] =  Util::request('codigo');  
	                    $registro['id_tipo_cadastro_basico'] =  Util::request('id_tipo_cadastro_basico');  
	                    $registro['campo1'] =  Util::request('campo1');  
	                    $registro['campo3'] = getIDS("chitensmenu");
		//print_r( $registro );
	}

	if ( $acao == "SAVE" ){
		$zid = connAccess::executeScalar($oConn, "select id from cadastro_basico where 
		    id_tipo_cadastro_basico = " . $registro['id_tipo_cadastro_basico'] .
			" and upper(descricao) = upper('".trim($registro['descricao'])."')
			and id != ". Util::NVL($registro['id']," 0"));
			
		if ( is_null($zid) || $zid == "" ){ 
			connAccess::nullBlankColumns($registro);
			//print_r( $registro );die("<<");
				if ( @$registro["id"] == "" ){
					$registro["id"] = connAccess::Insert($oConn, $registro, "cadastro_basico", "id", true);
				}else{
					connAccess::Update($oConn, $registro, "cadastro_basico", "id");
				}
					
				if ( $tipo == 1 ){
					$ids_modulos = getIDS("chmodulos");
			        Resumo::salvaItens($oConn,$registro["id"],
			        $ids_modulos, "cadastro_basico","cadastro_basico","perfilxmodulosacesso");
			
				
		     	}
                        
                        if ( $tipo == "4") {
                            
                            ParametersByItem::setValue("cor_texto", Util::request("cor_texto"), $registro["id"], "cadastro_basico", $oConn);
                            ParametersByItem::setValue("cor_fundo", $registro["codigo"], $registro["id"], "cadastro_basico", $oConn);
                            
                            
                        }
                        
                        
					
				$_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
				$ispostback = "";
				$acao = "LOAD";
				$id = $registro["id"];	
		}else{
				$_SESSION["st_Mensagem"] = "<img src='images/ponto-de-exclamacao.png'> <span style='color:red'>ERRO:</span> 
				 Já existe um registro com este nome! ";
		}
	}

	if ( $acao == "DEL" && $id != "" ){
		$registro = connAccess::fastOne($oConn, "cadastro_basico"," id = " . $id );
		connAccess::Delete($oConn, $registro, "cadastro_basico", "id");
		$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
		$id = "";
	    $registro = $oConn->describleTable("cadastro_basico");
		$ispostback = "";
	}

	if ( $acao == "LOAD" && $id != "" &&  !$ispostback ){
		$registro = connAccess::fastOne($oConn, "cadastro_basico"," id = " . $id );
	}

 	Util::mensagemCadastro(85);
        
       // print_r( $_REQUEST );
?>
<div class="row">
	<div class="col-xs-12">
		<h1 class="sistem-title">Cadastro de <?= connAccess::executeScalar($oConn, " select descricao from tipo_cadastro_basico where id = ". Util::NVL(Util::request("tipo"), " 0 ")) ?> </h1>
		<p>Preencha o campo abaixo para realizar o cadastro.<br>
		Campo com * é de preenchimento obrigatório.</p>
		<div class="row">
			<div class="col-xs-7">
				<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>&tipo=<?php echo Util::request("tipo") ?>">
				<input type="hidden" name="tipo" value="<?php echo Util::request("tipo") ?>" >
				<input type="hidden" name="pag" value="<?php echo Util::request("pag") ?>" >
				<input type="hidden" name="mod" value="<?php echo Util::request("mod") ?>" >
				<input type="hidden" name="mn" value="<?php echo Util::request("mn") ?>" >

				<div class="fieldBox">
					<input type="hidden" name="acao" value="<?php echo $acao ?>">
					<input type="hidden" name="ispostback" value="1">
					<input type="hidden" name="id" value="<?php try{ echo $registro["id"]; } catch(Exception $exp){} ?>">
		  			<input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">

		  			<div  <? if ( $registro['id'] == "" ) { ?> style='display:none' <? } ?> >
						<label for="id">ID</label> &nbsp;
				 		<span class='mostrapk'><?= $registro['id'] ?></span>
					</div>
					<div class="form-group">
						<label for="descricao">Nome</label>  <span class='campoObrigatorio'> *</span>	
			         	<input type="text" class="form-control" name="descricao" value="<?= $registro["descricao"] ?>">
			         	<? if ( $tipo == "4") { ?>
                                        <div class="form-group">
	    					<label for="codigo">Cor de Fundo</label> 
	        				<input type="text" class="color form-control"
                                                       style="width: 100px" maxlength="8"
                                                       name="codigo" value="<?= @$registro["codigo"] ?>">
						</div>
                                          <div class="form-group">
	    					<label for="codigo">Cor do Texto</label> 
	        				<input type="text" class="color form-control"
                                                       style="width: 100px" maxlength="8"
                                                       name="prop_cor_texto" value="<?= ParametersByItem::getValue("cor_texto", $registro["id"], "cadastro_basico", $oConn)?>">
						</div>
                                        <? } ?>
					</div>
					
				 	<? $rslista = connAccess::fetchData($oConn, "select id, descricao from tipo_cadastro_basico order by descricao"); 
					//  print_r( $rslista );?>
	   				<div class="hidden">
        				<label for="id_tipo_cadastro_basico">Tipo de Cadastro Básico</label> 
						<select class="form-control" name="id_tipo_cadastro_basico"> 
 							<? Util::CarregaComboArray( $rslista, "id" , "descricao",  $tipo); ?>  
 						</select>
 					</div>	
 						<?  if ( $tipo == 2  && false ) { ?>	
						<label for="campo1">Peso</label> 
		                	<? $rslista = connAccess::fetchData($oConn, "select * from peso order by peso"); 
		 					//  print_r( $rslista );?>
         				<select class="form-control" name="campo1" > 
 							<? Util::CarregaComboArray( $rslista, "id" , "peso",  $registro["campo1"]); ?>  
						</select> 
						<? }?>
						<? if ($tipo == 1){ ?>
						<div class="hidden">
        					<label for="campo1">Código Identificador do Perfil (Não alterar)</label> 
         					<input type="text" class="form-control" name="campo1" value="<?= $registro["campo1"] ?>" >
						
							<?
								$filtro = " and id_tipo_cadastro_basico = 14 ";
								$rslista = connAccess::fetchData($oConn, "select id, descricao from cadastro_basico where 1 = 1 ". $filtro. " order by descricao"); 
								$ids_modulos = Resumo::getIDsFilhoItens($oConn,Util::NVL($registro["id"],0),"perfilxmodulosacesso");
								//echo ( $ids_modulos );
								mostraChecks( $rslista,"chmodulos","id","descricao","Selecione os módulos de acesso",false,true
			       				,$ids_modulos, false,"200px","", '');	
							?>
							<?
								$rslista = getListaMenuToCheks(); 
								$ids_modulos = $registro["campo3"];
								mostraChecks( $rslista,"chitensmenu","valor","texto","Selecione cada funcionalidade de acesso",false,true
			       				,$ids_modulos, false,"300px","grupo", '');	
							?>
						</div>
						<? }?>
						
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
					
		        </div><!-- End fieldBox -->
                        </form>
        	</div><!-- End col 7 -->
		</div><!-- End Row -->
	</div><!-- End col 12 -->
</div><!-- End Row -->
<script type="text/javascript" src="javascript/jscolor/jscolor.js"></script>
<div class="interMenu">
						<?php botaoVoltar("index.php?mod=listar&pag=". Util::request("pag") . "&tipo=". Util::request("tipo")  ) ?>
					</div>

<script>
function salvar()
   {
      var f = document.forms[0];

	  
	 	  if (isVazio(f.descricao ,'Informe Nome!')){ return false; }  
	   
	
   	  f.action += "&acao=<?php echo (  Util::$SAVE) ?>&tipo=<?= Util::request("tipo") ?>";
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
   	  
	  
   	 f.action += "&acao=<?php echo Util::$DEL?>";
   	  f.submit();
   }


function att_marcatodos(obj, prefixo){

    var docs = document.getElementsByTagName("input");
	
	for ( i = 0; i < docs.length; i++){
	
	        if ( docs[i].type == "checkbox" ){ 
			    
				//alert( docs[i].name ); 
				
				if ( docs[i].name.indexOf(prefixo) > -1){
				
				      docs[i].checked = obj.checked;
			    	}
				}
	}
}

function att_getids( prefixo){

    var docs = document.getElementsByTagName("input");
	var str = "";
	for ( i = 0; i < docs.length; i++){
	
	        if ( docs[i].type == "checkbox" ){ 
			    
				//alert( docs[i].name ); 
				
				if ( docs[i].name.indexOf(prefixo) > -1 && docs[i].checked){
				
				if ( str != "" )
				    str += ",";
				      
				      str += docs[i].value;
			    	}
				}
	}
	
	return str;
}


</script>