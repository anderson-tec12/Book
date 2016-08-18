<?php
class JoomlaHack{
    
    
    public static function gethashPassword($senha){
        
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
        
         if (!class_exists("JUserHelper")){
             die("não achei essa classe!");
         }
        
                    return JUserHelper::hashPassword($senha);
        
    }
    
    
    
    
    
    
}