<?
//include functions to competicao_fase


             
             
            /// <summary> 
            /// Traz lista de opções para o campo Fase - fase
            /// </summary> 
            /// <returns></returns>             
                        
          function get_list_fase(){		  
		  $arr = array();		  
		  $str_lista = "01|01 - Acordos na fase estratégica,02|Acordos na fase de planejamento,03|Acordos na fase executiva,04|Acordos de início de competição,05|Acordos de pré-competição,06|Acordos de competição,07|Acordos de publicação,08|Acordos pós competição";          
		  $ar = explode(",", $str_lista);		
		  
				  for ( $y = 0; $y < count($ar); $y++){		         
						 $col = explode("||", $ar[$y]);				 
						 $arr[ count($arr) ] = array("id"=>$col[0],"descr"=>Util::NVL( @$col[1], $col[0]) );		  
				  }
		  
		  return $arr;		  
          }          
      
             
             
             


?>