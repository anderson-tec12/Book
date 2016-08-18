<?php

/* TODO: Add code here */

?>
<?php

/* TODO: Add code here */

function mostraComboMulta($nomeCampo, $id_veiculo, $tamanho = "300px",
$valorSelecionado = "", $completaFiltro = ""){
	
	$arr = Multa::listarMultas(1, 
	Util::NVL(	$id_veiculo, 0 ), "", $completaFiltro); 
	
	?>
	<select name="<?= $nomeCampo ?>" 
	style="width: <?= $tamanho ?>;"
	 id="<?= $nomeCampo ?>">
	<option value="">--SELECIONE--</option>  
	<? 
	for ( $y = 0; $y < count( $arr ); $y++){
	    //Util::CarregaComboArray( $lsveiculo, "id","dadosveiculo", $valorSelecionado,"");
	      $item = $arr[$y];
		
	     Util::populaCombo(
			   $item["id"], $item["numero_infracao"].
				" -  Data Infração: ".Util::PgToOut( $item["data_infracao"], true ) . " - " . " Natureza: ". $item["natureza"].
				" - Valor: " . Util::numeroTela($item["valor"], 0 ));
	}
	unset( $arr );
	
	?>
	
</select><? } ?>