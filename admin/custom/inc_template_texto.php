<?

class template_texto {

    public static function buscaTemplateTextoPorIdComponente($idComponente, $orderByType = "DESC") {

        global $oConn;

        $sql = " select c.nome as nome_componente, t.* from custom.template_texto t inner join custom.componente_template c on t.id_componente_template=c.id where t.id_componente_template = " . $idComponente . "order by t.texto " . $orderByType;

        return connAccess::fetchData($oConn, $sql);
    }

}

?>