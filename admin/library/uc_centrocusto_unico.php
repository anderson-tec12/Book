<div style="border: solid 1px #CCCCCC; width:100%; font-size: 14px; ">
	    <div class="t-bold" style="position: relative; 		
		 background:#F9F9F9; top: -9px; text-align: center; width: 160px; left: 8px; ">
		Centro de Custo 
		</div>
		<table style="width:85%">
		 <tr> 
	
	    <td   height="18" >Centro de Custo 
	<span class="textoVermelho">*</span><br>
    
	  <input name="centro_custo" id="centro_custo"  type="text" 
	  maxlength="10"  
	value="<?php echo  $registro["centro_custo"] ?>" style="width: 92px;" onblur="document.forms[0].submit();">
	  </td>
	
	    <td   height="18" >Contrato <br>
    
	  <input name="centroCusto_contrato" id="centroCusto_contrato"  type="text"   readonly="true"  
	value="<?php echo  $cc["numero"] ?>" style="width: 92px;">
	  </td>
	   <input type="hidden" name="CC0_percentual"  id="CC0_percentual" value="100" >
	<input type="hidden" name="qtdecc" id="qtdecc" value="1" >
    </tr>
	 <tr> 
	      <td  colspan="2"  height="18" >Descrição <br>
    
	  <input name="centroCusto_descricao" id="centroCusto_descricao"  type="text"   readonly="true"  
	value="<?php echo   $cc["descricao"] ?>" style="width: 93%;">
	  </td>
	
    </tr>
	 <tr> 
	      <td  colspan="2"  height="18" >Cliente / Estabelecimento <br>
    
	  <input name="centroCusto_cliente" id="centroCusto_cliente"  type="text"   readonly="true"  
	value="<?php echo   $cc["cliente"] ?>" style="width: 93%;">
	  </td>
	
    </tr>
	</table>
	</div>
<script>
	
function carregaCentroCusto(obj)
{
   var f =   document.forms[0];
   f.acao2.value = "centrocusto";
   f.submit();
}

	
</script>