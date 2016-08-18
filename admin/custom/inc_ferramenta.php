<?

class inc_ferramenta {

    static function listarTipoFerramenta() {

        $arr = array();
        $arr[count($arr)] = array("cod" => "analise", "descr" => "Análise do Caso");
        $arr[count($arr)] = array("cod" => "aprimorar", "descr" => "Aprimorar os Relatos/Declarações");
        $arr[count($arr)] = array("cod" => "visualizar", "descr" => "Visualização das Atividades");
        $arr[count($arr)] = array("cod" => "administrar", "descr" => "Administrar seu Caso");
        $arr[count($arr)] = array("cod" => "negociacao", "descr" => "Negociação");

        return $arr;
    }

    static function listarTipoFerramentaPorTicket($id_ticket = "") {

        global $oConn;
        $tipos_ferramenta = self::listarTipoFerramenta();

        $sql = " select distinct fer.tipo_ferramenta
                                from acao_ticket a
                               left join componente c on c.id = a.id_componente
                               left join ferramenta fer on fer.codigo = c.codigo
                               left join icone ic on ic.id = fer.id_icone1
                               left join icone ic2 on ic2.id = fer.id_icone2
                           where fer.titulo is not null and fer.tipo_ferramenta is not null 
                                 and a.id_ticket = " . $id_ticket;

        $ls = connAccess::fetchData($oConn, $sql);


        if (count($ls) > 0) {

            $arr_novo = array();
            for ($i = 0; $i < count($ls); $i++) {
                $item = $ls[$i];

                $arr_novo[count($arr_novo)] = array("cod" => $item["tipo_ferramenta"],
                    "descr" => Util::getDescByCOD($tipos_ferramenta, "cod", "descr", $item["tipo_ferramenta"]));
            }

            return $arr_novo;
        }


        return $tipos_ferramenta;
    }

    static function listarFaseModulo() {

        $str = "Preparação, Pré Mediação, Agenda, Abertura, Investigação da Disputa, Comunicação de Compromissos, Alternativas, Negociação Final, Atendimento";

        $arr = explode(",", $str);
        $saida = array();
        for ($i = 0; $i < count($arr); $i++) {

            $id = $i + 1;
            $saida[count($saida)] = array("id" => $id, "cod" => "FASE_" . $id, "descr" => trim($arr[$i]));
        }
        return $saida;
    }

    static function findAllFerramenta($tipo_ferramenta = "") {

        global $oConn;


        $filtro = "";

        if ($tipo_ferramenta != "")
            $filtro .= " where tipo_ferramenta='" . $tipo_ferramenta . "' ";


        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 " . $filtro . " order by f.codigo";

        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    static function findFerramentaById($id) {

        global $oConn;
        
        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 where f.id =" . $id;
        
        $ferramenta = connAccess::fetchData($oConn, $sql);

        if ($ferramenta !== null && count($ferramenta) > 0) {
            return $ferramenta[0];
        }
    }

    static function findFerramentaByCodigo($codigo) {

        global $oConn;

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 where f.codigo = '" . $codigo . "'";

        $ferramenta = connAccess::fetchData($oConn, $sql);

        if ($ferramenta !== null && count($ferramenta) > 0) {
            return $ferramenta[0];
        }
    }

    static function buscaFerramentasDeModeracao() {
        global $oConn;

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
                    case "kappa_votacao":
                        return "kappa_votacao";
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