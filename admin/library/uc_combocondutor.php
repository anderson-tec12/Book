<?php

/* TODO: Add code here */

$conn = Zend_Registry::get("conn");

$campo = "id_condutor";

if ( isset($set_campo_condutor)){
	$campo = 	$set_campo_condutor;
}

$ssql = 'select c."Nome", c.codrm,
        c."Nome" || \' - \' || c.codrm as nomemat,
         c.id, f.descricao as funcao, e.nome as empresa 
		from admponto.colaborador c,
		 admponto.setor_funcao f,
		admponto.empresa e
		where c."idFuncao" = f.id
		and c."idEmpresa" = e.id
		order by e.nome, c."Nome" ';
		
//die ( $ssql );

		//and upper(f.descricao) like \'MOTO%\'
$arMotorista = $conn->query($ssql)->fetchAll();		


?>
<select name="<?php echo $campo ?>" style="width: 86%;" id="<?php echo $campo ?>">
<option value=""></option> 
<? // Util::CarregaComboOptGroup($arMotorista,"id","nomemat","empresa",$registro[$campo]);  --SELECIONE--
Util::CarregaComboArray( $arMotorista, "id","nomemat", $registro[$campo]);
unset( $arMotorista );
?>

</select>

<?php echo  Util::comboBoxJqueryComplete( $campo );  ?>