<?php

/* TODO: Add code here */

$lsveiculo = Veiculo::listar($op,"");	

$change = "";

if ( isset($set_change)) 
	$change = $set_change;
?>
<select name="id_veiculo" style="width: 86%;" <?= $change ?> id="id_veiculo">
<option value="">--SELECIONE--</option>  
<? 
Util::CarregaComboArray( $lsveiculo, "id","dadosveiculo", $registro["id_veiculo"],"");
 
unset( $lsveiculo );
?>

</select>