<?php
$cookie_propriedade = "cookie_user_prod";

class guardaSessao
{	
	public $nomeSchema = "itapoty_";
}

class SessionFacade
{	
	const PerfilAdministrador = 1;
	const PerfilTecnico = 2;
	const PerfilCliente = 3;
	const PerfilSupervisor = 4;
	const PerfilAgenteComercial = 5;
	const PerfilFranquia =6;
	
	
	public static function temPerfil($id){
	          
            return true;//mudar isso depois..
		return SessionFacade::ehPerfil($id);
			
			
		return false;	
	}
	
	public static function temAcessoAModulo($modulo ){
	    global $oConn;   
		
            return true;//mudar isso depois..
		$str_permitidos = "";
		
		$id_perfil = SessionFacade::getPerfil();
		
		if ( !array_key_exists( "_modulos", $_SESSION )   || @$_SESSION["_modulos"] == "" ){
			
			$ids_mods = Resumo::getIDsFilhoItens( $oConn, $id_perfil,"perfilxmodulosacesso");
			//echo ("oiii?". $ids_mods);
			if ( $ids_mods == "" )
			    $ids_mods = " 0 ";
			
			$ar = connAccess::fetchData($oConn, " select campo1 from cadastro_basico where id in ( " . $ids_mods .") ");
			
			$_SESSION["_modulos"] = Util::arrayToString($ar,"campo1",","); 
		}
		
		$str_permitidos = $_SESSION["_modulos"];
		//echo ( $str_permitidos );
		
		$meuArrayList = new ArrayList( explode(",", $str_permitidos )  );
		
		return $meuArrayList->contains( $modulo );	
		
		
	}
	
	
	public static function getIDPerfil( ){
	    
		if ( @$_SESSION["_id_perfil"] != "" )
			return   $_SESSION["_id_perfil"];   
		
		
		
		global $oConn;	
			
		if ( SessionFacade::ehPerfil( SessionFacade::PerfilCliente ) ){
			
			$_SESSION["_id_perfil"] = connAccess::executeScalar($oConn," select id_cliente from usuario where id = " . 
				SessionFacade::getIdLogado()); 
		}
		
		
		if ( SessionFacade::ehPerfil( SessionFacade::PerfilTecnico ) ){
			
			$_SESSION["_id_perfil"] = connAccess::executeScalar($oConn," select id_profissional from usuario where id = " . 
				SessionFacade::getIdLogado()); 
		}	
		
		if ( @$_SESSION["_id_perfil"] == "" )
			$_SESSION["_id_perfil"]= " 0 ";
			
		return $_SESSION["_id_perfil"];
		
	}
	
	
	public static function registraUsuario($id, $login, $nome, $perfil, 
	      $loginrede,$admin = false, $nivel="", $unidades = "")
	{
		$ar = array("id"=>$id,
			"login"=>$login,
			"nome"=>$nome,
			"perfil"=>$perfil,
			"loginrede"=>$loginrede,
			"admin"=>$admin,"nivel"=>$nivel,"unidades"=>$unidades);
		//print_r( $ar );die("");
		$_SESSION[ SessionFacade::nomeSchema() ."_usSes" ] = $ar;
                
                
                global $cookie_propriedade;                
                setcookie($cookie_propriedade, stripslashes( serialize($ar) ), (time() + (3 * 24 * 3600)));
                
                
		
	}
	
	public static function nomeSchema()
	{		
		$oses = new guardaSessao();	
		$nm =   $oses->nomeSchema;
		return $nm;	
	}
	public static function Admin()
	{		
		$ar = @$_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		return @$ar["admin"];
	}

	public static function destroy()
	{		
		unset( $_SESSION[SessionFacade::nomeSchema()."_usSes"] );	
	}
        
        public static function setResolution($x, $y){
            $_SESSION[SessionFacade::nomeSchema()."_RES_X"] = $x;
            $_SESSION[SessionFacade::nomeSchema()."_RES_Y"] = $y;
            
                setcookie(SessionFacade::nomeSchema()."_RES_X", $x, (time() + (3 * 24 * 3600)));
            
        }
	
        public static function getResolutionX(){
            
            $X =  @$_SESSION[SessionFacade::nomeSchema()."_RES_X"];
            
            if ( $X == "")
               $X =   @$_COOKIE[SessionFacade::nomeSchema()."_RES_X"];
            
            return $X;
        }
        
	public static function usuarioLogado()
	{
		
              global $cookie_propriedade;   
		
		if ( empty( $_SESSION[SessionFacade::nomeSchema()."_usSes"] )){
                    
                        $valor = array_keys($_COOKIE);
                        
                        if ( $valor != "" && array_key_exists($cookie_propriedade, $_COOKIE)){
                                $teste = stripslashes($valor[0]);
                                $ar = unserialize( stripslashes( $_COOKIE["cookie_user_prod"] ) );

                                $_SESSION[ SessionFacade::nomeSchema() ."_usSes" ] = $ar;
                        }
                    
                }
                
		
		if ( empty( $_SESSION[SessionFacade::nomeSchema()."_usSes"] ))
			return 0;
		
		$ar = $_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		//print_r( $ar );
		//die("");
		if ( $ar["id"] == "")
			return 0;
		
		
		return 1; 
		
	}
	
	public static function getPerfil()
	{
		
		$ar = @$_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		return @$ar["perfil"];
		
	}
	
		public static function getNome()
	{
		
		$ar = @$_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		return @$ar["nome"];
		
	}
	
	public static function ehPerfil($id){
		$ar = @$_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		
		global $oConn;
		
		$campo1 = connAccess::executeScalar($oConn,"select campo1 from cadastro_basico where id in ( " . 
			 $ar["perfil"].") ");
		
		//if ( $id == 3 )
		// die(">>".$campo1 .">>". $id .">>". strpos(" ".$campo1,$id) );
		return  $campo1 == $id;
	
	}
	
	
	public static function getNomeTipo(){
		
		if ( @$_SESSION[SessionFacade::nomeSchema()."_nome_perfis"] != "" )
			return $_SESSION[SessionFacade::nomeSchema()."_nome_perfis"];
		
		
		global $oConn;
		
		$ar = @$_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		
		$perfils = Util::arrayToString( connAccess::fetchData($oConn," select descricao from cadastro_basico where id in ( " . Util::NVL( SessionFacade::getPerfil()," 0 " ) . ") " ),"descricao",", ");
		//echo ( $perfils  );
		
		$_SESSION[SessionFacade::nomeSchema()."_nome_perfis"] =  $perfils;
		/*$saida = "";
		
		if (  strpos(" ".@$ar["perfil"],"1") ){
		       $saida .= "Administrador";
		}
		if (  strpos(" ".@$ar["perfil"],"2") ){
		
		       if ( $saida != "" )
			      $saida .= ", ";
		
		       $saida .= "Responsável";
		}
		
		if (  strpos(" ".@$ar["perfil"],"3") ){
		
		         if ( $saida != "" )
			      $saida .= ", ";
		
		       $saida .=  "Excutante";
		}
		*/
		return $perfils;
	
	}
	
	public static function getIdLogado()
	{
		
		$ar = @$_SESSION[SessionFacade::nomeSchema()."_usSes"] ;
		return @$ar["id"];
		
	}
	public static function getArrayUser()
	{
		return @$_SESSION[SessionFacade::nomeSchema()."_usSes"];
	}
	
	public static function setId($id )
	{
		if ( isset( $_SESSION[SessionFacade::nomeSchema()."_usSes"] ))
		{
			$_SESSION[SessionFacade::nomeSchema()."_usSes"]["id"] = $id;
		}
	}
	
	
	public static function getProp($id )
	{
		if ( isset( $_SESSION[SessionFacade::nomeSchema()."_usSes"] ))
		{
                    if (array_key_exists($id, $_SESSION[SessionFacade::nomeSchema()."_usSes"] )){
                    
			return @$_SESSION[SessionFacade::nomeSchema()."_usSes"][$id] ;
                    }
		}
                
                return "";
	}
	
	
}




/* TODO: Add code here */

?>