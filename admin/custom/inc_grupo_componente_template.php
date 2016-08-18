<?

class inc_grupo_componente_template {

    static function buscaGruposPorModulo($idModulo) {

        global $oConn;

        if (!empty($idModulo)) {
            $sql = "Select * from custom.grupo_componente_template where id_modulo = " . $idModulo . " order by nome";

            return connAccess::fetchData($oConn, $sql);
        }

        return "";
    }
    
    static function buscaGruposPorFerramenta($idFerramenta) {

        global $oConn;

        if (!empty($idFerramenta)) {
            $sql = "Select * from custom.grupo_componente_template where id_ferramenta = " . $idFerramenta . " order by nome";

            return connAccess::fetchData($oConn, $sql);
        }

        return "";
    }

}

?>