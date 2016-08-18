<?php

/* TODO: Add code here */

$conn = Zend_Registry::get("conn");

$campo = "id_empresa";



$ssql = 'select * from admponto.empresa order by nome ';

//die ( $ssql );

//and upper(f.descricao) like \'MOTO%\'
$arEmpresa = $conn->query($ssql)->fetchAll();		


?>
<select name="<?php echo $campo ?>" style="width: 86%;" id="<?php echo $campo ?>">
<option value="">--SELECIONE--</option> 
<? 
Util::CarregaComboArray( $arEmpresa, "id","nome", $registro[$campo]);
  //Util::CarregaComboOptGroup($arEmpresa,"id","nome","empresa",$registro[$campo]); 

unset( $arEmpresa );
?>

</select>