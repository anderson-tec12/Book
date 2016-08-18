<?php


class SessionCliente
{	
	

	public static  $propriedadeSessao = "usSes_Site";
	public static  $propriedadeSessaoMsg = "usSes_Site_msg";
	
        
        
        
        public static function getJoomlaSession(){
					
			if ( isset( $GLOBALS[SessionCliente::$propriedadeSessao] ) )
                     return $GLOBALS[SessionCliente::$propriedadeSessao];			
					
			if ( ! defined('_JEXEC') ){					
                           define( '_JEXEC', 1 );
                        }
			if ( ! defined('JPATH_BASE') ){					
                             define('JPATH_BASE', K_JOOMLABASE );   //dirname(dirname(__FILE__))
			}
			if ( ! defined('DS') ){	
                            define( 'DS', DIRECTORY_SEPARATOR );
			}

                    require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
                    require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');

					
                    $mainframe = JFactory::getApplication('site');
			
                    $session     = JFactory::getSession();
		             
					 //print_r ( $session )	;
                     // die ( " rrend ");
			
                    $GLOBALS[SessionCliente::$propriedadeSessao]	= 	$session;	
			
                    return $session;           
            
        }
        
        public static function getJoomlaUser(){
            
                $sessao = SessionCliente::getJoomlaSession();
		$ar = $sessao->get(SessionCliente::$propriedadeSessao)   ;
                
                return $ar;
            
        }
        
        public static function setMensagem($msg ){            
                $sessao = SessionCliente::getJoomlaSession();                
                $sessao->set( SessionCliente::$propriedadeSessaoMsg, $msg  );
        }
        
        public static function getMensagem(){
            
                $sessao = SessionCliente::getJoomlaSession();
                return $sessao->get( SessionCliente::$propriedadeSessaoMsg );
             
        }
	
	public static function registraUsuario($id, $login, $nome, $email, $perfil, 
	       $extra_dados = "")
	{
		$ar = array("id"=>$id,
			"login"=>$login,
			"nome"=>$nome,
			"perfil"=>$perfil,
			"email"=>$email,
			"extra_dados"=>$extra_dados);
	
                $sessao = SessionCliente::getJoomlaSession();
                
                $sessao->set( SessionCliente::$propriedadeSessao, $ar );
		//$_SESSION[ SessionFacade::nomeSchema() ."_usSes" ] = $ar;			
		
	}
	
	public static function curPageMenuURL() {
            $pageURL = 'http';
            if ( @$_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
                            $pageURL .= "://";
                            if ($_SERVER["SERVER_PORT"] != "80") {
                             $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
                            } else {
                             $pageURL .= $_SERVER["SERVER_NAME"]; //.$_SERVER["REQUEST_URI"]
                            }
            return $pageURL;
}	
	
        
        public static function usuarioLogado()
	{
		
            $sessao = SessionCliente::getJoomlaSession();
		
		if (! isset( $sessao ))
			return 0;
		
		//print_r( $sessao  );die( " 000 " );
		$ar = $sessao->get(SessionCliente::$propriedadeSessao)   ;
		
		if (! isset( $ar ))
			return 0;
		
         //print_r( $ar  );die( " 000 " );      
		if ( @$ar["id"] == "")
			return 0;
		
		
		return 1;		
	}
        
        public static function getUserSession(){
            
                $sessao = SessionCliente::getJoomlaSession();
                
                return $sessao->get( SessionCliente::$propriedadeSessao );
        }
	
	
	
	public static function destroy()
	{		
                 $sessao = SessionCliente::getJoomlaSession();
                 
                 
                 $sessao->set("convite_id","");
                 $sessao->set("ticket_id","");
                 $sessao->set("msg","");
                 $sessao->set("ids_resposta","");
                 $sessao->set("id_enquete_atual","");
                 $sessao->set("id_enquete","");
		 $sessao->set( SessionCliente::$propriedadeSessao, "" );
                 //die("aaa ");
	}
	
        public static function setValorSessao( $coluna, $valor ){            
                $sessao = SessionCliente::getJoomlaSession();                
                $sessao->set( $coluna , $valor  );
        }
         public static function getValorSessao( $coluna  ){            
                $sessao = SessionCliente::getJoomlaSession();                
                return $sessao->get( $coluna );
        }
        
	public static function getPropriedade($prop = "nome")
	{
		$sessao = SessionCliente::getJoomlaSession();
                
                $ar = $sessao->get( SessionCliente::$propriedadeSessao );
		
		return @$ar[$prop];
		
	}
          public static function getPropriedadeOnMessage( $coluna ){
              
                 $msg = SessionCliente::getMensagem();
            
                if ( $msg != "" && strpos(" ". $msg,"#".$coluna.":")){

                    $ar = explode("#".$coluna.":", $msg );

                    $ar2 = explode("|", $ar[1]);

                    return $ar2[0];

                }
            
            return "";
          }
        
        
        public static function getIncludeUrlOnMessage(){
            
            $msg = SessionCliente::getMensagem();
            
            if ( $msg != "" && strpos(" ". $msg,"#include:")){
                
                $ar = explode("#include:", $msg );
                
                    $ar2 = explode("|", $ar[1]);
               
                    return $ar2[0];

                
            }
            
            return "";
                       //SessionCliente::setMensagem("#origem:convite|#convidado_por:". $convidado_por."|#include:inc_convidado_primeiro_acesso_email" );
            
            
        }
        
    
	
	
}




/* TODO: Add code here */

?>
