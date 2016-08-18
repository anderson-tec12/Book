<?php

//descstatus
function mostraDuploCombo( $lista1, $lista2, $campoid, $campoTexto, $campoGrupo, 
       $nomeCombo1, $nomeCombo2, $hdTemp, $height = "220px"){

?>
<table style="text-align:left ;width:100%" border="0">
	  <tr>
	    <td  class="f-tabela-lista" style="width:45%"> Disponível(is) <br>
				 <select name="<?= $nomeCombo1 ?>" id="<?= $nomeCombo1 ?>"
	multiple="multiple" style="width: 100%; height: <?= $height ?>;" 
					onClick="return false"
					onDblClick="moveSelectedOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
                 <?php
			        $arr = 	$lista1;
	                if ( $campoGrupo != "" ){
		                  Util::CarregaComboOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
						}else{
							Util::CarregaComboArray($arr, $campoid, $campoTexto, "");
						}
				?>
				 </select> 
				 </td>
				 <td style="width:10%" align="center">
				
			  <input type="hidden" name="<?= $hdTemp ?>" value="">	
				
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE=" &gt; "
			     ONCLICK="moveSelectedOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <br>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE="&gt;&gt;" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <BR>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE=" &lt; " ONCLICK="moveSelectedOptions(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <br>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE="&lt;&lt;" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">	
			  
			           
				 </td>
				 <td class="f-tabela-lista" style="width:45%">
				 Selecionado(s)<br>
	<select name="<?= $nomeCombo2 ?>" id="<?= $nomeCombo2 ?>" multiple="multiple" style="width: 100%; height: <?= $height ?>;" onDblClick="moveSelectedOptions(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
                  <?php
			        $arr =  $lista2;
					
					
				if ( $campoGrupo != "" ){
					Util::CarregaComboOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
				}else{
					Util::CarregaComboArray($arr, $campoid, $campoTexto, "");
				}
				?>
				
				
				</select>
	     
                
				 </td>
			  </tr>
	</table><?php
	} ?>
	
	
	<?php

//descstatus
function mostraDuploCombo2( $lista1, $lista2, $campoid, $campoTexto, $campoGrupo, 
       $nomeCombo1, $nomeCombo2, $hdTemp, $height = "220px", $iframe = "",  $urlprocessa = ""){

?>
<table style="text-align:left ;width:100%" border="0">
	  <tr>
	    <td  class="f-tabela-lista" style="width:90%"> Disponível(is)  <i>Digite para pesquisar</i> <br>
				 <select name="<?= $nomeCombo1 ?>" id="<?= $nomeCombo1 ?>"
	multiple="multiple" style="width: 90%;" 
					>
				
				<option value=""></option>
				 <?php
				 $arr = 	$lista1;
				 if ( $campoGrupo != "" ){
				 	Util::CarregaComboOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
				 }else{
				 	Util::CarregaComboArray($arr, $campoid, $campoTexto, "");
				 }
				 ?>
				 </select> 
				<?
				echo Util::comboBoxJqueryComplete($nomeCombo1, true);
				
				?>
				</td>
				<td style="width: 10%">
				
				
				<INPUT TYPE="button"  class="botao"  NAME="right" Title="Adicionar" VALUE=""
			     ONCLICK="envia_valor_combo('vai');"
	style="background: url('<?= K_RAIZ ?>images/add2.png') no-repeat #FFFFFF; width:24px; height: 20px"
				>
   
			
				 </td>
				</tr>
				<tr style="display:none">
				
				
				 <td align="center">
					
				<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE=" &gt; "
			     ONCLICK="moveSelectedOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value);  ">
   
			  <input type="hidden" name="<?= $hdTemp ?>" value="">	
				
	           <br>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE="&gt;&gt;" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <BR>
            <br>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE="&lt;&lt;" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">	
			  
			           
				 </td>
				</tr>
				<tr>
				 <td class="f-tabela-lista" style="width: 90%;" >
				 Selecionado(s)<br>
	<select name="<?= $nomeCombo2 ?>" id="<?= $nomeCombo2 ?>" multiple="multiple"  style="width: 100%; 
	height: <?= $height ?>;" onDblClick="envia_valor_combo('volta');">
                  <?php
                  $arr =  $lista2;
                  
                  
                  if ( $campoGrupo != "" ){
                  	Util::CarregaComboOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
                  }else{
                  	Util::CarregaComboArray($arr, $campoid, $campoTexto, "");
                  }
                  ?>
				
				
				</select>
	     
                
				 </td>
				<td style="width: 10%">
				
					<INPUT TYPE="button"  title="Excluir"  NAME="left" VALUE="" 
					ONCLICK="envia_valor_combo('volta')" 
	style="background: url('<?= K_RAIZ ?>images/del2.png') no-repeat #FFFFFF; width:24px; height: 20px">
  
				 </td>
			  </tr>
	</table>
	<script type="text/javascript">
	function envia_valor_combo(acao){
	
	var f = document.forms[0];
	
	var oldact = f.action;
	
	var id = f.<?= $nomeCombo1 ?>.value;
	
	  if ( acao != "" ){
	
			if ( acao == "volta" ){
				
				if (f.<?= $nomeCombo2 ?>.selectedIndex==-1 ){
		                 alert('Selecione um item!');
						 return;
				}
				
	            var id = f.<?= $nomeCombo2 ?>.value;
	
	        }
	
	
		<?
		$urlfinal = $urlprocessa . "?retorno=".$nomeCombo2;
		?>
		f.action = "<?=$urlfinal?>"+"&id="+id+"&acao="+acao;
		f.<?= $hdTemp ?>.value = obterValorSelect(  f.<?= $nomeCombo2 ?> );
		f.target = "<?= $iframe ?>";
		f.submit();
		
		f.action = oldact;
		f.target = "_self";
		
		f.<?= $nomeCombo1 ?>.value = "";
		
		var inp = $(".dhx_combo_input");
		var selItem1 = $("#selItem1");
		//alert( inp );
		if ( inp != null ){
		inp.value = "";
		selItem1.value = "";
		}
	  }
	

	
	}
	
	</script>
	
	
	<?php
	} ?>