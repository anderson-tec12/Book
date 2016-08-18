<?

class inc_ferramenta {

    static function findAllFerramenta() {

        global $oConn;

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 order by f.codigo";

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

    /*
     * Função responsavel por retornar as ferramentas carregadas através de um array de ids
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

}

?>