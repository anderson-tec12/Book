<?

class componente_template_newsletter {

    public static function findItensByIdTemplate($id) {
        
        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = "Select item.*,tipo.codigo from custom.item_template_newsletter item left join custom.tipo_item_newsletter tipo on tipo.id = item.id_tipo_item_newsletter where item.id_template_newsletter =" . $id . " order by item.ordem";

        return connAccess::fetchData($oConn, $sql);
        
        //print_r($itens);
        
    }
    
     static function get_list_tipo(){		  
		  $arr = array();		  
		  $str_lista = "protagonista||Primeira Parte,convidado||Convidado,antagonista||Antagonista";          
		  $ar = explode(",", $str_lista);		
		  
				  for ( $y = 0; $y < count($ar); $y++){		         
						 $col = explode("||", $ar[$y]);				 
						 $arr[ count($arr) ] = array("id"=>$col[0],"descr"=>Util::NVL( @$col[1], $col[0]) );		  
				  }
		  
		  return $arr;		  
    }          

}
?>