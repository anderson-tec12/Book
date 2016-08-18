<tr> 
     <td  colspan="2"  > 
	<br>
	   <div style="border: solid 1px #CCCCCC">
	    <div class="t-bold" style="position: relative; 		
		 background:#FFFFFF; top: -9px; text-align: center; width: 80px; left: 8px; ">
		Arquivos 
		</div>
		<div id="dvLoad" 
		class="t-bold-mbranco" 
		style="position: absolute; left:45%; top:800px; background: #FFFFFF; display: none; " >
			<img src="<?php echo  '/www/assets/images/loading.gif' ?>" >
		   <i>  Carregando...</i>
		</div>
		<a name="Aarquivos"></a>
		<table style="width:100%">
		<tr>
		<td class="f-tabela-lista"> 
		 Localizar Arquivo: </td><td> 
		 <div id="dvinputarquivo">
		 <input type="file" name="arquivo"  style="width:280px;"  />
		 </div>
		<input type="hidden" name="indxarquivo" > 
		<input type="hidden" name="acaoarquivo" >
		
		</td>
		 </tr> <tr>
		 <td class="f-tabela-lista" >Descrição:  </td><td> 
		 		  <input name="descarquivo" style="width:280px;" 
				type="text"  maxlength="300">
    &nbsp;&nbsp;&nbsp;
	 	<img alt="Salvar" title="Salvar" height="16" width="16" onclick="anexar()" src="<?php echo  '/www/assets/images/ok.png'?>"/>
		&nbsp;	
		<img alt="Remover" title="Remover" height="16" onclick="removeanexo()" width="16" src="<?php echo  '/www/assets/images/delete.png'?>"/>
		 </td>
	     </tr>   
	</table> <br>
	<div id="listaarquivos" style="width:99%; padding-left: 20px;">
	
	</div>
		</div>
		  </td>
    </tr> 