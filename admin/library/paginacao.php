<?php

function fn_cb_selected($val1, $val2)
{
	if ($val1 == $val2)
	  return " selected ";
	  
	  return "";
}


function SetaRsetPaginacao($selQtdeRegistro, $selPagina,$totalRegistro,
  &$inicio, &$fim)
{
	
	
	if ( ! is_numeric($selQtdeRegistro))
	  $selQtdeRegistro = 0;
	
	
	if ( ! is_numeric($totalRegistro))
	  $totalRegistro = 0;
	
	
	$pageCount =  @($totalRegistro / $selQtdeRegistro);
	
	if ($pageCount < 1)
		$pageCount = 1; 
	
	if ($pageCount > round($pageCount))
		{    $pageCount++;}
	else 
		{  $pageCount = round($pageCount); }
	
	$pageCount = (int)$pageCount;
	
	
	//echo  $selPagina . "-- ".$pageCount;
	
	if ( $selPagina > (int)$pageCount)
		$selPagina = (int)$pageCount;
	
	//die ( $selPagina );
	
     $inicio = $selQtdeRegistro * ($selPagina -1);
     $fim = $inicio + $selQtdeRegistro;
     
     
     if ($fim > $totalRegistro)
         @($fim = $totalRegistro);

         //die($inicio."----".$selQtdeRegistro."-".$selPagina."-".$fim."-".$totalRegistro);

         return $inicio."_".$fim;
 }

function MostrarPaginacao  ($selQtdeRegistro,$selPagina,
	$totalRegistro,$formulario, $mostraQtdPagina = true, $mostraSetas = true,
	 $prefix= "", $pref_images = "" )		   
{
  $formulario =  trim($formulario);

	if ( ! is_numeric($selQtdeRegistro))
	  $selQtdeRegistro = 0;
	
	
	if ( ! is_numeric($totalRegistro))
	  $totalRegistro = 0;
	
	
	if ( ! is_numeric($selPagina))
	  $selPagina = 0;
	

  $pref_images = K_RAIZ;
  
  //echo  ($selQtdeRegistro."---".$totalRegistro);
  	if ($selQtdeRegistro > $totalRegistro){
		?>
	  	<input type="hidden" name="<?php echo $prefix ?>selQtdeRegistro"
		id="<?php echo $prefix ?>selQtdeRegistro" value ="<?php echo $selQtdeRegistro?>">
  		<?php   return;
 	} 
	//die ($selPagina);
  	$pageCount = @($totalRegistro / $selQtdeRegistro);
	//echo  $selPagina . "-- ".$pageCount;

		
  	if ($pageCount < 1)
     	$pageCount = 1; 
  
  	if ($pageCount > round($pageCount)){    
  		$pageCount++;
  	}else {  
  		$pageCount = round($pageCount); }
  
  	$pageCount = (int)$pageCount;
 
	if ( $selPagina > $pageCount)
		$selPagina = $pageCount;
	

?>

	
	<?php if ( $mostraQtdPagina ) { ?>
	
	Mostrar at&eacute;
    	<label for="showing" class="sr-only">Mostrar até</label>
            <select name="<?php echo $prefix ?>selQtdeRegistro" 
            	 id="<?php echo $prefix ?>selQtdeRegistro" onchange="document.<?php echo $formulario?>.submit()" 
            	 class="formMultiplo form-control input-sm">
			    <!--option value="1" <?php echo fn_cb_selected(1,$selQtdeRegistro) ?>>1 Registros</option--> 
				<option value="10" <?php echo fn_cb_selected(10,$selQtdeRegistro) ?>>10 Registros</option>
				<option value="15" <?php echo fn_cb_selected(15,$selQtdeRegistro) ?>>15 Registros</option>
			</select>
	por p&aacute;gina
	
                
	<?php } else { ?>
		<input type="hidden" name="<?php echo $prefix?>selQtdeRegistro" value="<?php echo $selQtdeRegistro ?>" >
		
	<?php } ?>
	
	
	<?php if ( $mostraSetas  && $pageCount > 1 ){
		?>
		
		<?php if ( $selPagina > 1) { ?>
			<a href="#" onclick="<?php echo $prefix?>botaoPagina(-1);">
				<span class="glyphicon glyphicon-backward text-export"></span></a>
						
		<?php } ?>
		&nbsp;
		<!-- pedaço -->
	
	
              <!--td class="f-tabela-paginacao" -->Mostrar p&aacute;gina 
                <select  class="formMultiplo form-control input-sm" name="<?php echo $prefix?>selPagina" 
                	onchange="document.<?php echo $formulario?>.submit()">
                  <?php 
				  $z =0; $fim =0;
				      $z = 1;
					  $fim = $pageCount; 
			 
				   if ($fim == 0)
				   { $fim = 1; }
				  
					
						  while ($z<= $fim)
						  {
						  ?>
								  <option value="<?php echo $z?>" <?php echo fn_cb_selected($z,$selPagina) ?>><?php echo $z;?></option>
						   <?php
						      $z++;
						  } 
						   ?>
				</select> 
                de <span class="badge"><?php echo $fim ?></span>
              Total de Registros: <span class="badge"><?php echo $totalRegistro; ?></span>

              <?php if ( $selPagina < $pageCount) { ?>   
  				<a href="#" onclick="<?php echo $prefix?>botaoPagina(1);" title="Próxima página">
  					<span class="glyphicon glyphicon-forward text-export"></span></a>
  					
		  		
		  		<?php } ?>
		&nbsp;	
		
	<?php } ?>
            
			
<script>
 function <?php echo $prefix?>botaoPagina( cod)
 {
        
        document.<?php echo $formulario?>.<?php echo $prefix?>selPagina.selectedIndex = document.<?php echo $formulario?>.<?php echo $prefix?>selPagina.selectedIndex + cod;
		document.<?php echo $formulario?>.submit();				
						
 }
</script>
<?php }
  
  
  function MostrarPaginacaoPainelControle ($selQtdeRegistro,$selPagina,
	$totalRegistro,$formulario, $mostraQtdPagina = true, $mostraSetas = true,
	 $prefix= "", $pref_images = "" )		   
{
  $formulario =  trim($formulario);

	if ( ! is_numeric($selQtdeRegistro))
	  $selQtdeRegistro = 0;
	
	
	if ( ! is_numeric($totalRegistro))
	  $totalRegistro = 0;
	
	
	if ( ! is_numeric($selPagina))
	  $selPagina = 0;
	

  $pref_images = K_RAIZ;
  
  //echo  ($selQtdeRegistro."---".$totalRegistro);
  if ($selQtdeRegistro > $totalRegistro)
  {
	?>
	  <input type="hidden" name="<?php echo $prefix ?>selQtdeRegistro"
		id="<?php echo $prefix ?>selQtdeRegistro" value ="<?php echo $selQtdeRegistro?>">
  <?php   return;
 } 
	//die ($selPagina);
  $pageCount = @($totalRegistro / $selQtdeRegistro);
	//echo  $selPagina . "-- ".$pageCount;

		
  if ($pageCount < 1)
     $pageCount = 1; 
  
  if ($pageCount > round($pageCount))
  {    $pageCount++;}
  else 
  {  $pageCount = round($pageCount); }
  
  $pageCount = (int)$pageCount;
  
	
	if ( $selPagina > $pageCount)
		$selPagina = $pageCount;
	

?>
 
	
	<?php if ( $mostraQtdPagina ) { ?>
		
           <input type="hidden" name="<?php echo $prefix ?>selQtdeRegistro"
		id="<?php echo $prefix ?>selQtdeRegistro" value ="<?php echo $selQtdeRegistro?>">
        
	<?php } else { ?>
		<input type="hidden" name="<?php echo $prefix?>selQtdeRegistro" value="<?php echo $selQtdeRegistro ?>" >
		
	<?php } ?>               
	
	<?php if ( $mostraSetas  && $pageCount > 1 ){
		?>
		
		<?php if ( $selPagina > 1) { ?>
			<a class="back" href="#" onclick="<?php echo $prefix?>botaoPagina(-1);">Voltar</a>
		<?php } ?>
	
		<?php if ( $selPagina < $pageCount) { ?>   
                        
			<a class="next" href="#" onclick="<?php echo $prefix?>botaoPagina(1);">Próximo</a>
                        
		 <?php } ?>
		
	<?php } ?>
	  <input type="hidden" name="<?php echo $prefix?>selPagina"
		id="<?php echo $prefix?>selPagina" value ="<?php echo Util::NVL($selPagina,1 )?>">
	
			
<script>
 function <?php echo $prefix?>botaoPagina( cod)
 {
     var int_pag = parseInt( document.<?php echo $formulario?>.<?php echo $prefix?>selPagina.value ) + cod;
        
        document.<?php echo $formulario?>.<?php echo $prefix?>selPagina.value = int_pag.toString() ;
		document.<?php echo $formulario?>.submit();				
						
 }
</script>
  <?php }  ?>