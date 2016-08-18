<?php

/**
 * Classe responsável por realizar upload de arquivos para o servidor
 *
 * @author Rodrigo Augusto Benedicto - 17/11/2014
 */
class inc_arquivo {

    static function adicionararquivo($registro) {
        global $oConn;

        connAccess::nullBlankColumns($registro);

        $registro["id"] = connAccess::Insert($oConn, $registro, "arquivo", "id", true);

        return $registro["id"];
    }

    static function findArquivos($idRegistro, $nomeTabela) {
        if (!empty($idRegistro) && !empty($nomeTabela)) {

            global $oConn;

            $sql = "Select p.* from arquivo p where p.id_registro = " . $idRegistro . " and id_tabela = '" . $nomeTabela . "'";

            $result = connAccess::fetchData($oConn, $sql);

            return $result;
        }
    }

    static function findArquivoById($id) {
        if (!empty($id)) {

            global $oConn;

            $sql = "Select * from arquivo where id = " . $id;

            $result = connAccess::fetchData($oConn, $sql);

            if (count($result) > 0) {
                return $result[0];
            }
        }
    }

    function excluirarquivo($arquivo) {

        global $oConn;

        $id_documento = @$_POST["id_documento"];

        if ($id_documento == "") {
            $id_documento = @$_GET["id_documento"];
        }

        global $tabela;

        connAccess::executeCommand($oConn, " delete from arquivo where id_registro = " .
                $id_documento . " and arquivo = '" . $arquivo . "' and id_tabela='" . $tabela . "' ");
    }

    static function getUrlArquivo($nomeArquivo, $idTicket) {
        return url_files . "/anexos/" . $idTicket . "/" . $nomeArquivo;
    }

    static function trataNome($nome) {

        $trata = str_replace("\\\\", "\\", $nome);
        $trata = str_replace("//", "/", $nome);

        //die ("--->" . PHP_OS );
        if (stristr(PHP_OS, 'WIN')) {
            
        } else {
            $trata = utf8_decode(str_replace("\\", "/", $trata));
            $trata = str_replace("//", "/", $trata);
        }

        return $trata;
    }

}

?>
