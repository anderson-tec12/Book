<?php

class acao_ticket {

    public static function getNomeAmigavelPorCampo($campo) {

        if ($campo == "publico_alvo")
            return "Público Alvo";

        if ($campo == "acoes")
            return "Ações para o cumprimento do objetivo";


        if ($campo == "condicoes")
            return "Condições a serem cumpridas";


        if ($campo == "intensidade")
            return "Grau ou intensidade a ser observado";

        return "";
    }

    public static function formataTitulo($titulo) {

        return strtoupper(substr(trim($titulo), 0, 1)) .
                substr(trim($titulo), 1, strlen(trim($titulo)) - 1);
    }

    public static function getNomeAmigavelPorLetra($campo) {

        if ($campo == "A")
            return "Público Alvo";

        if ($campo == "B")
           return "Ações para o cumprimento do objetivo";


        if ($campo == "C")
             return "Condições a serem cumpridas";


        if ($campo == "D")
            return "Grau ou intensidade a ser observado";

        return "";
    }

    /*
     * Função responsável por retornar acao ticket pelo id
     * Rodrigo Augusto - 06/11/2014
     */

    public static function getAcaoTicketById($id = "") {

        global $oConn;

        $sql = " select a.*,ac.nome as nome_acao, co.nome as nome_componente, us.nome_completo as nome_completo, us.email as email_usuario, us.nome as quem, us_cad.nome as nome_cad from acao_ticket a 
                left join componente co on co.id = a.id_componente
                left join acao ac on ac.id = a.id_acao
                left join usuario us on us.id = a.id_usuario
                left join ticket ti on ti.id = a.id_ticket
                left join usuario us_cad on us_cad.id = ti.id_usuario
                where 
                a.id = " . $id;

        $lista = connAccess::fetchData($oConn, $sql);

        if (count($lista) > 0) {
            return $lista[0];
        }

        return null;
    }
    
    public static function getSQLConsulta($alias = "a"){
        
        
            $sql = " select ".$alias.".*,ac.nome as nome_acao, co.nome as nome_componente, co.codigo as codigo_componente, us.nome as quem, us_cad.nome as nome_cad from acao_ticket ".$alias." 
                left join componente co on co.id = ".$alias.".id_componente
                left join acao ac on ac.id = ".$alias.".id_acao
                left join usuario us on us.id = ".$alias.".id_usuario
                left join ticket ti on ti.id = ".$alias.".id_ticket
                left join usuario us_cad on us_cad.id = ti.id_usuario ";
        
            return $sql;
    }

    public static function getListaTicket($id_usuario, $id_ticket = "", $acao = "", $quem = "", $onde = "", $data = "") {

        global $oConn;

        $sql = " select a.*,ac.nome as nome_acao, co.nome as nome_componente, us.nome as quem, us_cad.nome as nome_cad from acao_ticket a 
                left join componente co on co.id = a.id_componente
                left join acao ac on ac.id = a.id_acao
                left join usuario us on us.id = a.id_usuario
                left join ticket ti on ti.id = a.id_ticket
                left join usuario us_cad on us_cad.id = ti.id_usuario
                where 
                ti.id_usuario = " . $id_usuario;

        if ($acao != "")
            $sql .= " and upper(a.titulo) like  upper('%" . $acao . "%') ";

        if ($onde != "")
            $sql .= " and upper(co.nome) like  upper('%" . $onde . "%') ";


        if ($quem != "")
            $sql .= " and upper(us.nome) like  upper('%" . $quem . "%') ";

        if ($id_ticket != "")
            $sql .= " and a.id_ticket = " . $id_ticket;

        if ($data != "") {

            $sql .= " and a.data >= '" . Util::dataPg($data) . " 00:00:00' and  a.data <= '" . Util::dataPg($data) . " 23:59:59' ";
        }


        $sql .= " order by a.data desc";

        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

//Obtém um ID para a ação a partir do nome informado..
//caso a ação não exista no banco, ele irá criar uma.
    public static function getIDAcao($nome) {
        global $oConn;

        $id = connAccess::executeScalar($oConn, " select id from acao where upper(nome) = upper('" . $nome . "')  ");

        if ($id)
            return $id;


        $registro = $oConn->describleTable("acao"); //obtém um array  com as colunas do banco de dados.

        $registro["nome"] = $nome;
        connAccess::nullBlankColumns($registro);

        $registro["id"] = connAccess::Insert($oConn, $registro, "acao", "id", true);

        return $registro["id"];
    }

    public static function getIDComponente($nome, $codigo) {
        global $oConn;

        $id = connAccess::executeScalar($oConn, " select id from componente where (  upper(nome) = upper('" . $nome . "') or codigo = '" . $codigo . "' ) ");

        if ($id)
            return $id;


        $registro = $oConn->describleTable("componente"); //obtém um array  com as colunas do banco de dados.

        $registro["nome"] = $nome;
        $registro["codigo"] = $codigo;
        connAccess::nullBlankColumns($registro);

        $registro["id"] = connAccess::Insert($oConn, $registro, "componente", "id", true);

        return $registro["id"];
    }

    public static function gravaLog($titulo, $acao, $componente_nome, 
                                    $componente_codigo, $id_ticket, $id_usuario, 
                                    $id_registro = "", $tabela = "",
            $texto = "", $texto_selecionado = "", $status = "") {

        global $oConn;

        $ultimo_item = connAccess::fetchData($oConn, "select * from acao_ticket where  id_ticket = " . $id_ticket . " order by id desc limit 1 ");

        if (count($ultimo_item) > 0) {

            $ultimo_item = $ultimo_item[0];

            if ($ultimo_item["titulo"] == $titulo && $ultimo_item["id_usuario"] == $id_usuario &&
                    $ultimo_item["id_acao"] == acao_ticket::getIDAcao($acao)
                    &&  $ultimo_item["tabela"] == $tabela
                    &&  $ultimo_item["texto"] == $texto
                    )
                
                return $ultimo_item["id"]; // Não vamos salvar duplicidade aqui..
        }

//$id = connAccess::executeScalar($oConn," select id from acao where upper(nome) = upper('".$acao."')  ");

        $registro = $oConn->describleTable("acao_ticket"); //obtém um array  com as colunas do banco de dados.
//$registro["id"]  = Util::numeroBanco( Util::request($prefixo."id") ); 	
        $registro["data"] = Util::getCurrentBDDate(); // Pega a data atual, num formato pra ser salvo no banco de dados.


        $registro["titulo"] = $titulo;
        $registro["id_acao"] = acao_ticket::getIDAcao($acao);
        $registro["id_componente"] = acao_ticket::getIDComponente($componente_nome, $componente_codigo);

        $registro["id_registro"] = $id_registro;
        $registro["tabela"] = $tabela;
        $registro["texto"] = $texto;
        $registro["texto_selecionado"] = $texto_selecionado;

        $registro["id_usuario"] = $id_usuario;
        $registro["id_ticket"] = $id_ticket;
        $registro["status"] = $status;
        
        
        connAccess::nullBlankColumns($registro);

        // print_r( $registro ); die ( " --- ");
        $registro["id"] = connAccess::Insert($oConn, $registro, "acao_ticket", "id", true);

        return $registro["id"]; //Retorna o último registro de log salvo..
    }

    /*
     * Função responsável por retornar comentario pelo id
     * Rodrigo Augusto - 08/11/2014
     */

    public static function buscaComentarioById($idComentario) {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));
        $sql = "Select c.*, u.nome_completo from comentario c, usuario u where c.id = " . Util::NVL( $idComentario ,"0") . " and c.id_usuario = u.id";

        $lista = connAccess::fetchData($oConn, $sql);

        if (count($lista) > 0) {
            return $lista[0];
        }

        return NULL;
    }

    /*
     * Função responsável por retornar comentario pelo id do usuário e id do ticket
     * Rodrigo Augusto - 08/11/2014
     */
     public static function getContaByTicket( $id_ticket ){

            global $oConn;

            $qtde  = connAccess::executeScalar($oConn, " select count(*) from acao_ticket where id_ticket = ". $id_ticket);

            return $qtde;


    }
	 
	 
    public static function buscaComentarioByIdUserAndIdTicket($idUser, $idTicket) {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        $sql = "Select c.*, u.nome_completo from comentario c, usuario u where c.id_usuario = u.id ";

        if ($idUser != "")
            $sql .= " and c.id_usuario = " . $idUser;

        if ($idTicket != "")
            $sql .= " and c.id_ticket = " . $idTicket;

        $sql .= " order by c.data desc ";

        return $lista = connAccess::fetchData($oConn, $sql);
    }

}
