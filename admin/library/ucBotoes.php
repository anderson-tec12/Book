<?php

function showButtonsFrame( $acao, $fnSalvar = "salvar();", 
   $fnExcluir = "excluir();", $textoExcluir = "Excluir" )
{
	
	if ( $acao == "del" ){
           print( " <input type=\"button\" class=\"botao\" onclick=\"$fnExcluir\" value=\"$textoExcluir\" id=\"btExcluir\" />");
        }else{
            
           print (" <input type=\"button\" onclick=\"$fnSalvar\" class=\"botao\" value=\"Salvar\" id=\"btSalvar\" />");
   
            
        }        
        
   print("&nbsp;");
}  



function showButtons( $acao, $exibeNovo = false, $fnNovo = "novo();", $fnSalvar = "salvar();", 
   $fnExcluir = "excluir();", $exibeexcluir = true, $textoExcluir = "Excluir", $forcaHabExcluir = false)
{
	  
	//$acao = Util::request("acao");
	//die ( $acao);
   $enExcluir = " disabled ";
	//echo $acao;
	if (( $acao == Util::$LOAD || $acao == Util::$DEL || $acao == Util::$SAVE) )
       $enExcluir = "";  
	
	if ( $forcaHabExcluir )
	  $enExcluir = "";	
	
	if ( $exibeNovo)
		print ("<input type=\"button\" class=\"botao btn btn-info\" onclick=\"$fnNovo\" value=\"Novo\" id=\"btNovo\" /> ");
	
   print (" <input type=\"button\" onclick=\"$fnSalvar\" class=\"botao btn btn-success\" value=\"Salvar\" id=\"btSalvar\" />");
   
	if ( $exibeexcluir)
   print( " <input type=\"button\" class=\"botao btn btn-danger\" $enExcluir onclick=\"$fnExcluir\" value=\"$textoExcluir\" id=\"btExcluir\" />");
   print("&nbsp;");
}  

function botaoVoltar($url, $str_session = "array_querie_ant")
{
	?>
	<div class="interMenu">
	<a id="back" class="voltar" href="javascript:voltar();">
		<img alt="Voltar" src="<?= K_RAIZ ?>images/back.png"/>
		Voltar
	</a>
</div>


<form method="post" name="frmVoltar">
  <div id="dvback" style="display:none">
	<?php
	     $arr = $_SESSION[$str_session];
		
		if ( is_array( $arr ) ) {
		  foreach( $arr as $key=>$value)
		  {
			echo ' <input type="hidden" name="'.$key.'" value="'.$value.'" > 
			';
			
		  }
		  
		  }

	if (! array_key_exists("mn", $arr) ){
		$key = "mn";
		$value = Util::request("mn");
		
		echo ' <input type="hidden" name="'.$key.'" value="'.$value.'" > ';
	}

	?>
  </div>


</form>
<script>
   function voltar()
   {
   
			document.frmVoltar.action  = "<?php echo str_replace("\n", "",  trim($url)) ?>";
			document.frmVoltar.submit();

   }


</script>
<?php	
}

?>