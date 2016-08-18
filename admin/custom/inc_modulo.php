<?

class inc_modulo {
    
      static function getLinkAbrirNovoModulo( $modulo  ){
          
             if (is_array($modulo) && count($modulo) > 0 ){
             
                            if ( @$modulo["pasta"] != "" && @$modulo["url_abrir"] != ""){

                                $abrir_como = Util::NVL( @$modulo["url_abrir_como"],"Painel");

                                $pagina = "painel_controle.php";

                                if ( $abrir_como == "Popup"){

                                    $pagina = "pop_index.php";
                                }

                                //$id =  $item["id_registro"];
                                $pagina .= "?mod=". $modulo["pasta"]."&pag=" . $modulo["url_abrir"]."&cnt=1&xct=1";

                                return $pagina;
                            }
             
             
         }
      }
    
    static function getLinkAbrirModulo( $modulo , $item ){
        
         
         if (is_array($modulo) && count($modulo) > 0 ){
             
             if ( @$modulo["pasta"] != "" && @$modulo["url_visualizar"] != ""){
                 
                 $abrir_como = Util::NVL( @$modulo["url_visualizar_como"],"Painel");
                 
                 $pagina = "painel_controle.php";
                 
                 if ( $abrir_como == "Popup"){
                     
                     $pagina = "pop_index.php";
                 }
                 
                 $id =  $item["id_registro"];
                 $pagina .= "?mod=". $modulo["pasta"]."&pag=" . $modulo["url_visualizar"]."&id=". $id."&acao=LOAD&cnt=1&id_ticket=". $item["id_ticket"]."&cnt=1&xct=1";
                 
                 return $pagina;
             }
             
             
         }
         
         return "";
         
//               $caminho =  K_DIR_PAINEL ."modulos". DIRECTORY_SEPARATOR.  $modulo["codigo"] . DIRECTORY_SEPARATOR. "inc_" . $codigoFerramenta.".php";
//
//                    if (file_exists($caminho)){
//
//                            return "painel_controle.php?pag=inc_".$codigoFerramenta."&comp=".$codigoFerramenta;
//                    }
//
//                     $caminho =  K_DIR_PAINEL ."ferramentas".DIRECTORY_SEPARATOR. $codigoFerramenta .DIRECTORY_SEPARATOR. "pop_" . $codigoFerramenta.".php";
//
//                    if (file_exists($caminho)){
//
//                            return "pop_index.php?pag=".$codigoFerramenta."&comp=".$codigoFerramenta;
//                    }

         
         
         
//        switch ($codigoFerramenta) {
//            case 'causa_efeito':
//                return "painel_controle.php?pag=inc_causa_efeito&comp=causa_efeito&cnt=1&xct=1";
//            case 'competencia':
//                return "painel_controle.php?pag=inc_competencia_novo_acordo&comp=competencias&cnt=1";
//            case 'conduta':
//                return "pop_index.php?pag=tipo_codigo_conduta&comp=conduta";
//            case 'penalidade':
//                return "pop_index.php?pag=penalidade_consentimento&comp=penalidades";
//            case 'ponderacao_valor':
//                return "painel_controle.php?pag=inc_novo_card&comp=ponderador_valores_morais&cnt=1";
//            case 'relato_contexto':
//                return "painel_controle.php?pag=inc_relato_contexto&comp=relato_contexto&cnt=1";
//            case 'linha_tempo':
//                return "painel_controle.php?pag=inc_linha_tempo&comp=linha_tempo&cnt=1";
//            case 'atenuante_agravante':
//                return "pop_index.php?pag=atenuante_agravante_tipo_uso&comp=atenuantes_agravantes";
//            case 'proposicoes_agressivas':
//                return "painel_controle.php?pag=inc_proposicoes_agressivas_novo_card&comp=proposicoes_agressivas&cnt=1";
//            case 'nao_entendi':
//                return "painel_controle.php?pag=inc_nao_entendi&comp=nao_entendi&cnt=1";
//            case 'decisoes_coletivas':
//                return "pop_index.php?pag=decisoes_coletivas_importante1&comp=decisoes_coletivas";
//            case 'mapa_kappa':
//                return "painel_controle.php?pag=inc_mapa_kappa&comp=mapa_kappa&cnt=1";
//            case 'proposicoes_conciliadoras':
//                return "painel_controle.php?pag=inc_proposicoes_conciliadoras_novo_card&comp=proposicoes_conciliadoras&cnt=1";
//            case 'conflito':
//                return "pop_index.php?pag=conflito&comp=conflito";
//            default :
//                
//             
//                return "";
//        }
        
        
        
    }
    
    

    static function saveModulo($registro) {
        
        global $oConn;

        connAccess::nullBlankColumns($registro);

        if (!@$registro["id"]) {
            $registro["id"] = connAccess::Insert($oConn, $registro, "modulo", "id", true);
        } else {
            connAccess::Update($oConn, $registro, "modulo", "id");
        }

        return $registro["id"];
    }

    static function findAllModulos($fase = "") {

        global $oConn;

        $filtro = "";
        
        if ( $fase != "")
            $filtro .= " where fase='". $fase."' ";
        
        $sql = "Select * from modulo ".$filtro." order by codigo";

        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    static function findModuloById($id) {

        global $oConn;

        $sql = "Select * from modulo where id = " . $id;

        $modulo = connAccess::fetchData($oConn, $sql);

        if ($modulo !== null && count($modulo) > 0) {
            return $modulo[0];
        }
    }

    static function findModuloByCodigo($codigo) {

        global $oConn;

        $sql = "Select * from modulo where codigo = '" . $codigo . "'";

        $result = connAccess::fetchData($oConn, $sql);

        if ($result !== null && count($result) > 0) {
            return $result[0];
        }
    }

}

?>