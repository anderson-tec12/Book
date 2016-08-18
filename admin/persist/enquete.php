<?php

function agrupaEnquete(IDbPersist $oConn, $id_enquete, $campo = "numero"){
	

	$filtro = " id_enquete = " . $id_enquete;

	$lista = populaOpcoes($oConn, $id_enquete );
	
	if ( count($lista) <= 0 )
		return;
		
	
	
		
	$ini = $lista[0];
	$ordem_fim = $lista[count($lista) -1 ][$campo];
	
	
	if ( request("debug") == "1" ){
		echo("<br>". $ordem_fim . " -> " . count($lista)."<br>" );
		print_r( $ini ); echo("<br>");
	}
	
	//print_r( $lista ); echo("<br>". $ordem_fim . "<br>");;
	$saida = array();
	
	$eh_igual = true;
	
	$ultima = $lista[0][$campo];
	$inicio = $lista[0][$campo];
	
	for ( $y = 1; $y < count($lista); $y++){
		
		$item2 = $lista[$y];
		
		if ( strtoupper( trim($ini["opcoes"])) == strtoupper( trim($item2["opcoes"]))){
		 //É igual, vamos continuar..	
			if ( request("debug") == "1" ){
				echo("<br><br>igual?<br><br>");
			}	
			//echo("<br><br>igual?<br><br>");
			$ultima = $item2[$campo];
		}else{
		    
			$saida[ count($saida) ] = array("ini"=>$inicio,"fim"=>$ultima);   
			
			$inicio = 	$item2[$campo];
			$ini = $item2;
			$ultima = $item2[$campo];
			
			if ( $y == count($lista) -1 ){
				
				$saida[ count($saida) ] = array("ini"=>$inicio,"fim"=>$ultima); 
				
			}
			
		}
		
	}
	
	if ( count($saida) <= 0 ){
		
		$saida[ count($saida) ] = array("ini"=>$inicio,"fim"=>$ultima); 
	}
	
	if ( request("debug") == "1" ){
		print_r($saida);
	}
	
	//print_r($saida);die("<<");
	/*$lista = connAccess::fastQuerie($oConn, "pergunta",$filtro,"ordenacao_pergunta asc");

	$saida = array();

	if ( count($lista) <= 0 )
		return $saida;

	$ini = $lista[0];
	
	$ordem_fim = $lista[count($lista) -1 ]["numero"];
	

	//print_r( $lista );die("<<"... $ini["ordem"]);
	for ( $y = $ini["numero"]; $y <= $ordem_fim; $y++){
		
		$ultima = getUltimaIgual($oConn, $ini, $ordem_fim);
		
		$saida[ count($saida) ] = array("ini"=>$y,"fim"=>$ultima);
		
		$y = $ultima + 1;
		
		
		$ini = connAccess::fastOne($oConn,"pergunta", " id_enquete = " . $id_enquete . " and cast(numero as UNSIGNED) >= " . $y + " limit 0,1 ");
		
		if ( count($ini)<= 0 )
			break;
		
	}
	*/
	
	return $saida;
	
	
	
	
}

function populaOpcoes(IDbPersist $oConn, $id_enquete){
	
	$filtro = " id_enquete = " . $id_enquete;
  
	$filtro .= " and  IfNull(layout,'') not in ('TXT') ";
	
	//$lista = connAccess::fastQuerie($oConn, "pergunta",$filtro,"ordenacao_pergunta asc");
	$sql = " select * , '' as opcoes from pergunta where " . $filtro . " 
	
	           order by ordenacao_pergunta asc";
			
	if ( request("debug") == "1" ) 
		echo ("<br><br>". $sql );
			
	$lista = connAccess::fetchData($oConn, $sql);
	
	for ( $y = 0; $y < count($lista); $y++){
		
		$item = &$lista[$y];
		
		if ( trim($item["id"]) == "" )
			continue;
		
		//print_r($item);die("<<");
		$opcoes = connAccess::fetchData($oConn,"select titulo from opcoes where id_pergunta = " . Util::NVL( $item["id_grupo_item"], "0 "). " order by ordem ");
		
		$item["opcoes"] = Util::arrayToString($opcoes,"titulo",",");
		
	}
	
	return $lista;
}

function getUltimaIgual(IDbPersist $oConn, $reg_inicio, $ultima_perg_enquete){
	
 // primeiro, pego minhas opçoes já existentes..	
   

	$opcoes = connAccess::fetchData($oConn,"select * from opcoes where ifNull(id_grupo_item,0) = " . Util::NVL(  $reg_inicio["id_grupo_item"]," 0 "). " order by ordem ");
	
	$ultima_encontrada = $reg_inicio["numero"];
	
	for ( $y =0; $y < count($opcoes); $y++){
		
		$ar_it = $opcoes[$y];	
		
	}
	
	for ( $y =($reg_inicio["numero"]+1); $y <= $ultima_perg_enquete; $y++){
		
		
		
		
		$perg = connAccess::fastOne($oConn,"pergunta", " id_enquete = " . $reg_inicio["id_enquete"] . " and cast(numero as UNSIGNED) >= " . $y," ordenacao_pergunta limit 0, 1 ");
		
		
		
		//print_r($opcoes2);die("<<<");
		if ( count($perg) > 0 ){
			
			
			$opcoes2 = connAccess::fetchData($oConn,"select * from opcoes where id_grupo_item = " . $perg["id_grupo_item"]. " order by ordem ");
			
			if ( count($opcoes2) != count($opcoes) ){
				return $ultima_encontrada;	
			}
			
			
			for ( $y =0; $y < count($opcoes); $y++){
				
				$ar_it = $opcoes[$y];
				
				$ar_testa = connAccess::fetchData($oConn,"select * from opcoes where id_grupo_item = " . $perg["id_grupo_item"]. " and trim(upper(titulo)) = trim(upper('".
					
					$ar_it["titulo"]."')) order by ordem ");
				
				if ( count($ar_testa) <= 0 ){
					return	$ultima_encontrada;
				}	
					
				
			}
			echo ( $ultima_encontrada );die("<<<");
			//Temos as mesmas opções. vamos então jogar isso aqui..
			$ultima_encontrada = $y;
			
			
		}
	}
}

?>
