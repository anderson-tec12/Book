<?
//require_once("IDbPersist.php");
//require_once("connAccess.php");
//require_once("PostGreSQLConnection.php");
//require_once("../library/Util.php");

//
//$oConn = new MySQLConnection();

class Resumo {
	
	
	public static function getIDNegocioFechado(IDbPersist $oConn){
		
		$ar = connAccess::fastOne($oConn,"cadastro_basico"," id_tipo_cadastro_basico = 7 and descricao like '%Neg%' and descricao like '%Fechado%' ");	
		
		if ( count($ar) > 0 ){
			return $ar["id"];	
		}
		
		return "";
	}
	
	/*public static function filtroClienteNegocio(IDbPersist $oConn, $coluna = "status"){
		
		$id = Resumo::getIDNegocioFechado($oConn);
		
		if ( $id == "")
			return "";
		
		return " and " . $coluna . " = " . $id;
		
	}
	*/
	
	public static function getFiltroParaPerfilInspecao(IDbPersist $oConn, $alias_inspecao = "i.", $comfiltroChecklist = true){
		$filtro ="";
		if ( SessionFacade::ehPerfil( SessionFacade::PerfilCliente ) ) { 
			
			$filtro .= " and ".$alias_inspecao."id_cliente = " . Util::NVL(  SessionFacade::getIDPerfil()," 0 ");
			
			if ( SessionFacade::getProp("nivel") != 1 &&  SessionFacade::getProp("unidades") != ""){
				
				$filtro .= " and ".$alias_inspecao."id_estabelecimento in ( " . SessionFacade::getProp("unidades") .") " ;
			}
			return $filtro;
		}
		
		if ( SessionFacade::ehPerfil( SessionFacade::PerfilTecnico ) 
				|| SessionFacade::ehPerfil( SessionFacade::PerfilAgenteComercial ) 
				|| SessionFacade::ehPerfil( SessionFacade::PerfilFranquia ) 
				|| SessionFacade::ehPerfil( SessionFacade::PerfilSupervisor ) 
				|| SessionFacade::ehPerfil( SessionFacade::PerfilTecnico ) 
			
			
			) { 
			if ( SessionFacade::getProp("nivel") != 1 &&  SessionFacade::getProp("unidades") != ""){
				
				$filtro .= " and ".$alias_inspecao."id_estabelecimento in ( " . SessionFacade::getProp("unidades") .") " ;
				
				//return $filtro;
			}			
		}
		
		
		if ( $comfiltroChecklist ){
			if ( 
				SessionFacade::ehPerfil( SessionFacade::PerfilSupervisor ) 
					|| SessionFacade::ehPerfil( SessionFacade::PerfilTecnico ) 		
				) { 
				
				$checklist = connAccess::executeScalar($oConn," select checklists from usuario where id = " . 
						SessionFacade::getIdLogado());
				
				if ( $checklist != ""){
					
					$filtro .= " and ".$alias_inspecao."id_modelo in ( " . $checklist .") " ;
					
				}			
			}
		}
		
		return $filtro;
	}
	
	
	
	public static function SqlInspecao(){
		
		$sql = " select i.*, c.nome as nome_cliente, 
		               case when e.cidade is not null and e.estado is not null then 
					        concat(e.nome,' / ',e.cidade,' - ',e.estado) 
						else
						    e.nome
						end as nome_estabelecimento
						,
		                   
		 u.nome as nome_responsavel,
		                md.nome as nome_checklist
		                 from inspecao i left join cliente c on c.id = i.id_cliente
		                left join  estabelecimento e on e.id = i.id_estabelecimento
						left join nutricionista u on u.id = i.id_resp_controllare 
						left join modelo_checklist md on md.id = i.id_modelo ";
						
		return $sql;
		
	}
	
	public static function log_Exclusao($tabela, $where, IDbPersist $oConn ){
		
		$regs = connAccess::fetchData($oConn, " select * from " . $tabela . " where " . $where);
		
		for ( $y = 0; $y < count($regs); $y++){
			
			$item = $regs[$y];
			
			$item["id_deleted"] = $item["id"];
			$item["data_deleted"] = Util::getCurrentBDdate();
			
			$item["id"] = "";
			
			connAccess::nullBlankColumns($item);
			connAccess::removeIntegerColumns($item);
			
			connAccess::Insert($oConn,$item,$tabela."_deleted","id",true);
		}
		
	}
	
	public static function SqlItemInspecao(){
		
		$sql = " select ipit.*, c.nome as nome_cliente, 
		                       case when e.cidade is not null and e.estado is not null then 
					           concat(e.nome,' / ',e.cidade,' - ',e.estado) 
						    else
						       e.nome
					     	end as nome_estabelecimento
		               
					    from relatorio i left join cliente c on c.id = i.id_cliente
		                left join  estabelecimento e on e.id = i.id_estabelecimento
						left join inspecao_item ipit on ipit.id_inspecao = i.id ";
		
		return $sql;
		
	}
	
	
	public static function SqlRelatorio(){
		
		$sql = " select i.*, c.nome as nome_cliente, 
		                       concat(e.nome,' / ',e.cidade,' - ',e.estado) as nome_estabelecimento
		                 from relatorio i left join cliente c on c.id = i.id_cliente
		                left join  estabelecimento e on e.id = i.id_estabelecimento ";
		
		return $sql;
		
	}
	
	
	
	
	public static function calculaDados(IDbPersist $oConn, $id, $registro){
		
		
		$categorias = connAccess::fetchData($oConn," select * from inspecao_item where id_inspecao = " . 
			$id. " and id_item is null order by ordem ");
			
			
		
		$total_categoria = 0;
		$total_pesos = 0;
		$total_pesos_categoria = 0;
		$total_nota_peso_categoria = 0;
		
			
		for ( $y = 0 ; $y < count($categorias); $y++){    
			
			$item_c = $categorias[$y];
			$sub_categoria = 0;
			$divide_categoria = 0; 
			
			$itens = connAccess::fetchData($oConn," select * from inspecao_item where id_inspecao = " . 
				$id. " and id_item is not null and id_categoria = " . $item_c["id_categoria"] . " order by ordem, id ");
				
			$peso_categoria = connAccess::executeCommand( $oConn," select peso from peso where id in ( select campo1 from 
						cadastro_basico where id = " . Util::NVL( $item_c["peso"], "0").") ");
			
			if ( $peso_categoria == "" || is_null($peso_categoria))
				$peso_categoria = 1;
				
				
			for ( $zz = 0; $zz < count($itens); $zz++){
				
				$item = $itens[$zz ];
				
				
				if ( $item["nota"] < 0 )
					continue;
				
				$peso = connAccess::executeCommand( $oConn," select peso from peso where id in ( select campo1 from 
					   cadastro_basico where id = " . $item["id_item"].") ");
					
				if ( $peso == "" || is_null($peso))
					$peso = 1;
					
					
				$sub_categoria+= @($peso * $item["nota"]);
				$divide_categoria+= $peso;
				$total_categoria += @($peso * $item["nota"]);
				
				echo("<br>Peso: ". $peso . ", Nota: " . $item["nota"]);
				
				$total_pesos+= $peso;
			}
			/*die("-->". $sub_categoria . " - " . $divide_categoria. " - " . connAccess::executeScalar($oConn," select nome
					 from categoria where id = " . $item_c["id_categoria"])
				);*/
			//$item_c["nota"] = round(  @($sub_categoria / $divide_categoria) , 2 );
			
			$total_pesos_categoria += $peso_categoria;	
			$total_nota_peso_categoria += @($sub_categoria / $divide_categoria) * $peso_categoria;
			
			$item_c["nota"] = @($sub_categoria / $divide_categoria);
			
			connAccess::nullBlankColumns( $item_c );
			connAccess::Update( $oConn, $item_c, "inspecao_item", "id");
			
		}
		//die("-->" . $total_categoria . " -> " . $total_pesos);
		//$registro["nota_final"] = round(  @( $total_categoria / $total_pesos )  , 2 );
		
		$registro["nota_final"] = round(  @( $total_nota_peso_categoria / $total_pesos_categoria )  , 2 ); //Resultado da NOTA..
		connAccess::nullBlankColumns( $registro );
		
		
		connAccess::Update( $oConn, $registro, "inspecao", "id");
		
	}
	
	
	
	  public static function consultaPolitico( IDbPersist $oConn, $comp = "" 	){
		
		$sql = " select concat(p.nome, ' - ',carg.descricao,' - ', part.descricao) as descr, p.*, part.descricao as partido, carg.descricao as cargo
		         from politico p left join cadastro_basico carg on carg.id = p.id_cargo 
		         left join cadastro_basico part on part.id = p.id_partido where 1 = 1 ". $comp;
				 
				 
		return connAccess::fetchData( $oConn, $sql );		 
		
		
	 }
	
	public static function getSQLIDCliente( $id_item, $tipo){
		
		$sql = " select id_cliente from cliente_item where id_item = ". $id_item. " and tipo_item='". $tipo."' ";
		
		return $sql;
		    
	}
	
	
	public static function consultaEmissora( IDbPersist $oConn, $comp = "" 	){
		
		$sql = " select *, case when e.tipo = 'RD' then 'Rádio' else 'TV' end as str_tipo from emissora e where 1 = 1 ". $comp;
		
		//echo( $sql );
		return connAccess::fetchData( $oConn, $sql );		 
		
		
	}
	
	//Obtém a propriedade de um cadastro associado.
	public static function getPropriedadeAssociacaoCadastros( IDbPersist $oConn,$id_pai, $classificacao, $id_filho, $propriedade = "id"	){
		
		if ( $id_pai == "" )
			return "";
			
		
		if ( $id_filho == "" )
			return "";
		
		$sql = " select ".$propriedade." from associacao_cadastros where id_pai = " . Util::NVL($id_pai," 0") . " and 
				classificacao='".$classificacao."' and id_filho = ". $id_filho;
		
		//die ( $sql );	
		
		$ar = connAccess::fetchData($oConn, $sql);
		
		$ids = Util::arrayToString($ar,$propriedade,",");
		
		return $ids;
		
	}
	
	 
	public static function getIDsFilhoItens( IDbPersist $oConn,$id_pai, $classificacao	){
	 
		$sql = " select id_filho from associacao_cadastros where id_pai = " . Util::NVL($id_pai," 0") . " and 
	                        classificacao='".$classificacao."' ";
							
						//die ( $sql );	
	    
		$ar = connAccess::fetchData($oConn, $sql);
		
		$ids = Util::arrayToString($ar,"id_filho",",");
		
		return Util::NVL( $ids, " 0 " );
	 
	 }
	
	
	public static function deletaItens(IDbPersist $oConn,$id_pai,$classificacao){
	
		connAccess::executeCommand($oConn,"delete from associacao_cadastros where 	id_pai = " . $id_pai .  " and classificacao='".$classificacao."' ");
	
	}
	
	public static function salvaItens(IDbPersist $oConn,$id_pai,$id_filho, $tabela_pai,
		$tabela_filho, $classificacao, $tipo_pai = "", $tipo_filho= "", $excluir = true){
		//
        //id_pai, tabela_pai, tipo_pai, id_filho, tabela_filho, tipo_filho, classificacao
		$ids_nova = " 0 ";
		$ids = explode(",",Util::NVL($id_filho,$ids_nova));
		
		for ( $y = 0; $y < count($ids); $y++){
			
			$id_item = $ids[$y];
			
			if ( $id_item == "" )
				continue;
				
				
			$item = connAccess::fastOne($oConn,"associacao_cadastros"," id_pai = " . $id_pai. " and id_filho = " . $id_item. " and classificacao='".$classificacao."'
			 and tabela_pai = '".$tabela_pai."' ");
			
			if ( ! is_array($item))
			{
				$item = $oConn->describleTable("associacao_cadastros");
				$item["id_pai"] = $id_pai;
				$item["id_filho"] = $id_item;
				
				$item["classificacao"] = $classificacao;
				$item["tabela_pai"] = $tabela_pai;
				$item["tabela_filho"] = $tabela_filho;
				
				
				$item["tipo_pai"] = $tipo_pai;
				$item["tipo_filho"] = $tipo_filho;
				
				
				connAccess::nullBlankColumns( $item );
				
				$id_tmp = connAccess::Insert($oConn, $item, "associacao_cadastros","id",true);
				
				$ids_nova .= ", " . $id_tmp;
				
			}else{
				
				$item["tabela_pai"] = $tabela_pai;
				$item["tabela_filho"] = $tabela_filho;
				
				
				$item["tipo_pai"] = $tipo_pai;
				$item["tipo_filho"] = $tipo_filho;
				
				connAccess::nullBlankColumns( $item );
				
				connAccess::Update($oConn, $item, "associacao_cadastros","id");
				
				$ids_nova .= ", " . $item["id"];
			}
			
			
		}
		if ( $excluir ){
			connAccess::executeCommand($oConn,"delete from associacao_cadastros where 	id_pai = " . $id_pai .  " and classificacao='".$classificacao."'  and tabela_pai = '".$tabela_pai."' 
						and id not in ( " . $ids_nova .") ");
		}
				 
	}
	
	
	
	public static function filtroClienteNegocio(IDbPersist $oConn, $coluna = "status"){
		
		$id = Resumo::getIDNegocioFechado($oConn);
		
		if ( $id == "")
			return "";
		
		$alias = "";	
		if (  strpos(" ".$coluna,"." ) ){
			
			$ar = explode(".",$coluna);
			$alias = @$ar[0];
			
			if ( trim(@$ar[0]) != "")
				$alias = ".".@$ar[0];
		}
		
		$id_perfil = SessionFacade::getProp("loginrede");
		
		$filtrocompleta = "";
		if ( $id_perfil == "2" || $id_perfil == "4" || $id_perfil == "5" || $id_perfil == "6"){
			
			$unidades = connAccess::executeScalar( $oConn, " select unidades from usuario where id = " . SessionFacade::getIdLogado() ); 
			
			if ( $unidades == "" ){ $unidades = " 0 "; }
			
			$filtrocompleta = " and ".$alias."id in ( select id_cliente from estabelecimento where id in ( ".$unidades.") ) ";
		}
		
		
		return " and " . $coluna . " = " . $id . $filtrocompleta;
		
	}
	public static function filtroUnidade(IDbPersist $oConn, $id = ""){
		
		
		$id_perfil = SessionFacade::getProp("loginrede");
		
		$filtrocompleta = "";
		if ( $id_perfil == "2" || $id_perfil == "4" || $id_perfil == "5" || $id_perfil == "6"){
			
			$unidades = connAccess::executeScalar( $oConn, " select unidades from usuario where id = " . SessionFacade::getIdLogado() ); 
			
			if ( $unidades == "" ){ $unidades = " 0 "; }
			if ( $id == "" ){
				$filtrocompleta = " and ".$alias."id in (  ".$unidades.")  ";
			}else{
				$filtrocompleta = " and ( ".$alias."id in (  ".$unidades.") or ". $alias."id = ". $id . " )  ";
				
			}
		}
		
		
		return $filtrocompleta;
		
	}
	
	
	public static function filtroSupervisorTecnico(IDbPersist $oConn, $id = ""){
		
		
		$id_perfil = SessionFacade::getProp("loginrede");
		
		$filtrocompleta = "";
		if ( $id_perfil == "2" || $id_perfil == "4" ){
			
			$unidades = connAccess::executeScalar( $oConn, " select checklists from usuario where id = " . SessionFacade::getIdLogado() ); 
			
			if ( $unidades == "" ){ $unidades = " 0 "; }
			if ( $id == "" ){
				$filtrocompleta = " and ".$alias."id in (  ".$unidades.")  ";
			}else{
				$filtrocompleta = " and ( ".$alias."id in (  ".$unidades.") or ". $alias."id = ". $id . " )  ";
				
			}
		}
		
		
		return $filtrocompleta;
		
	}
	

	
	static function getNomeCadBasico(IDbPersist $oConn, $id ){
		
		if ( $id == "")
			return "";
			
		$ar = connAccess::fastOne($oConn,"cadastro_basico"," id = " . $id);	
		
		if ( count($ar) > 0 ){
			return $ar["descricao"];	
		}
		
		return "";
		
	}
	
	static function getListaCadBasico(IDbPersist $oConn, $idTipo, $comp = "" ){
		
		if ( $idTipo == "")
			return "";
		
		$ar = connAccess::fastQuerie($oConn,"cadastro_basico"," id_tipo_cadastro_basico = " . $idTipo. $comp, "descricao");	
		
		return $ar;
		
	}
	
	static function getNomeTipoCadBasico(IDbPersist $oConn, $id ){
		
		if ( $id == "")
			return "";
		
		$ar = connAccess::fastOne($oConn,"tipo_cadastro_basico"," id = " . $id);	
		
		if ( count($ar) > 0 ){
			return $ar["descricao"];	
		}
		
		return "";
		
	}
	

	
	
}



?>