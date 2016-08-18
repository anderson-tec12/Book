<?

class inc_ferramenta {

    static function findAllFerramenta() {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        //$sql = "SELECT * FROM ferramenta";

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 order by f.codigo";


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

    static function getNomeTabelaDebateByFerramenta($idFerramenta = "") {

        $ferramenta = null;

        if (!empty($idFerramenta)) {
            $ferramenta = inc_ferramenta::findFerramentaById($idFerramenta);

            if (!empty($ferramenta)) {
                switch ($ferramenta['codigo']) {
                    case "penalidade":
                        return "penalidade";
                    default :
                        return "";
                }
            }
        }
        
        return "";
    }

}

?>