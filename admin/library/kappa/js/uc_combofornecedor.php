<?php

/* TODO: Add code here */

$conn = Zend_Registry::get("conn");

$campo = "id_fornecedor";
	
$lsveiculo = FornecedorTipo::listarFornecedor("","","","4");

if ( isset($setcampo) && $setcampo != "" ){
	
	$campo = $setcampo;
}
$comp_fornecedor = "";
if ( isset($set_comp_fornecedor) && $set_comp_fornecedor != "" ){
	
	$comp_fornecedor = $set_comp_fornecedor;
}

?>
<select name="<?= $campo ?>" <?= $comp_fornecedor ?> style="width: 86%;" id="<?= $campo ?>">
<option value="">--SELECIONE--</option> 
<? 
Util::CarregaComboOptGroup  ( $lsveiculo, "id","nome","tipofornecedor",
		$registro[$campo]);

unset( $lsveiculo );
?>

</select>