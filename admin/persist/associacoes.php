<?

class associacoes
{



  public static function getIDAssociacoesPai($oConn, $classificacao, $id_filho, $tabela_pai, $tabela_filho)
  {
		$sql = "select id_pai from associacao_cadastros where tabela_pai='" . $tabela_pai . "' and tabela_filho ='" . $tabela_filho.
                "' and id_filho in ( " . $id_filho . " ) and classificacao='" . $classificacao . "' ";


            $dt_saida = connAccess::fetchData($oConn, $sql);

            $saida = "";
            for ( $i = 0; $i < count( $dt_saida ) ; $i++)
            {
                if ($saida != "")
                    $saida .= ",";


                $saida .= $dt_saida[$i]["id_pai"];
            }

            return $saida;

        }


public static function getIDAssociacoesFilho($oConn, $classificacao, $id_pai, $tabela_pai, $tabela_filho)
        {
                 
		$sql = "select id_filho from associacao_cadastros where tabela_pai='" . $tabela_pai .
		 "' and tabela_filho ='" . $tabela_filho.
                "' and id_pai in ( " . $id_pai . " )  and classificacao='" . $classificacao . "' ";

            $dt_saida = connAccess::fetchData($oConn, $sql);

            $saida = "";
            for ( $i = 0; $i < count( $dt_saida ) ; $i++)
            {
                if ($saida != "")
                    $saida .= ",";


                $saida .= $dt_saida[$i]["id_filho"];
            }
		
		return $saida;

        }



  public static function salvar($oConn, $classificacao, $id_pai, $ids_filho,  $tabela_pai, $tabela_filho)
        {
            $arps = explode(",", $ids_filho); // ids_filho.ToString().Split(',');

		$oConn->garanteSchema();


            $lista_ids = "0";

            for ($i = 0; $i < count($arps); $i++)
            {
			     if ($arps[$i] == "")
                    continue;

                $id_filho = $arps[$i];




			$dr =  connAccess::fastOne($oConn,"associacao_cadastros", "tabela_pai='"  .$tabela_pai . "' and tabela_filho ='" .$tabela_filho .
                    "' and id_pai = " . $id_pai . " and classificacao='" . $classificacao . "' and id_filho= ". $id_filho);

                if (! is_null( $dr ) )
                {
                    $lista_ids .= "," . $dr["id"];
                    continue;
                }

                $dr = $oConn->describleTable("associacao_cadastros");

                $dr["tabela_pai"] = $tabela_pai;
                $dr["tabela_filho"] = $tabela_filho;
                $dr["classificacao"] = $classificacao;
                $dr["id_pai"] = $id_pai;
                $dr["id_filho"] = $id_filho;


                connAccess::nullBlankColumns($dr);
				
			    //print_r( $dr );die("<<");
			    $idt = connAccess::Insert($oConn, $dr,"associacao_cadastros","id",true);
			
                $lista_ids .= "," . $idt;


            }
			
			
		connAccess::executeCommand($oConn, " delete from associacao_cadastros where id_pai = " .$id_pai. " and tabela_pai='" .$tabela_pai. "' and tabela_filho ='" .$tabela_filho.
                    "' and id_pai = " .$id_pai." and classificacao='" .$classificacao. "' and id not in ( " .$lista_ids. ")  ");

        }

       public static function excluir($oConn, $classificacao, $tabela_pai, $id_pai){
				
		connAccess::executeCommand($oConn, " delete from associacao_cadastros where id_pai = " .$id_pai. " and tabela_pai='" .$tabela_pai.
		           "' and classificacao='" .$classificacao. "' ");
		
		}




}
?>