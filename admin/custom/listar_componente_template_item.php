<?

$acao  = Util::request("acao");
$acao2 = Util::request("acao2");
$id  = Util::request("id");
$ispostback =  Util::request("ispostback");



function popula( &$registro, $seq )
{
	
	$prefixo = "item".$seq ."_";
	         
                    $registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") );					 
		      
         
                    $registro["id_item_componente"]  = Util::numeroBanco( Util::request($prefixo."id_item_componente") );					 
		      
         
                    $registro["id_componente_template"]  = Util::numeroBanco( Util::request($prefixo."id_componente_template") );					 
		      
         
                    $registro["ordem"]  = Util::numeroBanco( Util::request($prefixo."ordem") );					 
		      

}

//----------------------------SALVANDO OS DADOS------------------------------

$ar_lista = new ArrayList();

$rscadastro = array();

if ( !$ispostback) { 
	
    $rscadastro = connAccess::fastQuerie($oConn,"custom.componente_template_item","","");
	
	$ar_lista = new ArrayList($rscadastro);
	$_SESSION["st_custom.componente_template_item"] = $ar_lista;
}else{
	
	$ar_lista = &$_SESSION["st_custom.componente_template_item"] ;
	
	
	$rscadastro = $ar_lista->toArray();
	
	for ( $o = 0; $o < count($rscadastro); $o++){
		$ar_tmp = &$rscadastro[$o];
		
		popula( $ar_tmp , $o  );	
	}
	
	
	$ar_lista = new ArrayList($rscadastro);
	
	
	if ( Util::request("acao2") == "add" ){
		
		$ar_lista->add( $oConn->describleTable("custom.componente_template_item"));	
		//die(">>>" . $ar_lista->size() );
	}
	if ( Util::request("acao2") == "remove" && Util::request("ind_acao") != "" ){
		
		$ar_lista->remove(  Util::request("ind_acao")  );
             $_SESSION["st_Mensagem"] = "Item removido, clique em [Salvar] para confirmar!";
		//die(">>>" . $ar_lista->size() );
	}
	
	
	
}
$rscadastro = $ar_lista->toArray();


    if ( $acao2 == "SAVE" ){
         

		 $contador = 0;
	     $ls_str_itens = "0";
		
		for ($z =0; $z< count( $rscadastro) ; $z++)
         {
			
			$item = &$rscadastro[$z];
	        
			$prefixo = "item".$z."_";
			
			 $id = $item["id"];
			 
			 if  ( $id == "" ){
			   
				  
                 $rs = $oConn->describleTable("custom.componente_template_item");
				
				 popula( $rs, $contador); 
			   
			     $id =  connAccess::Insert($oConn, $rs, "custom.componente_template_item", "id", true);
			    $ls_str_itens .=",". $id;
			}else{
			  
	             $item = connAccess::fastOne($oConn, "custom.componente_template_item"," id = " . $id );
			 
				 popula( $item, $contador); 
			     
				 connAccess::Update($oConn, $item, "custom.componente_template_item", "id");
			     $ls_str_itens .=",". $id;
			   
			 }
			$contador++; 
		 }
		 
		 	
		connAccess::executeCommand($oConn,"delete from custom.componente_template_item where 1 = 1 ".
            "		and id not in ( " . $ls_str_itens.") ");
		     
             $_SESSION["st_Mensagem"] = "Registros salvos com sucesso!";
              
			 
	        //Response.Redirect("cad_custom.componente_template_item.asp?id="&id&"&acao2=LOAD")
          
    }




?>
<form name="frm" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>"  >
  	

	<input type="hidden" name="ispostback" value="1">
	
	
<input type="hidden" name="acao" value="<?= $acao ?>" />
<input type="hidden" name="acao2" value="" />
<input type="hidden" name="ind_acao" value="" />
  <table width="600" cellpadding="0" cellspacing="0" align="center">
    <tr><td height="300" align="center" valign="top" class="Pagina">
	
	
<table width="600" cellpadding="0" cellspacing="0">
 <tr>
  <td class="textoTitulo" valign="top">
	Cadastro custom.componente_template_item   </td>
 </tr>
</table>


<table width="600" height="15" cellspacing="0" cellpadding="0">
   <tr>
    <td align="right"><INPUT name="btP" type="button" class="botao" value="PESQUISAR" onClick="consultar();">
      <INPUT name="btP2" type="button" class="botao" value="CADASTRAR" onClick="cadastrar();">
      &nbsp;&nbsp;</td>
  </tr></table>


<?php Util::mensagemCadastro() ?>
<div style="width: 94%; text-align: right">
<a href="#" >  
  <img  src="images/application_form_add.png" onclick="add()" title="Cadastrar" style="cursor:pointer;" />
	</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
 <INPUT name="btP2" type="button" class="botao" value="SALVAR" onClick="salvar();">
    

</div>


<br>
<?
$acao = "pesquisar";

if ( $acao == "pesquisar") { ?>
<table width="580" cellspacing="0" cellpadding="0" align="center" height="20">
  <tr>
    <td height="18" class="textoSubTitulo">Lista - custom.componente_template_item</td>
  </tr>
</table>
<?
 
   $ssql = " select * from custom.componente_template_item where 1 = 1  ";
 
	
   $rcsTabela = connAccess::fetchData($oConn,$ssql);

if ( count($rscadastro) > 0 ){ 
?>

<table id="corpo" width="94%" align="center" border="0" cellspacing="0" cellpadding="3" class="table">
  <tr height="24" class="textoLink" bgcolor="#E8EDEC">
  
  
  
        
			  
				<th  align="center" class="header">ID</th>
				
             

			  
				<th  align="center" class="header">Item Componente</th>
				
             

			  
				<th  align="center" class="header">Template</th>
				
             

			  
				<th  align="center" class="header">Ordem</th>
				
             
		
		
    <td width="20px" align="center" bgcolor="#d3e2e2">&nbsp;</td>
    </tr>
<?
$contador = 1;

	for ($z =0; $z< count( $rscadastro) ; $z++)
{
		$item = &$rscadastro[$z];
       //$item["id"]
	
	   $prefixo = "item".$z."_";
	
 ?>

	 <tr  class="<?php if ( $z%2){ echo "f-tabela-texto-alt"; } else { echo "f-tabela-texto";} ?>">
	
         
			<td> 
        
        <input type="text"   id="<?=$prefixo?>id" name="<?=$prefixo?>id" value="<?= Util::numeroTela(  $item["id"] , true)?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      </td>			
			 
       
			<td> 
        
        <input type="text"   id="<?=$prefixo?>id_item_componente" name="<?=$prefixo?>id_item_componente" value="<?= Util::numeroTela(  $item["id_item_componente"] , true)?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      </td>			
			 
       
			<td> 
        
        <input type="text"   id="<?=$prefixo?>id_componente_template" name="<?=$prefixo?>id_componente_template" value="<?= Util::numeroTela(  $item["id_componente_template"] , true)?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      </td>			
			 
       
			<td> 
        
        <input type="text"   id="<?=$prefixo?>ordem" name="<?=$prefixo?>ordem" value="<?= Util::numeroTela(  $item["ordem"] , true)?>" onkeypress=" return SoNumero(event)" 
                      maxlength="">
					 
		      </td>			
			 
    <td align="left" class="td">&nbsp;
  
  <a href="javaScript: excluir('<?= $z?>');"><img src="images/i-excluir.gif" alt="Excluir" 
  
  title="Excluir"
   border="0"></a>
  
  
  </td> 
	  
	     </tr>
		 
		 
<?
$contador++;

}
?>
</table>

<? } else { ?>
<table id="corpo" width="94%" align="center" border="0" cellspacing="0" cellpadding="3" class="textoLink">
  <tr height="0" class="textoLink" bgcolor="#E8EDEC">
    <td width="0" bgcolor="#d3e2e2" align="center">Não existem dados para essa consulta.</td>
  </tr>
</table>
<? }

}
?>
<table width="94%" cellspacing="0" cellpadding="0" height="20">
  <tr>
    <td></td>
  </tr>
</table>

</td>
  </tr></table>

  <input type="hidden" name="qtde_atual" value="<?= count($rscadastro) ?>" />
</form>
</body>
</html>
<script>

	function add(){
		
           var frm = document.forms[0];
		    frm.acao2.value = "add";
		    frm.submit();
		
	}

	function salvar(){
		
		
           var f = document.forms[0];
		   var qtde_atual = getNum( f.qtde_atual );
		
		
           var frm = document.forms[0];
		  
		    for ( var i = 0; i < qtde_atual ; i++){
			
	                
			}
		    
		    frm.acao2.value = "SAVE";	    		    
		    frm.submit();
		
	}

	function excluir( id ){
		
		
           var frm = document.forms[0];
		
		   if ( ! confirm("Deseja realmente remover este registro?"))
		       return;
		   
		
		    frm.acao2.value = "remove";
		    frm.ind_acao.value = id ;	    
		    
		    frm.submit();
		
	}

$(function() {
		$('.temData').datepicker({ changeMonth: true, changeYear: true  });
});	
	
</script>

