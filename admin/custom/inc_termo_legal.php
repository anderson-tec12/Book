<?

class termo_legal {

    public static function salvar($registro) {

        global $oConn;

        connAccess::nullBlankColumns($registro);

        if (is_null($registro["id"])) {
            $registro["id"] = connAccess::Insert($oConn, $registro, "custom.termo_legal", "id", true);
        } else {
            connAccess::Update($oConn, $registro, "custom.termo_legal", "id");
        }

        return $registro["id"];
    }

    public static function buscaTodos() {

        global $oConn;

        $sql = "select * from custom.termo_legal order by ordem";
        return connAccess::fetchData($oConn, $sql);
    }

    public static function buscaPorId($id) {

        global $oConn;

        if (!empty($id)) {
            return connAccess::fastOne($oConn, "custom.termo_legal", " id = " . $id);
        }
        return null;
    }

}

?>