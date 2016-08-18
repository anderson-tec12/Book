<?

class inc_regra_punicao_recompensa {

    static function buscaTodos() {

        global $oConn;

        $sql = "Select * from regra_punicao_recompensa";

        return connAccess::fetchData($oConn, $sql);
    }

    static function buscaPorId($id) {

        global $oConn;

        $sql = "Select f.*, i.imagem from ferramenta f left join icone i on i.id = f.id_icone1 where f.id =" . $id;

        $sql = "Select * from regra_punicao_recompensa t where t.id = " . $id;

        $ferramenta = connAccess::fetchData($oConn, $sql);

        if ($ferramenta !== null && count($ferramenta) > 0) {
            return $ferramenta[0];
        }
    }

    static function buscaPorTitulo($titulo) {

        global $oConn;

        $sql = "Select * from regra_punicao_recompensa t where t.titulo like % " . $titulo . "%";

        return connAccess::fetchData($oConn, $sql);
    }

    static function salvar($registro) {

        global $oConn;

        connAccess::nullBlankColumns($registro);

        if (!@$registro["id"]) {
            $registro["id"] = connAccess::Insert($oConn, $registro, "regra_punicao_recompensa", "id", true);
        } else {
            connAccess::Update($oConn, $registro, "regra_punicao_recompensa", "id");
        }

        return $registro["id"];
    }

}

?>