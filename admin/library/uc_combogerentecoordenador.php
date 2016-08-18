<?php
$oUsuario = new UsuarioSPP();

 if (false &&  PedidoPagamento::mostraEmpresa() ){ ?>

<tr><td height="18" >
			    Empresa:<br>
			<select id="idEmpresa" name="idEmpresa" style="width:auto;"  >
	<?php 
	
	$idEmpresa = Util::NVL( $registro["idEmpresa"], $op->getGroup("min","admponto.empresa","id",""));
	$filtroEmpresa = "";
	
	if (! PedidoPagamento::mostraEngevix() ){
		
		$filtroEmpresa .= " upper(p.nome) not like '%ENGEVIX%' ";	
	}
	$listaEmpresa = $op->fastQuerie("admponto.empresa",$filtroEmpresa,"id");
	
	
	
	
Util::CarregaComboArray( $listaEmpresa,"id","nome", $registro["idEmpresa"]);   ?> 
			
			</select><br>
			
	</td>
	</tr>
<? } else { ?>

<input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo  Util::NVL($registro["idEmpresa"], $op->getGroup("min","admponto.empresa","id","") )  ?>">

<? } ?> 

<?	




if (SessionFacade::getPerfil() == 3  ||
		( $registro["id_coordenador"] != "" && $registro["id"] != ""
			&& $op->getGroup("count","spp.usuario","*"," id = ".$registro["id_coordenador"].
				" and perfil in (3,4) ") == 0
	  ) ) {  ?>
	<?php if ( $registro["id_coordenador"] != "" )
	{ 
		
	?> 
	 <tr> 
	
	 <td height="18" >
		<?php 
		
		$Meusgerentes = UsuarioSPP::getGerente($registro["id_coordenador"], "idPai", true);
		
		
		//print_r(  $Meusgerentes  );
		
		if (count($Meusgerentes) <= 1 && 
				UsuarioSPP::getGerente( $registro["id_coordenador"], "idPai") != "")
		{
			echo "" . $oUsuario->getProp( 
					UsuarioSPP::listarUsuarios(UsuarioSPP::getGerente( $registro["id_coordenador"], "idPai"))->fetchAll(),"nmperfil").
				": <br>".
				" <span class='t-bold' > ".
				$oUsuario->getProp( 
					UsuarioSPP::listarUsuarios(UsuarioSPP::getGerente( $registro["id_coordenador"], "idPai"))->fetchAll(),"nome") .
				"</span>
					<input type='hidden' id_gerente value='".UsuarioSPP::getGerente( $registro["id_coordenador"], "idPai")."'>
					</td></tr><tr><td height='18' >";
			
			
		}
		if ( count($Meusgerentes) > 1 ){ ?>
			
			 Gerente:<br>
			<select id="idGerente" name="id_gerente"  style="width:400px;"   >
			<?php 
			$gerente = Util::NVL( $registro["id_gerente"],"" );
			
			Util::CarregaComboArray($Meusgerentes, "idgerente","nome",$gerente);   			
					?> 
			
			</select>
			<br><br>
			
			
			
		<? }
		
		 ?>Solicitante - 
		<?php  echo $oUsuario->getProp( 
	        UsuarioSPP::listarUsuarios( $registro["id_coordenador"])->fetchAll(),"nmperfil")  ?>:<br>
	 <span class="t-bold" > 
	  <?php  echo $oUsuario->nomeUsuario( $registro["id_coordenador"]);  ?>
	  <input type="hidden" name="id_coordenador" value="<?php echo $registro["id_coordenador"] ?>">
	

	

</td>
	</tr>
	 <?php  }	?>
<?php } else { 
	
	
	 ?> 
	  <tr> 
	
	 <td height="18" >
	          Gerente:<br><a name="Agerente"></a>
			<select id="id_gerente" name="id_gerente"  style="width:400px;" 
			 onchange="carregaForm(this)" >
	<?php 
	$gerente = Util::NVL( $registro["id_gerente"],"" );
	
	
	
	if ( $registro["id_gerente"] == "" && 
			UsuarioSPP::getGerente( $registro["id_coordenador"], "idPai") != "" )
		$gerente =  UsuarioSPP::getGerente( $registro["id_coordenador"], "idPai");
	
	$filt = "";
	
	if (SessionFacade::getPerfil() == 4 ) //Gerente..
	{
		$filt = " and u.id in (  " . SessionFacade::getIdLogado() .",". Util::NVL($gerente, "0" ). ") ";
		
	}
	/*if ( $idEmpresa != "" ){
	        $filt .= " and col.\"idEmpresa\" = ". $idEmpresa;	
	}*/
	//echo  $registro["idGerente"]. "---". $gerente ."----".
	//	$registro["idSolicitante"]; die("");
	
	
	
	
	
	Util::CarregaComboArray(
			UsuarioSPP::listarUsuarios("",array("u.nome")," and perfil = 4 ". $filt)->fetchAll(),
			"id","nome",$gerente,true);   
	
	if (SessionFacade::getPerfil() == 4 ) //Gerente..
	{
		if ( $gerente =="")
			$gerente = SessionFacade::getIdLogado();
	}	
	
					?> 
			
			</select>
	</td>
	</tr><tr><td height="18" >
			    Coordenador:<br>
			<select id="id_coordenador" name="id_coordenador" style="width:400px;" onchange="" >
	<?php 
	$coord = $registro["id_coordenador"];
	$filt = "";
	if ( $gerente != "" ) 
		$filt = ' and u.id in ( select "idFilho" from spp.usuario_pai where "idPai"  = '.$gerente.')  ';
	
	Util::CarregaComboArray(
			UsuarioSPP::listarUsuarios("",array("u.nome")," and perfil = 3 ". $filt)->fetchAll(),
					 "id","nome",$coord,true);   ?> 
			
			</select><br>
			
	</td>
	</tr>
	 <?php  }	?>