<?php

//implements IComponent
class KappaGrid {

    public $idKappa = "";
    public $titulo_ressalva = "Escreva suas Ressalvas abaixo";
    public $id_ticket = "";
    public $id_componente_template = "";
    public $id_registro = "";
    public $nome_tabela = "";
    public $href = "";
    public $classe_css = "";
    public $identificador_div_kappa = "";
    public $id_pai = "";
    public $classe_imagem = ""; //kappa_medio_k
    public $nome_formulario = "";
    public $id_ferramenta = "";
    public $modal_nao_sei = true;
    public $prefixo_principal = "kappa_principal";
    public $mostra_campo_url = true;

    public function __construct($idKappa, $nome_form = "") {
        $this->idKappa = $idKappa;
        $this->nome_formulario = $nome_form;
    }
    
    
    public static function tentaLocalizarUsuarioAvaliado($id_ticket , 
                  $nome_tabela, $id_registro ){
        global $oConn;
        
        
        if ( $id_ticket == "" ){
            echo("<br>Pulei porque não tinha ticket ==> ". $id_registro. " - ". $nome_tabela);
            return "";
            
        }
        $id_usuario_ticket = connAccess::executeScalar($oConn, " select id_usuario from ticket where id = ". $id_ticket);
        $id_usuario = "";
        
        if (strpos(" ". $nome_tabela, "ticket_evidencia")){
            
           // $id_usuario = connAccess::executeScalar($oConn," select id_usuario from ticket_evidencia where id = ". $id_registro );
        }
        
          
        if (strpos(" ". $nome_tabela, "conteudo_assinado")){
            
            $id_usuario = connAccess::executeScalar($oConn," select id_usuario from conteudo_assinado where id = ". $id_registro );
        }
        
        if (strpos(" ". $nome_tabela, "ticket_nao_entendi_duvida")
                || strpos(" ". $nome_tabela, "ticket_nao_entendi_pergunta") 
                ){
            
            $id_ticket_nao_entendi = connAccess::executeScalar($oConn, " select id_ticket_nao_entendi from " .$nome_tabela . " where id = ". $id_registro );
            
            if ( $id_ticket_nao_entendi != "" ){
                   $id_usuario = connAccess::executeScalar($oConn," select id_usuario from ticket_nao_entendi where id = ". $id_ticket_nao_entendi );
            }
        }
        //otimize_ritmo_ticket:kappa_pausa 
        if (strpos(" ". $nome_tabela, "otimize_ritmo_ticket")){
            
            $id_usuario = connAccess::executeScalar($oConn," select id_usuario from otimize_ritmo_ticket where id = ". $id_registro );
        }
        
         if (strpos(" ". $nome_tabela, "conteudo_assinado")){
            
            $id_usuario = connAccess::executeScalar($oConn," select id_usuario from conteudo_assinado where id = ". $id_registro );
        }
        
        
          if (strpos(" ". $nome_tabela, "survay.enquete_resposta")){
            
            $id_usuario = connAccess::executeScalar($oConn," select id_usuario_logado from ".$nome_tabela." where id = ". $id_registro );
            //die("ooi ". $id_usuario);
        }
        
        
        if ( $id_usuario != "" )
            return $id_usuario;
        
       return  $id_usuario_ticket;        
    }
    

    static function contaNivel($id) {
        global $oConn;
        $nivel = 0;

        $id_pai = connAccess::executeScalar($oConn, "select id_avaliacao_kappa_pai from avaliacao_kappa where id = " . $id);

        if ($id_pai != "") {
            $nivel++;
            $nivel += KappaGrid::contaNivel($id_pai);
        }

        return $nivel;
    }

    static function getIDPai($id) {
        global $oConn;
        $nivel = 0;

        $id_pai = connAccess::executeScalar($oConn, "select id_avaliacao_kappa_pai from avaliacao_kappa where id = " . $id);



        return $id_pai;
    }
    
    //Função para imprimir os divs que serão os modais para processamento..
    function printModais(){
        
        if ( @$GLOBALS["print_modals_kappa"] )
            return;  //Só imprimeros uma única vez por processamento de paginal
        
        ?>
               <link href="<?= K_RAIZ ?>library/kappa/css/kappa_grid.css?t=5" rel="stylesheet" type="text/css">
               <input type="hidden" name="<?= $this->idKappa ?>_id_ferramenta" id="<?= $this->idKappa  ?>_id_ferramenta" value="<?= $this->id_ferramenta ?>" >
               <div id="modal_fundo_kappa" onclick="hideModalKappa()"></div>
               <div id="menu_sub_kappa"></div>
               
             
               
        <?
            $GLOBALS["print_modals_kappa"] = 1;
                
    }

    function mostraResponderComentario($com_imagem_k = false, $array_kappa = array("ressalva" => "", "nota" => ""), $prefixo = "", $titulo = "Escreva suas Ressalvas abaixo", $complemento_tabela = "") {

        global $id_usuario_logado;
        global $oConn;

        $usuario = connAccess::fastOne($oConn, "usuario", " id = " . $id_usuario_logado);

        $img_usuario = Util::NVL(Usuario::mostraImagemUser($usuario["imagem"], $id_usuario_logado), "images/box_img_user.jpg");


        $classe_imagem_k = "";
        $class_imagem_nota = "";

        if ($this->classe_imagem != "") {


            $classe_imagem_k = " class='" . $this->classe_imagem . "_k' ";
            $class_imagem_nota = " class='" . $this->classe_imagem . "_nota' ";
        }
        ?>

        <a name="<?= $prefixo ?>acapa"></a>
        <div class="box_avaliar_responder_kappa" <?= $complemento_tabela ?> id='tabela_<?= $prefixo ?>'>

            <div class="em_resposta_avaliar_kappa">
                <?
                if ($this->id_pai != "") {

                    $sql = " select u.nome from avaliacao_kappa ak left join usuario u on u.id = ak.id_usuario where ak.id =  " .
                            $this->id_pai;

                    $nome_usuario = connAccess::executeScalar($oConn, $sql);

                    if ($nome_usuario != "") {
                        ?>
                        <div class="em_resposta_avaliar">Em resposta a <span><?= $nome_usuario ?></span></div>
                        <?
                    }
                }
                ?>
            </div>

            <div class="img_user_avaliar"><img src="<?= $img_usuario ?>"/></div>

            <textarea 
                name="<?= $prefixo ?>ressalva" id="<?= $prefixo ?>ressalva"
                class="textarea_avaliar" 
                placeholder="Digite aqui seu comentário, e clique ao lado para me dizer qual sua avaliação inicial."><?= @$array_kappa["ressalva"] ?></textarea>

            <input type="hidden" name="<?= $prefixo ?>comentario_nota" id="<?= $prefixo ?>comentario_nota" value="<?= @$array_kappa["nota"] ?>" >
            <input type="hidden" name="<?= $prefixo ?>parametro" id="<?= $prefixo ?>parametro" value="" >
            

            
            <div class="kappa_avaliar" >
                <table >                            
                    <tbody>
                        <tr>
                            <? if ($com_imagem_k) { ?>
                                <td ><img <?= $classe_imagem_k ?> src="../painel/images/botoes_kappa_k.png"/></td>
                            <? } ?>
                            <td  id="<?= $prefixo ?>td_nota1" class="td_bt_nota"><a onclick="setNotaKappa2('<?= $prefixo ?>', 1);"><img id="<?= $prefixo ?>imgKappa1" <?= $class_imagem_nota ?> src="../painel/images/botoes_kappa_1.png"/></a></td>
                            <td  id="<?= $prefixo ?>td_nota2" class="td_bt_nota"><a onclick="setNotaKappa2('<?= $prefixo ?>', 2);"><img id="<?= $prefixo ?>imgKappa2" <?= $class_imagem_nota ?> src="../painel/images/botoes_kappa_2.png"/></a></td>
                            <td  id="<?= $prefixo ?>td_nota3" class="td_bt_nota"><a onclick="setNotaKappa2('<?= $prefixo ?>', 3);"><img id="<?= $prefixo ?>imgKappa3" <?= $class_imagem_nota ?> src="../painel/images/botoes_kappa_3.png"/></a></td>
                            <td  id="<?= $prefixo ?>td_nota4" class="td_bt_nota"><a onclick="setNotaKappa2('<?= $prefixo ?>', 4);"><img id="<?= $prefixo ?>imgKappa4" <?= $class_imagem_nota ?> src="../painel/images/botoes_kappa_4.png"/></a></td>
                            <td  id="<?= $prefixo ?>td_nota5" class="td_bt_nota"><a onclick="setNotaKappa2('<?= $prefixo ?>', 5);"><img id="<?= $prefixo ?>imgKappa5" <?= $class_imagem_nota ?> src="../painel/images/botoes_kappa_5.png"/></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <input class="bt_salvar button" onclick="salvar_comentario('<?= $prefixo ?>', event )" name="<?= $prefixo ?>_btSalvar" id="<?= $prefixo ?>_btSalvar"  type="button"  value="Salvar"/>

        </div><!-- /Avaliar Kappa -->

        <?
    }

    function getContaComentario($oConn, $id_pai = "", $complemento_sql = "") {

        $lista = $this->getListaComentario($oConn, $id_pai, $complemento_sql);

        $str_ids = Util::NVL(Util::arrayToString($lista, "id"), " 0 ");

        $sql = " select count(*) from avaliacao_kappa where ( id in ( " .
                $str_ids . " ) or id_avaliacao_kappa_pai in (" . $str_ids . ") ) ";

        $qtde = connAccess::executeScalar($oConn, $sql);

        return Util::NVL($qtde, "0");
    }

    function getListaComentario($oConn, $id_pai = "", $complemento_sql = "") {



        if ($this->id_componente_template != "")
            $complemento_sql .= " and c.id_componente_template= " . $this->id_componente_template;


        if ($this->id_registro != "")
            $complemento_sql .= " and c.id_registro= " . $this->id_registro;


        if ($this->nome_tabela != "")
            $complemento_sql .= " and c.nome_tabela= '" . $this->nome_tabela . "' ";


        if ($id_pai != "")
            $complemento_sql .= " and c.id_avaliacao_kappa_pai = " . $id_pai;

        $sql = " select c.*, u.imagem as imagem_usuario, c.ressalva as comentario, u.nome_completo, u.nome as nome_usuario,   u.email, us_pai.nome_completo as nome_completo_pai from avaliacao_kappa c "
                . " left join usuario u on u.id = c.id_usuario "
                . " left join avaliacao_kappa pai on pai.id = c.id_avaliacao_kappa_pai "
                . " left join usuario us_pai on us_pai.id = pai.id_usuario "
                . "where c.id_ticket = " . $this->id_ticket .
                $complemento_sql . " order by c.data asc ";

        // echo($sql);
        $lista = connAccess::fetchData($oConn, $sql);

        return $lista;
    }

    function mostraBarraComentario($oConn, $path = "../painel/images/", $id_pai = "", $complemento_sql = "", $mostra_respostas = true, $mostra_container = true) {

        $this->printModais();
       
        $lista = $this->getListaComentario($oConn, $id_pai, $complemento_sql);

        $nome_div = "div_kappa_" . $this->id_registro;
        $classe = "";

        if ($id_pai != "") {
            // $nome_div .= "_".$id_pai;
            $classe = " grid_filho";
        } else {

            //$nome_div .= "_pai";
        }
        $nome_div = "grid" . $this->identificador_div_kappa;

        $id_pai_para_salvar = $id_pai;

        if ($id_pai != "") { //Garantindo que vai acabar em apenas um segundo nível..
            $id_pai_para_salvar = connAccess::executeScalar($oConn, "select id_avaliacao_kappa_pai from avaliacao_kappa where id = " . $id_pai);

            if ($id_pai_para_salvar == "")
                $id_pai_para_salvar = $id_pai;
        }

        $nivel = 0;

        if ($id_pai != "") {
            $nivel = KappaGrid::contaNivel($id_pai);
        }


        $str_localizador = "barra" . $nome_div . "," . $this->identificador_div_kappa . ",grid" . $nome_div . "," . $nivel . "," . $id_pai.",".
                $this->prefixo_principal;
        $str_localizador_load = $str_localizador;

        if ($nivel >= 1) {

            $id_super_pai = KappaGrid::getIDPai($id_pai);


            $str_localizador_load = "barragridkappa_resposta_comentario_" . $id_super_pai .
                    ",kappa_resposta_comentario_" . $id_super_pai .
                    ",gridgridkappa_resposta_comentario_" . $id_super_pai . "," . ($nivel - 1) . "," . $id_super_pai.",".
                     $this->prefixo_principal;
        }
        //

        $nivel_avaliar_responder = 0;

        if ($id_pai != "") {
            $nivel_avaliar_responder += ( $nivel + 1 );
        }
        
        $mostra_avaliar = true;
        
        if ( $id_pai != "" ){
            $comentario_nota = connAccess::executeScalar($oConn, "select nota from avaliacao_kappa where id = ". $id_pai);
            
            if ( $comentario_nota == 1 || $comentario_nota == 5 ){
                  $mostra_avaliar = false; $mostra_respostas = false;
            }
            
        }
        
        ?>
        <input type="hidden" id="localizador_<?= $this->idKappa ?>" name="localizador_<?= $this->idKappa ?>" value="<?= $str_localizador ?>">
        <input type="hidden" id="localizador_load_<?= $this->idKappa ?>" name="localizador_load_<?= $this->idKappa ?>" value="<?= $str_localizador_load ?>">
            <input type="hidden" name="<?=  $this->idKappa ?>modal_nao_sei" id="<?=  $this->idKappa ?>modal_nao_sei" 
                               value="<?= $this->modal_nao_sei == true ? "1":"0" ?>" >

              <? 
              
             // echo("passei aqui?". $this->mostra_campo_url);
              if (! @$GLOBALS["kappa_mostra_campo_url"] ) { //Imprima uma única vez na tela..
              
              if ( $this->mostra_campo_url ) { ?>
               
                    <?
                   $path = $_SERVER['SCRIPT_NAME'];
                   // find out the QueryString:
                   $queryString = $_SERVER['QUERY_STRING'];
                   $kappa_url_completa = $path;
                   
                   if ( $queryString != "")
                       $kappa_url_completa .= "?". $queryString;
        
                   
                  // echo("escrevi a url " . $kappa_url_completa);
              ?>
            
            
            <input type="hidden" id="kappa_url_completa" name="kappa_url_completa" value="<?=$kappa_url_completa?>" >
               
               <? 
               $GLOBALS["kappa_mostra_campo_url"] = 1;
               
               
              } ?>
        <? } ?>
            
            
       
        <? if ($mostra_container) { ?>  
            <div class="menu_avaliar_h3<?= $this->classe_css ?>" id="barra<?= $nome_div ?>">
            <? } ?>     
            <a name='list_<?= $nome_div ?>'></a>

            <?  if ( $mostra_avaliar ) { ?>
            <a class="bt_avaliar_responder bt_avaliar_responder_<?= $nivel_avaliar_responder ?>nivel" style="" onclick="respoder_kappa('<?= $this->id_registro ?>', '<?= $this->nome_tabela ?>', '<?= $this->id_componente_template ?>', '<?= $id_pai_para_salvar ?>', '<?= $nome_div ?>', '<?= K_RAIZ ?>', '<?= $this->idKappa ?>', '<?= $this->identificador_div_kappa ?>', '<?= $this->nome_formulario ?>');" >
                Avaliar e responder &#187;
            </a>
            <? } ?>

            <? if ($mostra_respostas) { ?>
                <a class="bt_respostas" style="" onclick="mostrar_respostas_kappa('<?= $this->id_registro ?>', '<?= $this->nome_tabela ?>', '<?= $this->id_componente_template ?>', '<?= $id_pai_para_salvar ?>', '<?= $nome_div ?>', '<?= K_RAIZ ?>', '<?= $this->idKappa ?>', '<?= $this->identificador_div_kappa ?>', '<?= $this->nome_formulario ?>');">
                    <?= Util::NVL($this->getContaComentario($oConn, $id_pai, $complemento_sql), "0") ?> Resposta(s) &#187;
                </a>
            <? } ?>

            <?
            $classe_comentario = "";

            if ($id_pai != "") {

                $nivel_classe_comentario = $nivel + 2;

                $classe_comentario = " class='kappa_avaliar_" . $nivel_classe_comentario . "nivel' ";
            }

            if ($mostra_container) {
                ?>  
            </div>

            <div id="<?= $this->identificador_div_kappa ?>" <?= $classe_comentario ?>>
                <!--A resposta será colocada aqui dentro -->

            </div>

            <div class="comentario_grid<?= $classe ?><?= $this->classe_css ?>" id="<?= $nome_div ?>">

            </div>
        <? } ?>

        <?
    }

    //MOstra Comentário do Ticket
    function mostraTabelaComentario($oConn, $path = "../painel/images/", $id_pai = "", $complemento_sql = "", $nome_formulario = ""
    ) {
        global $id;
        $lista = $this->getListaComentario($oConn, $id_pai, $complemento_sql);


        $botao_kappa = connAccess::executeScalar($oConn, "select botao_kappa from ticket where id = " . $id);
        ?>


        <?
        if (count($lista) <= 0) {

            echo("<div><i >Não há comentários cadastrados</i></div>");
        }
        ?>

        <?
        $classe = "avaliar_primeiro_nivel";
        $mostra_respostas = true;

        if ($id_pai != "") {
            $classe = "avaliar_segundo_nivel";
            $mostra_respostas = false;
        }
        for ($y = 0; $y < count($lista); $y++) {

            $item = $lista[$y];


            $img_usuario = Usuario::mostraImagemUser($item["imagem_usuario"], $item["id_usuario"]);
            ?>




            <div class="<?= $classe ?>">
                <div class="left">
                    <div class="img_user_avaliar"><img src="<?= $img_usuario ?>"/></div>
                </div>

                <div class="right">
                    <div class="nome_avaliar"><?= Util::acento_para_html(Util::devolve_acentos(Util::NVL($item["nome_completo"], $item["nome_usuario"]))) ?> </div>
                    <div class="nota_avaliar">
                        <? if ($botao_kappa && $item["nota"] != "") { ?>
                            <img class="pop_comentario_imagem" src="../painel/images/nota_kappa_<?= $item["nota"] ?>.png"/>
                        <? } ?></div>

                    <? if ($item["id_avaliacao_kappa_pai_usuario"] != "") { ?>
                        <div class="em_resposta_avaliar">Em resposta <span><?= $item["nome_completo_pai"] ?></span></div>
                    <? } ?>
                    <div class="data_avaliar"><?= Util::PgToOut($item["data"], true) ?><span style="margin-left: 10px;"><?= Util::HourToOut($item["data"]); ?></span></div>
                    <p><?= Util::acento_para_html(Util::devolve_acentos($item["comentario"])) ?></p>


                    <?
                    $id_pai = $item["id"];

                    $oSubKappa = new KappaGrid("kappa_comentario_" . $id_pai, $this->nome_formulario);

                    $oSubKappa->id_componente_template = $this->id_componente_template;
                    $oSubKappa->id_ticket = $this->id_ticket;
                    $oSubKappa->id_registro = $this->id_registro;
                    $oSubKappa->nome_tabela = $this->nome_tabela;
                    $oSubKappa->modal_nao_sei = $this->modal_nao_sei;
                    $oSubKappa->id_pai = $id_pai;
                    $oSubKappa->href = "a_comentario_kappa_" . $id_pai;
                    $oSubKappa->identificador_div_kappa = "kappa_resposta_comentario_" . $id_pai;
                    
                    $oSubKappa->classe_imagem = $this->classe_imagem;
                    $oSubKappa->mostra_campo_url = false;
                    
                    $oSubKappa->mostraBarraComentario($oConn, $path, "$id_pai", "", $mostra_respostas);
                    ?>


                </div>
            </div>



        <? }
        ?>


        <?
    }

}
