<?php
require_once("inc_competicao_fase.php");
require_once("custom/inc_ferramenta.php");


$id = Util::request("id");
$acao =  Util::request("acao");
$ispostback =  Util::request("ispostback");

$registro = $oConn->describleTable("competicao_fase");

	
function getIDS($prefixo){
	
	$str = "";
	
	foreach($_REQUEST as $key=>$value){
	         
		if ( strpos(" ".$key,$prefixo."_")){
			$str = Util::AdicionaStr($str,$value,",");
		} 	
		
	}
	
	return $str;	
}	


if ( $ispostback ){	
	
	if ( $id != "" )	   
	    $registro = connAccess::fastOne($oConn, "competicao_fase"," id = " . $id );
	
	connAccess::preencheArrayForm($registro, $_POST, "id");
	
	$prefixo = "";
	
	         
                    $registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") );					 
		      
                    $registro["titulo"] = Util::request($prefixo."titulo"); 

                    $registro["codigo"] = Util::request($prefixo."codigo"); 

                    $registro["texto"] = Util::request($prefixo."texto"); 
                    $registro["subtitulo"] = Util::request($prefixo."subtitulo"); 
                    $registro["modulos"] = getIDS("modulos");
                    $registro["ferramentas"] = getIDS("ferramentas");
                     $registro["modulos_txt"] = "";
                    $registro["ferramentas_txt"] = "";
                    
                    if ( $registro["modulos"] != "" ){
                        $ls = connAccess::fetchData($oConn, " select titulo from modulo where id in ( ".$registro["modulos"]." ) order by titulo " );
                        $registro["modulos_txt"] = Util::arrayToString($ls, "titulo",", ");
                       
                    }
                    
                     if ( $registro["ferramentas"] != "" ){
                        $ls = connAccess::fetchData($oConn, " select titulo from ferramenta where id in ( ".$registro["ferramentas"]." ) order by titulo " );
                        $registro["ferramentas_txt"] = Util::arrayToString($ls, "titulo",", ");
                       
                    }
                    
                      $registro["fase"] = Util::request($prefixo."fase"); 
                      
                      
                     $ferramenta = inc_ferramenta::findFerramentaByCodigo("competicao");
                     $registro["id_ferramenta_competicao"] = $ferramenta["id"];
                     $registro["codigo_ferramenta_competicao"] = $ferramenta["codigo"];
                      
                     //$registro["id_ferramenta_competicao"]  = Util::numeroBanco( Util::request($prefixo."id_ferramenta_competicao") );					 
                     // $registro["codigo_ferramenta_competicao"] = Util::request($prefixo."codigo_ferramenta_competicao"); 
                    $registro["obs"] = Util::request($prefixo."obs"); 

	
}

if ( $acao == "SAVE" ){
	  
	connAccess::nullBlankColumns( $registro );	
	 
	if (! @$registro["id"] ){
	
	     $registro["id"] = connAccess::Insert($oConn, $registro, "competicao_fase", "id", true);
	}else{
		  connAccess::Update($oConn, $registro, "competicao_fase", "id");
		}
		
		$_SESSION["st_Mensagem"] = "Registro salvo com sucesso!";
		$ispostback = "";
		
		$acao = "LOAD";
		$id = $registro["id"];
	
}

if ( $acao == "DEL" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "competicao_fase"," id = " . $id );
	connAccess::Delete($oConn, $registro, "competicao_fase", "id");
	
	$_SESSION["st_Mensagem"] = "Registro excluído com sucesso!";
	
	$id = "";
    $registro = $oConn->describleTable("competicao_fase");
	$ispostback = "";
	
}

if ( $acao == "LOAD" && $id != "" ){
	
	$registro = connAccess::fastOne($oConn, "competicao_fase"," id = " . $id );

}

?>
<? 
 Util::mensagemCadastro(85);
?>

<div class="row">
	<div class="col-xs-8">
		<h1 class="sistem-title">Fase da Competição</h1>
		<p>Campos com * são de preenchimento obrigatório.</p>

					<form method="post" name="frm" action="index.php?pag=<?php echo Util::request("pag") ?>&mod=<?php echo Util::request("mod") ?>">
					<div class="fieldBox">
						  
						  <input type="hidden" name="acao" value="<?php echo $acao ?>">	  
						  <input type="hidden" name="ispostback" value="1">
						  <input type="hidden" name="urlant" value="<?php echo @$_SESSION["urlant"]?>">  
						  <input type="hidden" name="tipo" value="<?php try{ echo Util::request("tipo"); } catch(Exception $exp){} ?>">
						 
                      <input type="hidden"  name="id" value="<?= $registro["id"]  ?>"  >
					
        <? $eh_primarykey = True; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["id"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id" >
				<div class="form-group">
			    	<label for="id">ID: <span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
                                   <span class="mostrapk"><?= $registro["id"] ?></span>
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["codigo"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_codigo" >
				<div class="form-group">
			    	<label for="codigo">Código<span class="campoObrigatorio" > *</span></label>
			  		         
                                 <input type="text"  name="codigo" value="<?= $registro["codigo"]  ?>"  class="form-control" maxlength="">        
		      
				</div>
			</div>
			 
        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["titulo"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_titulo" >
				<div class="form-group">
			    	<label for="titulo">Título<span class="campoObrigatorio" > *</span></label>
			  		         
                                 <input type="text"  name="titulo" value="<?= $registro["titulo"]  ?>"  class="form-control" maxlength="300">        
		      
				</div>
			</div>
		 <div  id="tr_subtitulo" >
				<div class="form-group">
			    	<label for="subtitulo">Sub-Título<span class="campoObrigatorio" > *</span></label>
			  		         
                                 <input type="text"  name="subtitulo" value="<?= $registro["subtitulo"]  ?>"  class="form-control" maxlength="300">        
		      
				</div>
			</div>	 


        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["texto"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_texto" >
				<div class="form-group">
			    	<label for="texto">Texto<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
			  <textarea id="texto" name="texto" class="form-control"  
                   style="height: 200px" ><?= $registro["texto"] ?></textarea>
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["modulos"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_modulos" >
				<div class="form-group">
			    	<label for="modulos">Módulos Associados<span class="campoObrigatorio"  style="display:none" > *</span></label>
                                <div style="height: 250px; overflow: scroll">
                                     
        <?
		//----------- CHECKBOXLIST para modulos -> Módulos Associados---------------------------
           $has_query  = "1";   $field_query =  "select id, titulo from modulo order by titulo";
           $has_list   = "0";   
           $field_query_val = "id";
           $field_query_text = "titulo";
        
        $rslista = array();
        
        if ( $has_query ){        
                $rslista = connAccess::fetchData($oConn, $field_query); 
        }
        
        if ( !function_exists("get_list_modulos")){
        
             function get_list_modulos(){  return array(); }
        }
		
        if ( $has_list  ){    
        
                $rslista = get_list_modulos();  
                $field_query_val = "id";
                $field_query_text = "descr";
        }
       
        $arr_values = new ArrayList( 
               explode(",", $registro["modulos"] )
               );
        
        for ( $i = 0; $i< count($rslista); $i++){
        
             $item = $rslista[ $i ];
             ?>
             <input type="checkbox" value="<?=$item[$field_query_val]?>" name="modulos_<?=$i?>" id="modulos_<?=$i?>"  
                 <?  if (  $arr_values->contains( $item[$field_query_val] )){ echo ( " checked "); } ?>
             class="form-control" ><?=$item[$field_query_text]?>
             &nbsp;&nbsp;&nbsp;
             
             <?        
        }        
        ?>
		      
                                </div>	
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["ferramentas"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_ferramentas" >
				<div class="form-group">
			    	<label for="ferramentas">Ferramentas<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  <div style="height: 250px; overflow: scroll">  		 
        <?
		//----------- CHECKBOXLIST para ferramentas -> Ferramentas---------------------------
           $has_query  = "1";   $field_query =  "select id, titulo from ferramenta order by titulo";
           $has_list   = "0";   
           $field_query_val = "id";
           $field_query_text = "titulo";
        
        $rslista = array();
        
        if ( $has_query ){        
                $rslista = connAccess::fetchData($oConn, $field_query); 
        }
        
        if ( !function_exists("get_list_ferramentas")){
        
             function get_list_ferramentas(){  return array(); }
        }
		
        if ( $has_list  ){    
        
                $rslista = get_list_ferramentas();  
                $field_query_val = "id";
                $field_query_text = "descr";
        }
       
        $arr_values = new ArrayList( 
               explode(",", $registro["ferramentas"] )
               );
        
        for ( $i = 0; $i< count($rslista); $i++){
        
             $item = $rslista[ $i ];
             ?>
             <input type="checkbox" value="<?=$item[$field_query_val]?>" name="ferramentas_<?=$i?>" id="ferramentas_<?=$i?>"  
                 <?  if (  $arr_values->contains( $item[$field_query_val] )){ echo ( " checked "); } ?>
             class="form-control" ><?=$item[$field_query_text]?>
             &nbsp;&nbsp;&nbsp;
             
             <?        
        }        
        ?>
                          </div>
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = ' style="display:none" ';
           
           if ( $eh_primarykey && $registro["fase"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_fase" >
				<div class="form-group">
			    	<label for="fase">Fase<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		      
         <? 
         $rslista = get_list_fase(); 
         ?>
         <select   name="fase" id="fase" class="form-control"> 
		        <option value="">--</option>
           <? 
           Util::CarregaComboArray( $rslista, "id" , "descr",  $registro["fase"] ); ?>  
         </select> 
        
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = ' style="display:none" ';
           
           if ( $eh_primarykey && $registro["id_ferramenta_competicao"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_id_ferramenta_competicao" >
				<div class="form-group">
			    	<label for="id_ferramenta_competicao">Ferramenta Competição<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
        
        <input type="text"  name="id_ferramenta_competicao" class="form-control" value="<?=Util::numeroTela( $registro["id_ferramenta_competicao"], false) ?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = ' style="display:none" ';
           
           if ( $eh_primarykey && $registro["codigo_ferramenta_competicao"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_codigo_ferramenta_competicao" >
				<div class="form-group">
			    	<label for="codigo_ferramenta_competicao">Código Competição<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		         
                                 <input type="text"  name="codigo_ferramenta_competicao" value="<?= $registro["codigo_ferramenta_competicao"]  ?>"  class="form-control" maxlength="">        
		      
				</div>
			</div>
			 

        <? $eh_primarykey = False; 
           $visible_in_html = '';
           
           if ( $eh_primarykey && $registro["obs"] == "" ) {
              $visible_in_html = " style='display:none' ";
           } ?> 
		   <div <? echo ($visible_in_html); ?> id="tr_obs" >
				<div class="form-group">
			    	<label for="obs">Observações<span class="campoObrigatorio"  style="display:none" > *</span></label>
			  		 
			  <textarea id="obs" name="obs" class="form-control"  
                   ><?= $registro["obs"] ?></textarea>
		      
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

	   
	    
         if (isVazio(f.titulo ,'Informe Título!')){ return false; }		
		
 
         if (isVazio(f.codigo ,'Informe Código!')){ return false; }		
		
	
	
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