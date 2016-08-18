<?

class tipo_acordo {

    const n1_r1 = "Acordos com, validade legal";
    const n1_r2 = "Acordos informais, estudos ou simulações";
    const n2_r1 = "Negociações Autônomas";
    const n2_r2 = "Mediações e Conciliações (com atuação de \"terceira parte\")";
    const n3_r1 = "Não trabalhista";
    const n3_r2 = "Trabalhista";
    const n4_r1 = "Mediação ou Conciliação Extrajudicial";
    const n4_r2 = "Mediação ou Conciliação Judicial";
    const n5_r1 = "Trabalhista";
    const n5_r2 = "Não Trabalhista";
    const n6_r1 = "Câmaras de resolução de conflitos entre particulares criadas por órgãos e entidades da administração pública";
    const n6_r2 = "Conflitos envolvendo a Administração Pública Federal Direta, suas autarquias e Fundações";
    const n6_r3 = "Composição de conflitos em que for Parte Pessoa Jurídica de Direito Público";

    public static function salvar($registro) {

        global $oConn;

        connAccess::nullBlankColumns($registro);

        if (is_null($registro["id"])) {
            $registro["id"] = connAccess::Insert($oConn, $registro, "custom.tipo_acordo", "id", true);
        } else {
            connAccess::Update($oConn, $registro, "custom.tipo_acordo", "id");
        }

        return $registro["id"];
    }

    public static function buscaPorNivel($nivel) {

        global $oConn;

        if ($nivel !== null) {
            $sql = "select * from custom.tipo_acordo where nivel = " . $nivel . " order by descricao";

            return connAccess::fetchData($oConn, $sql);
        }
    }

    public static function buscaPorProximoNivel($proximoNivel) {

        global $oConn;

        if ($proximoNivel !== null) {
            $sql = "select * from custom.tipo_acordo where proximo_nivel = " . $proximoNivel . " order by descricao";

            return connAccess::fetchData($oConn, $sql);
        }
    }

    public static function buscaPorId($id) {

        global $oConn;

        if (!empty($id)) {
            return connAccess::fastOne($oConn, "custom.tipo_acordo", " id = " . $id);
        }
        return null;
    }

    public static function buscaPorCodigo($codigo) {

        global $oConn;

        if (!empty($codigo)) {
            return connAccess::fastOne($oConn, "custom.tipo_acordo", " codigo = '" . $codigo . "'");
        }
    }

    /*
     * Função responsável por retornar os itens selecionados na chave para chegar ao tipo selecionado
     */

    public static function getTiposRelacionadosAoTipoAcordoSelecionado($codigo) {
        if (!empty($codigo)) {
            switch ($codigo) {
                case "n3_r1":
                    $tipos = array("n1_r1", "n2_r1");
                    return $tipos;
                case "n3_r2" :
                    $tipos = array("n1_r1", "n2_r1");
                    return $tipos;
                case "n5_r1":
                    $tipos = array("n1_r1", "n2_r2", "n4_r1");
                    return $tipos;
                case "n5_r2" :
                    $tipos = array("n1_r1", "n2_r2", "n4_r1");
                    return $tipos;
                case "n6_r1":
                    $tipos = array("n1_r1", "n2_r2", "n4_r2");
                    return $tipos;
                case "n6_r2":
                    $tipos = array("n1_r1", "n2_r2", "n4_r2");
                    return $tipos;
                case "n6_r3" :
                    $tipos = array("n1_r1", "n2_r2", "n4_r2");
                    return $tipos;
                default :
                    return array();
            }
        }
    }

    public static function getNomePraViewPeloCodigo($codigo) {
        if (!empty($codigo)) {
            switch ($codigo) {
                case "n1_r1":
                    return self::n1_r1;
                case "n1_r2":
                    return self::n1_r2;
                case "n2_r1":
                    return self::n2_r1;
                case "n2_r2":
                    return self::n2_r2;
                case "n3_r1":
                    return self::n3_r1;
                case "n3_r2":
                    return self::n3_r2;
                case "n4_r1":
                    return self::n4_r1;
                case "n4_r2":
                    return self::n4_r2;
                case "n5_r1":
                    return self::n5_r1;
                case "n5_r2":
                    return self::n5_r2;
                case "n6_r1":
                    return self::n6_r1;
                case "n6_r2":
                    return self::n6_r2;
                case "n6_r3":
                    return self::n6_r3;
                default :
                    return "";
            }
        }
    }

}

?>