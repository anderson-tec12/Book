<?

class tipo_item_newsletter {

    public static function findAllTipoItem() {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = "Select * from custom.tipo_item_newsletter ";

        return connAccess::fetchData($oConn, $sql);
    }

}

?>