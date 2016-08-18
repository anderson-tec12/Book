<?

class inc_avaliacao_kappa {

    static function saveAvaliacaoKappa($registro) {

        global $oConn;

        if (!@$registro["id"]) {
            $registro["id"] = connAccess::Insert($oConn, $registro, "avaliacao_kappa", "id", true);
        } else {
            connAccess::Update($oConn, $registro, "avaliacao_kappa", "id");
        }

        return $registro;
    }

    static function findAvaliacaoKappaById($idAvaliacaoKappa) {

        global $oConn;

        $sql = "select * from avaliacao_kappa where id = " . $idAvaliacaoKappa;

        $result = connAccess::fetchData($oConn, $sql);

        if ($result != null && $result[0] != null) {
            return $result[0];
        }

        return "";
    }

    static function findAvaliacaoKappa($id_registro, $nome_tabela, $id_usuario = null, $id_componente_template = null) {

        if (!empty($id_registro) && !empty($nome_tabela)) {

            global $oConn;

            $sql = "select * from avaliacao_kappa where id_registro = " . $id_registro . " and nome_tabela = '" . $nome_tabela . "'";

            if (!empty($id_usuario)) {
                $sql = $sql . " and id_usuario = " . $id_usuario;
                //echo $sql."<br/>";
            }

            if ($id_componente_template == "null") {
                $sql = $sql . " and id_componente_template IS NULL";
                //echo $sql . "<br/>";
            } else if (!empty($id_componente_template)) {
                $sql = $sql . " and id_componente_template = " . $id_componente_template;
                //echo $sql."<br/>";
            }

            $result = connAccess::fetchData($oConn, $sql);

            if ($result != null && $result[0] != null) {
                return $result[0];
            }
        }

        return "";
    }

    static function findAvaliacaoKappaByIdAnalise($idAnalise, $idUsuario = null) {

        if ($idAnalise != null) {

            global $oConn;

            $sql = "select * from avaliacao_kappa where id_registro = " . $idAnalise . " and nome_tabela = 'analise' and id_avaliacao_kappa_pai IS NULL ";

            if ($idUsuario != null) {
                $sql = $sql . " and id_usuario = " . $idUsuario;
            }

            //echo $sql;

            return connAccess::fetchData($oConn, $sql);
        }

        return "";
    }

    static function getNumeroDeKappaPorRegistro($nomeTabela, $idRegistro, $nota = "", $idUsuario = "") {

        if ($nomeTabela != null && $idRegistro != null) {
            global $oConn;

            $sql = "select * from avaliacao_kappa where id_registro = " . $idRegistro . " and nome_tabela = '" . $nomeTabela . "' and id_avaliacao_kappa_pai IS NULL ";

            if (!empty($nota)) {
                $sql .= "and nota = " . $nota;
            }

            if (!empty($idUsuario)) {
                $sql .= " and id_usuario = " . $idUsuario;
            }

            //echo $sql;

            return count(connAccess::fetchData($oConn, $sql));
        }
    }

    static function getPessoasAvaliaramRegistro($id_registro, $nome_tabela) {
        if (!empty($id_registro) && !empty($nome_tabela)) {
            global $oConn;

            $sql = "select distinct u.* from avaliacao_kappa a left join usuario u on a.id_usuario = u.id where id_registro = " . $id_registro . " and nome_tabela = '" . $nome_tabela . "' and id_avaliacao_kappa_pai IS NULL ";

            return connAccess::fetchData($oConn, $sql);
        }

        return "";
    }

}

?>