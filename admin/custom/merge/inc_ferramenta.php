<?

class inc_ferramenta {

    static function listarTipoFerramenta() {

        $arr = array();
        $arr[count($arr)] = array("cod" => "analise", "descr" => "An�lise do Caso");
        $arr[count($arr)] = array("cod" => "aprimorar", "descr" => "Aprimorar os Relatos/Declara��es");
        $arr[count($arr)] = array("cod" => "visualizar", "descr" => "Visualiza��o das Atividades");
        $arr[count($arr)] = array("cod" => "administrar", "descr" => "Administrar seu Caso");
        $arr[count($arr)] = array("cod" => "negociacao", "descr" => "Negocia��o");

        return $arr;
    }

    static function listarFaseModulo() {

        $str = "Prepara��o, Pr� Media��o, Agenda, Abertura, Investiga��o da Disputa, Comunica��o de Compromissos, Alternativas, Negocia��o Final, Atendimento";

        $arr = explode(",", $str);
        $saida = array();
        for ($i = 0; $i < count($arr); $i++) {

            $id = $i + 1;
            $saida[count($saida)] = array("id" => $id, "cod" => "FASE_" . $id, "descr" => trim($arr[$i]));
        }
        return $saida;
    }

    static function findAllFerramenta($tipo_ferramenta = "") {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));


        $filtro = "";

        if ($tipo_ferramenta != "")
            $filtro .= " where tipo_ferramenta='" . $tipo_ferramenta . "' ";


        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 " . $filtro . " order by f.codigo";

        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    static function findFerramentaById($id) {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 where f.id =" . $id;

        $ferramenta = connAccess::fetchData($oConn, $sql);

        if ($ferramenta !== null && count($ferramenta) > 0) {
            return $ferramenta[0];
        }
    }

    static function findFerramentaByCodigo($codigo) {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 where f.codigo = '" . $codigo . "'";

        $ferramenta = connAccess::fetchData($oConn, $sql);

        if ($ferramenta !== null && count($ferramenta) > 0) {
            return $ferramenta[0];
        }
    }

    static function buscaFerramentasDeModeracao() {
        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 where f.ferramenta_moderacao = 't'";
        
        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    /*
     * Fun��o responsavel por retornar as ferramentas carregadas atrav�s de um array de ids
     * Rodrigo Augusto - 26/02/2015
     */

    static function carregarFerramentasByIds($ids) {
        if (!empty($ids) && is_array($ids)) {

            $ferramentas = array();

            for ($i = 0; $i < count($ids); $i++) {

                $idFerramenta = $ids[$i];

                if (!empty($idFerramenta)) {
                    array_push($ferramentas, self::findFerramentaById($idFerramenta));
                }
            }
            return $ferramentas;
        }
    }

    static function getNomeTabelaDebateByFerramenta($idFerramenta = "") {

        $ferramenta = null;

        if (!empty($idFerramenta)) {

            $ferramenta = inc_ferramenta::findFerramentaById($idFerramenta);

            // echo $ferramenta['codigo'];

            if (!empty($ferramenta)) {
                switch ($ferramenta['codigo']) {
                    case "penalidade":
                        return "penalidade";
                    case "ponderacao_valor":
                        return "ponderacao_valor";
                    case "conduta":
                        return "conduta";
                    case "competencia":
                        return "competencia";
                    case "atenuante_agravante":
                        return "atenuante_agravante";
                    case "proposicoes_agressivas":
                        return "proposicao_agressiva";
                    case "proposicoes_conciliadoras":
                        return "proposicao_conciliadora";
                    case "nao_entendi":
                        return "ticket_nao_entendi";
                    case "nao_sei":
                        return "ticket_nao_entendi";
                    case "causa_efeito":
                        return "causa_efeito";
                    case "relato_contexto":
                        return "relato_contexto";
                    case "conflito":
                        return "conflito";
                    default :
                        return "";
                }
            }
        }

        return "";
    }

    static function findFerramentasRelacionadas($ferramenta) {
        $ferramentasRelacionadas = array();

        if ($ferramenta != null && !empty($ferramenta['ferramentas_relacionadas'])) {
            $idsFerramentas = explode(",", $ferramenta['ferramentas_relacionadas']);

            foreach ($idsFerramentas as $id) {
                if (!empty($id)) {
                    $ferramentaRelacionada = self::findFerramentaById($id);
                    array_push($ferramentasRelacionadas, $ferramentaRelacionada);
                }
            }
        }

        return $ferramentasRelacionadas;
    }

    public static function isFerramentaPunidora($codigoFerramenta) {

        if ($codigoFerramenta == "conduta" || $codigoFerramenta == "proposicao_agressiva") {
            return TRUE;
        }

        return FALSE;
    }

    public static function isFerramentaRecompensadora($codigoFerramenta) {

        if ($codigoFerramenta == "competencia" || $codigoFerramenta == "proposicao_conciliadora") {
            return TRUE;
        }

        return FALSE;
    }

}

?>