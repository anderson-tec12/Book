<?

//require_once K_DIR . "painel/newsletter/enviador_newsletter.php";
//require_once K_DIR . "painel/newsletter/mensagem_sistema/ms_mensagem_sistema.php";
//require_once K_DIR . "painel/newsletter/mensagem_sistema/cadastro/ms_confirmacao_cadastro.php";

class Usuario {

       static function getMensagemPadrao($codigo, $msg_pers_temp = ""){
        global $oConn;
        
          
            $msg_pers_temp = "Seu cadastro foi recebido com sucesso. Por favor aguarde até a sua aprovação, você será avisado por e-mail.";
            if ( trim(Parameters::getValue($codigo, $oConn)) == "" ){
                Parameters::setValue($codigo,$msg_pers_temp, $oConn);
            }
            
            $msg_personalizada = Util::acento_para_html(Parameters::getValue($codigo, $oConn));

            return Util::acento_para_html(  str_replace("\n", "<br>",  $msg_personalizada));
        
        
    }
    
    static function mostraGridImagens($id_usuario_logado, $lista_imagens){
        
       $conta = 0;
       for ( $y = 0; $y < count($lista_imagens); $y++ ){ 
                $item = $lista_imagens[$y];

                $conta++;

                ?>

                   <a href="#" onclick="fn_changephoto('<?=$item["imagem"]?>','<?=$item["tipo"]?>','<?= Usuario::mostraImagemUser($item["tipo"].":".$item["imagem"], $id_usuario_logado); ?>')"><img 
                           src="<?= Usuario::mostraImagemUser($item["tipo"].":".$item["imagem"], $id_usuario_logado, false); ?>" ></a>

        <? } 
        
    }
      static function mostraImagemPerfil($user,  $lista_imagens){
          global $oConn;
          
          if ( $user["imagem"] != ""  ){

                                    $ar_img = explode("arquivo:", $user["imagem"]);
                                    $tipo_img = "arquivo";

                                    if ( count($ar_img) < 2 ){
                                        $ar_img = explode("url:", $user["imagem"]);

                                        $tipo_img = "url";
                                    }

                                    if ( Usuario::adicionarListaImagem($user["id"],$ar_img[1],$tipo_img,1 ) ){
                                                //Imagem recente, precisa ser adicionada ao perfil..
                                       $lista_imagens = Usuario::getImagesUser( $id_usuario_logado );
                                   }

            }
            
            
             $imagem_inicial = $user["imagem"] ;

             if ( $imagem_inicial == "" ){
                    if (count($lista_imagens) > 0 ){
                        $imagem_inicial = $lista_imagens[0]["tipo"].":".$lista_imagens[0]["imagem"];
                        
                        if (  $user["imagem"] == "" ){
                            
                          $user["imagem"] = $imagem_inicial;
                          connAccess::nullBlankColumns( $user );
                          connAccess::Update($oConn, $user, "usuario","id");
                        }
                    }
             }
            
             ?>

            
					<img id="img_current" class="avatar-big" src="<?= Usuario::mostraImagemUser($imagem_inicial, $user["id"], true); ?>">
                                            <div id="div_excluir_img"
                                                 <? if ( count($lista_imagens) <= 0  ){ echo " style='display:none' "; } ?> >
					          <a class="hint--bottom icon-delete" data-hint="Excluir" href="#" onclick="fn_excluir_current()"></a>
                                                  </div>
                                        
             <?
          
   }
    
   static function getToken($id){
       
       return md5("itapo.tY.". $id);
   }
   
    static function salvar($registro) {

        global $oConn;

        connAccess::nullBlankColumns($registro);

        if (is_null($registro["id"])) {
            $registro["id"] = connAccess::Insert($oConn, $registro, "usuario", "id", true);
        } else {
            connAccess::Update($oConn, $registro, "usuario", "id");
        }

        return $registro["id"];
    }
    
    //Tenta obter o ID do ticket, usando o perfil de convidado.. aproveita e já checa se o usuário pode obter essa id ou não.
    static function getIDTicketPerfilConvidado($id_usuario) {

        $convite_id = Util::request("ticket_id");

        if ($convite_id == "") {
            $convite_id = Util::request("id_ticket");
        }


        if (Util::request("ticket_id") != "" || Util::request("id_ticket") != "") { //Trata de checar se a queryString pode ser acessada realmente por eesse cara.
            if (class_exists("ticket")) {

                $relacao = ticket::getRelacaoUsuarioTicket($convite_id, $id_usuario);

                if ($relacao == "") { //Ele não tem nada a ver com o ticket, tentou dar uma de esperto acessando com a id diretamente.
                    return -1; //não podemos deixar ele usar essa url.
                }
            }
        }
        if ($convite_id == "") {
            $convite_id = SessionCliente::getValorSessao("convite_id");
        }

        if ($convite_id == "") {
            $convite_id = SessionCliente::getValorSessao("ticket_id");
        }
        //$convite_id = SessionCliente::getValorSessao("convite_id");


        if ($convite_id == "") { //NÃ¢o tem, vamos arranjar um pra ele.
            $convite_id = connAccess::executeScalar($oConn, " select id_ticket from ticket_participante where id_usuario = " .
                            $id_usuario_logado . " and tipo='convidado' order by id desc ");
        }
        if ($convite_id == "") { //NÃo tem convite algum para ele.., vamos arranjar um pra ele.
            $convite_id = connAccess::executeScalar($oConn, " select id from ticket where id_usuario = " .
                            $id_usuario_logado . " order by id desc ");
        }

        return $convite_id;
    }

    //Verifica se o usuário é titular de algum ticket
    static function ehTitularTicket($id_usuario, $id_ticket = "") {
        global $oConn;

        $sql = " select count(*) from ticket where id_usuario = " . $id_usuario;

        if ($id_ticket != "") {
            $sql .= " and id = " . $id_ticket;
        }

        $qtde = connAccess::executeScalar($oConn, $sql);

        if ($qtde > 0)
            return true;

        return false;
    }

    //Verifica se o usuário é convidado de algum ticket
    static function ehConvidadoTicket($id_usuario, $id_ticket = "") {

        global $oConn;

        $sql = " select count(*) from ticket_participante where id_usuario = " . $id_usuario . " and tipo='convidado'";

        if ($id_ticket != "") {
            $sql .= " and id_ticket = " . $id_ticket;
        }


        $qtde = connAccess::executeScalar($oConn, $sql);

        if ($qtde > 0)
            return true;

        return false;
    }

    static function getCodigoVerificacaoUser($usuario) {

        $primeira_letra_email = Util::left(trim($usuario["email"]), 1);
        $cod = Util::left(md5($usuario["id"] . $primeira_letra_email . "ita.poty"), "30");

        return $cod;
    }

    static function loadById(IDbPersist $oConn, $id) {

        $usuario = connAccess::fastOne($oConn, "usuario", " id = " . Util::NVL($id, " 0 "));

        return $usuario;
    }

    static function enviaEmailVerificacao(IDbPersist $oConn, $id, 
            $path_to_email = "",
            $msg_personalizada = "") {

         $sep = DIRECTORY_SEPARATOR;
         
          
          if ( @$path_to_email == "" && @$GLOBALS["caminho_path_html"] != "")
              $path_to_email = $GLOBALS["caminho_path_html"] ;
          
          if ($path_to_email == "")
                 $path_to_email = realpath(".") . DIRECTORY_SEPARATOR . "admin". DIRECTORY_SEPARATOR. "login";
          
          
        //  die(" --- ". $path_to_email );
          
          $texto = Util::lerArquivo($path_to_email . DIRECTORY_SEPARATOR . "html_email.htm");
          

          $usuario = connAccess::fastOne($oConn, "usuario", " id = " . $id);


        $texto = str_replace("{nome}", Util::acento_para_html($usuario["nome_completo"]), $texto);
        // $texto = str_replace("{sobrenome}", Util::acento_para_html($usuario["sobrenome"]), $texto);
        $texto = str_replace("{email}", $usuario["email"], $texto);
        $texto = str_replace("{codigo_verificacao}", $usuario["codigo_verificacao"], $texto);
        $texto = str_replace("{url_base}", constant("url_base") . "", $texto);
        $texto = str_replace("{nome_sistema}", "Protetores da Cuesta", $texto);
        $texto = str_replace("{id}", $usuario["id"], $texto);
        $texto = str_replace("//", "/", $texto);

        if ($msg_personalizada == "")
          $msg_personalizada = Util::acento_para_html("Para começar a usar o protetores da cuesta você precisa confirmar seu endereço de e-mail.");
         
       $texto = str_replace("{mensagem}", $msg_personalizada, $texto); 
          
        // echo ( $texto );
        
        Util::enviarEmail($usuario["email"], utf8_decode("Confirmação de e-mail"), $texto);
        
        return $usuario["email"];
    }

    //include functions to usuario
    static function getUserByEmail(IDbPersist $oConn, $email) {

        if ($email == "")
            return array();

        $registro = connAccess::fastOne($oConn, "usuario", " ( trim(email)='" . trim($email) . "' or trim(coalesce(email2,' ')) ='" . trim($email) . "')  ");
        //echo("<br>VVVAI<br><br>");
        //print_r($registro); die("pare");
        if (!is_array($registro) || count($registro) <= 0)
            $registro = $oConn->describleTable("usuario");

        return $registro;
    }

    static function getEmailFromObj($obj_userSession, $tipo) {


        $user = Usuario::toArray($obj_userSession);

        if ($tipo == "facebook") {
            return $user["email"];
        }

        if ($tipo == "google") {
            return $user["email"];
        }


        if ($tipo == "microsoft") {

            $emails = Usuario::toArray($user["emails"]);

            return $emails["preferred"];
        }
    }

    static function setDataFromOAuth(&$registro, $obj_userSession, $tipo, $field_email = "email") {

        $user = Usuario::toArray($obj_userSession);

        if ($registro["data_cadastro"] == "")
            $registro["data_cadastro"] = date("Y-m-d");

        if ($tipo == "facebook") {
            // [id] => 556638027774725 [email] => rafaelrend@gmail.com [first_name] => Rafael [gender] => male [last_name] => Rend 
            // [link] => https://www.facebook.com/app_scoped_user_id/556638027774725/ [locale] => pt_BR 
            // [middle_name] => Ãlvares [name] => Rafael Ãlvares Rend [timezone] => -3 [updated_time] => 2014-08-05T14:44:52+0000 


            $registro[$field_email] = $user["email"];
            $registro["nome"] = Util::removeAcentos($user["first_name"]);
            $registro["sobrenome"] = Util::removeAcentos($user["last_name"]);
            $registro["nome_completo"] = Util::removeAcentos($user["name"]);
            $registro["identificacao_facebook"] = $user["id"];

            $atual = 0;

            if ($registro["imagem"] == "") {
                $registro["imagem"] = "url:https://graph.facebook.com/" . $user["id"] . "/picture";
                //http://graph.facebook.com/".$user["id"]."/picture?type=large
                $atual = 1;
            }
            if ($registro["id"] != "") {

                Usuario::adicionarListaImagem($registro["id"], "https://graph.facebook.com/" . $user["id"] . "/picture", "url", $atual, "");
            }
            //die ( $registro["nome_completo"] );
        }

        if ($tipo == "google") {
            /* stdClass Object ( [id] => 109386967385706401226 [email] => rafaelrend@gmail.com 
             *  [verified_email] => 1 [name] => Rafael Rend [given_name] => Rafael [family_name] => Rend
             *  [link] => https://plus.google.com/109386967385706401226 
             * [picture] => https://lh5.googleusercontent.com/-HDqtHyvh-eM/AAAAAAAAAAI/AAAAAAAAADk/psaEhz3VKAk/photo.jpg 
             * [gender] => male [locale] => pt-BR )
             */

            $registro[$field_email] = $user["email"];
            $registro["nome"] = Util::removeAcentos($user["given_name"]);
            $registro["sobrenome"] = Util::removeAcentos($user["family_name"]);
            $registro["nome_completo"] = Util::removeAcentos($user["name"]);
            $registro["identificacao_google"] = $user["link"];

            $atual = 0;

            if ($registro["imagem"] == "") {
                $registro["imagem"] = "url:" . $user["picture"];
                $atual = 1;
            }
            if ($registro["id"] != "") {

                Usuario::adicionarListaImagem($registro["id"], $user["picture"], "url", $atual, "");
            }
        }

        if ($tipo == "microsoft") {

            //stdClass Object ( [id] => b4221f85db285026 [name] => Rafael Ãlvares Rend [first_name] => Rafael 
            //[last_name] => Ãlvares Rend [link] => https://profile.live.com/ [gender] => [emails] => stdClass Object ( [preferred] => rafaelrend@hotmail.com 
            //[account] => rafaelrend@hotmail.com [personal] => [business] => ) [locale] => pt_BR [updated_time] => 2014-08-13T19:13:38+0000 )
            //$registro[$field_email] = $user["email"];
            $registro["nome"] = Util::removeAcentos($user["first_name"]);
            $registro["sobrenome"] = Util::removeAcentos($user["last_name"]);
            $registro["nome_completo"] = Util::removeAcentos($user["name"]);
            $registro["identificacao_microsoft"] = $user["id"];

            $emails = Usuario::toArray($user["emails"]);

            $registro[$field_email] = $emails["account"];

            if ($emails["preferred"] != $emails["account"]) {

                $registro["email2"] = $emails["preferred"];
            }
        }

        if ($tipo == "twitter") {
            /* stdClass Object ( [id] => 713413616 [id_str] => 713413616 [name] => R Rend 
             * [screen_name] => RafaelRend [location] =>
             *  [description] => [url] => [entities] => stdClass 
             * Object ( [description] => stdClass Object ( [urls] => Array ( ) ) ) [protected] => [followers_count] => 8 
             * [friends_count] => 14 [listed_count] => 0 [created_at] => Tue Jul 24 00:53:32 +0000 2012 
             * [favourites_count] => 7 [utc_offset] => [time_zone] => [geo_enabled] =>
             *  [verified] => [statuses_count] => 11 [lang] => pt [status] => 
             * stdClass Object ( [created_at] => Tue Aug 05 12:02:40 +0000 2014 [id] => 
             * 4.9662734390214E+17 [id_str] => 496627343902142464 
             * [text] => @gvt_suporte OlÃ¡, passei meus dados via DM, obrigado. 
             * [source] => Twitter Web Client [truncated] =>
             *  [in_reply_to_status_id] => [in_reply_to_status_id_str] => [in_reply_to_user_id] => 34593371
             *  [in_reply_to_user_id_str] => 34593371 [in_reply_to_screen_name] => gvt_suporte [geo] => 
             * [coordinates] => [place] => [contributors] => [retweet_count] => 0 [favorite_count] => 0 [entities] => 
             * stdClass Object ( [hashtags] => Array ( ) [symbols] => Array ( ) [urls] => Array ( ) 
             * [user_mentions] => Array ( [0] => stdClass Object ( [screen_name] => gvt_suporte [name] => GVT Suporte
             *  [id] => 34593371 [id_str] => 34593371 [indices] => Array ( [0] => 0 [1] => 12 ) ) ) ) [favorited] => [retweeted] => [lang] => pt ) 
             * [contributors_enabled] => [is_translator] => [is_translation_enabled] => [profile_background_color] => C0DEED
             *  [profile_background_image_url] => http://abs.twimg.com/images/themes/theme1/bg.png
             *  [profile_background_image_url_https] => https://abs.twimg.com/images/themes/theme1/bg.png [profile_background_tile] =>
             *  [profile_image_url] => http://pbs.twimg.com/profile_images/483062644849377280/TK_rKSpp_normal.jpeg 
             * [profile_image_url_https] => https://pbs.twimg.com/profile_images/483062644849377280/TK_rKSpp_normal.jpeg
             *  [profile_link_color] => 0084B4 [profile_sidebar_border_color] => C0DEED [profile_sidebar_fill_color] => DDEEF6 [profile_text_color] => 333333
             *  [profile_use_background_image] => 1 [default_profile] => 1 [default_profile_image] => [following] => [follow_request_sent] => [notifications] => )
             */

            $registro[$field_email] = $user["email"];
            $registro["nome"] = $user["given_name"];
            $registro["sobrenome"] = $user["family_name"];
            $registro["nome_completo"] = Util::removeAcentos($user["name"]);
            $registro["identificacao_google"] = $user["link"];

            if ($registro["imagem"] == "")
                $registro["imagem"] = "url:" . $user["picture"];
        }

        /*
          nome character varying(300), -- Nome
          sobrenome character varying(300), -- Sobrenome
          nome_completo character varying(300), -- Nome Completo
          data_cadastro timestamp without time zone, -- Data de Cadastro
          email character varying(300), -- Email
          email2 character varying(300), -- Email alternativo
          imagem character varying(300), -- Arquivo de imagem (ou gravatar)
          identificacao_facebook character varying(350), -- Identificação - Perfil Facebook
          identificacao_twitter character varying(350), -- Identificação - Perfil Twitter
          identificacao_microsoft character varying(350), -- Identificação - Perfil Microsoft
          identificacao_google character varying(350), -- Identificação - Perfil Google
          cpf character varying(30), -- CPF
          rg character varying(30), -- RG
          telefone character varying(30), -- Telefone
          telefone2 character varying(30), -- Telefone 2
          verificado_email smallint, -- Verificado Email
          verificado_s
         * */
    }

    static function toArray($obj) {
        if (is_object($obj))
            $obj = (array) $obj;
        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = Usuario::toArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }

    //Adiciona uma imagem a lista de imagens do usuário..
    static function adicionarListaImagem($id_usuario, $imagem, $tipo, $status, $schema = "") {

        global $oConn;

        $lista = connAccess::fastQuerie($oConn, $schema . "usuario_imagem", " id_usuario = " . $id_usuario . " and tipo='" . $tipo . "' and imagem like '%" . $imagem . "%'");

        if (count($lista) <= 0) {

            $registro = $oConn->describleTable($schema . "usuario_imagem");

            $registro["id_usuario"] = $id_usuario;
            $registro["imagem"] = $imagem;
            $registro["tipo"] = $tipo;
            $registro["status"] = $status;

            connAccess::nullBlankColumns($registro);
            connAccess::Insert($oConn, $registro, "usuario_imagem", "id");

            return true;
        }

        return false;
    }

    static function getUser($id, $schema = "") {
        global $oConn;

        if ($id == "") {

            $registro = $oConn->describleTable("usuario");

            return $registro;
        }

        $registro = connAccess::fastOne($oConn, $schema . "usuario", " id = " . $id);

        return $registro;
    }

    static function deleteCurrentPhoto(&$user, $current_image, $current_image_tipo, $tipo = "arquivo") {
        global $oConn;

        if (strpos(" " . $current_image, $tipo . ":")) {
            $ar = explode($tipo . ":", $current_image);

            $current_image = $ar[count($ar) - 1];
        }

        $tmp_sql = " id_usuario = " . $user["id"] . " and imagem like '%" . $current_image . "%' and tipo='" . $tipo . "' ";

        // print_r( $_POST );
        // die(" aaa ". $tmp_sql . " / ". $current_image );
        $reg = connAccess::fastOne($oConn, "usuario_imagem", $tmp_sql);

        if (is_array($reg)) {


            connAccess::executeCommand($oConn, " delete from usuario_imagem where id_usuario = " . $user["id"] . " and id = " . $reg["id"]);
        }
        if ($tipo == "arquivo" && strpos(" " . $user["imagem"], $current_image) > 0) { //A imagem selecionada é a que o cara quer deletar.. vamos pedir outra pra ficar na frente.
            $reg = connAccess::fastOne($oConn, "usuario_imagem", " id_usuario = " . $user["id"] . " and tipo not in ('galeria')  ");
            if (is_array($reg)) {
                Usuario::changeCurrentPhoto($user, $reg["tipo"] . ":" . $reg["imagem"], $reg["imagem"], $reg["tipo"]);
            }
        }
    }

    static function changeCurrentPhoto(&$user, $new_img, $current_image, $current_image_tipo) {
        // $new_img = Util::request("current_image_tipo").":". Util::request("current_image");
        global $oConn;

        if (strpos(" " . $current_image, "arquivo:")) {
            $ar = explode("arquivo:", $current_image);

            $current_image = $ar[1];
        }
        if (strpos(" " . $current_image, "url:")) {
            $ar = explode("url:", $current_image);

            $current_image = $ar[1];
        }

        $user["imagem"] = $new_img;

        connAccess::nullBlankColumns($user);
        connAccess::Update($oConn, $user, "usuario", "id");

        $reg = connAccess::fastOne($oConn, "usuario_imagem", " id_usuario = " . $user["id"] . " and imagem like '%" . $current_image . "%'");

        //print_r( $reg ); die(" ". $current_image);
        if (is_array($reg)) {

            connAccess::executeCommand($oConn, " update usuario_imagem set status = 0 where id_usuario = " . $user["id"]);

            $reg["status"] = 1;
            connAccess::Update($oConn, $reg, "usuario_imagem", "id");
        }
    }

    static function salvaArquivoImagem($pastaBase, $id_user, $arquivo, $tipo_imagem = "arquivo") {

        global $oConn;

        //die ( " ----> ". $id_user );
        $sep = DIRECTORY_SEPARATOR;
        
       // die( $pastaBase . $sep . "files" );
        
        if (!file_exists($pastaBase . $sep . "files"))
            mkdir($pastaBase . $sep . "files");


        if (!file_exists($pastaBase . $sep . "files" . $sep . "user"))
            mkdir($pastaBase . $sep . "files" . $sep . "user");


        if (!file_exists($pastaBase . $sep . "files" . $sep . "user" . $sep . $id_user))
            mkdir($pastaBase . $sep . "files" . $sep . "user" . $sep . $id_user);

        $final = $pastaBase . $sep . "files" . $sep . "user" . $sep . $id_user;
        // $nome = 
        $ar = explode(".", $arquivo["name"]);
        $extensao = $ar[count($ar) - 1];

        $lst = Usuario::getImagesUser($id_user);

        $final_nome = Util::left(md5("PA" . date("d-H:m:s") . count($lst) . $tipo_imagem), 10);

        move_uploaded_file($arquivo["tmp_name"], $final . $sep . $final_nome . "." . $extensao);

        if (strtolower($extensao) == "jpg" || strtolower($extensao) == "jpeg") {
            Util::make_thumb($final . $sep . $final_nome . "." . $extensao, $final . $sep . "mini_" . $final_nome . "." . $extensao, 120);
        }

        $registro = $oConn->describleTable("usuario_imagem");

        $registro["id_usuario"] = $id_user;
        $registro["imagem"] = $final_nome . "." . $extensao;
        $registro["tipo"] = $tipo_imagem;
        $registro["status"] = "0";
        connAccess::nullBlankColumns($registro);
        return connAccess::Insert($oConn, $registro, "usuario_imagem", "id");
    }

    static function mostraImagemUser($texto, $id_user, $forca_img_grande = true) {

        if (strpos(" " . $texto, "url:")) {

            $ar = explode("url:", $texto);

            if ($forca_img_grande && strpos(" " . $ar[1], "graph.facebook") > 0) {

                return $ar[1] . "?type=large"; //Para que a imagem do face venha grande..
            }



            return $ar[1];
        }
        $ar = explode("arquivo:", $texto);

        if (strpos(" " . $texto, "galeria:"))
            $ar = explode("galeria:", $texto);


        if (strpos(" " . $texto, "perfil:"))
            $ar = explode("perfil:", $texto);

        if (strpos(" " . $texto, "arquivo:") || strpos(" " . $texto, "galeria:") || strpos(" " . $texto, "perfil:")) {


            if (!$forca_img_grande) {
                if (strpos(" " . strtolower($ar[1]), ".jpg") || strpos(" " . strtolower($ar[1]), ".jpeg")) {

                    return constant("K_RAIZ_DOMINIO") . "files/user/" . $id_user . "/mini_" . $ar[1];
                }
            }


            return constant("K_RAIZ_DOMINIO") . "files/user/" . $id_user . "/" . $ar[1];
        }
        
        return "images/avatar.jpg";
    }

    static function getImagesUser($id, $tipo = "") {

        global $oConn;
        $filtro = "";

        if ($tipo != "") {

            if ($tipo == "perfil") {

                $filtro .= " and tipo in ('" . $tipo . "','url') ";
            } else {

                $filtro .= " and tipo='" . $tipo . "' ";
            }
        } else {

            $filtro .= " and tipo not in ('galeria')  ";
        }

        $ordem = " order by tipo ";

        if ($tipo == "galeria")
            $ordem = " order by id desc ";

        $lista = connAccess::fastQuerie($oConn, "usuario_imagem", " id_usuario = " . $id . "  " . $filtro . $ordem);

        return $lista;
    }

    static function getDadosUser($id, $tipo) {
        global $oConn;

        $lista = connAccess::fastQuerie($oConn, "usuario_dado", " id_usuario = " . $id . " and tipo='" . $tipo . "' order by tipo ");

        if (count($lista) > 0)
            return $lista[0]["texto"];

        return "";
    }

    static function setDadosUser($id_usuario, $texto, $tipo) {
        global $oConn;
        $registro = connAccess::fastOne($oConn, "usuario_dado", " id_usuario = " . $id_usuario . " and tipo='" . $tipo . "' ");

        if (!is_array($registro)) {
            $registro = $oConn->describleTable("usuario_dado");
        }

        $registro["id_usuario"] = $id_usuario;
        $registro["tipo"] = $tipo;
        $registro["texto"] = $texto;

        connAccess::nullBlankColumns($registro);

        if ($registro["id"] == "") {

            connAccess::Insert($oConn, $registro, "usuario_dado", "id", true);
        } else {

            connAccess::Update($oConn, $registro, "usuario_dado", "id");
        }
    }

    static function EditPerfil($id, $prefixo = "", $schema = "") {
        global $oConn;

        $registro = connAccess::fastOne($oConn, $schema . "usuario", " id = " . $id);

        //connAccess::preencheArrayForm($registro, $_POST, "id");

        $registro["nome_completo"] = Util::request($prefixo . "nome_completo");
        $registro["sobrenome"] = Util::request($prefixo . "sobrenome");
        $registro["nome"] =  $registro["nome_completo"];
        
        $registro["email"] = Util::request($prefixo . "email");
        $registro["email2"] = Util::request($prefixo . "email2");
	//	$registro["cnpj"] = Util::request($prefixo . "cnpj");
        $registro["cpf"] = Util::request($prefixo . "cpf");
        $registro["rg"] = Util::request($prefixo . "rg");
        $registro["telefone"] = Util::request($prefixo . "telefone");
        $registro["telefone2"] = Util::request($prefixo . "telefone2");
        $registro["obs"] = Util::request($prefixo . "obs");
        
        

       // if (Util::request($prefixo . "ano") != "" && Util::request($prefixo . "mes") != "" && Util::request($prefixo . "dia") != "") {

          ///  $str_data = Util::request($prefixo . "ano") . "-" . Util::request($prefixo . "mes") . "-" . Util::request($prefixo . "dia");

          //  $registro["data_nascimento"] = $str_data;
        //}

        $registro["data_nascimento"] = Util::dataPg(  Util::request($prefixo . "data_nascimento") );

        //$registro["estado"] = Util::request($prefixo."estado"); 
        $registro["bairro"] = Util::request($prefixo . "bairro");
        $registro["cep"] = Util::request($prefixo . "cep");

        $registro["endereco"] = Util::request($prefixo . "endereco");
        $registro["municipio"] = Util::request($prefixo . "municipio");
        $registro["uf"] = Util::request($prefixo . "estado");
        $registro["auto_descricao"] = Util::request($prefixo . "auto_descricao");
        $registro["genero"] = Util::request($prefixo . "genero");
        $registro["edtr_educacao"] = Util::request($prefixo . "edtr_educacao");
        $registro["edtr_profissao"] = Util::request($prefixo . "edtr_profissao");
        $registro["edtr_empresa"] = Util::request($prefixo . "edtr_empresa");
        $registro["fuso_horario"] = Util::request($prefixo . "fuso_horario");
        $registro["contato_seguranca"] = Util::request($prefixo . "contato_seguranca");
        
        if ( Util::request("current_image") != "" ){
            
            if (strpos(" ". Util::request("current_image"), ":")){
                 $registro["imagem"] =Util::request("current_image"); 
            }else{
            $registro["imagem"] = Util::NVL( Util::request("current_image_tipo"),"arquivo").":".
                           Util::request("current_image");  
            }
        }


        if (trim(Util::request($prefixo . "nova_senha")) != "")
            $registro["senha"] = md5(Util::request($prefixo . "nova_senha"));

        connAccess::nullBlankColumns($registro);
//print_r( $registro ); die (" 00 ");
        
        connAccess::Update($oConn, $registro, $schema . "usuario", "id");
    }

    static function verificaPerfilCompleto($id_usuario) {

        global $oConn;

        $registro = connAccess::fastOne($oConn, "usuario", " id = " . $id_usuario);

        #echo '<pre>';
        #print_r($registro);
        #echo '</pre>';

        if (empty($registro['nome'])) {
            return false;
        }

        if (empty($registro['sobrenome'])) {
            return false;
        }

        if (empty($registro['genero'])) {
            return false;
        }

        if (empty($registro['data_nascimento'])) {
            return false;
        }

        if (empty($registro['email'])) {
            return false;
        }

        if (empty($registro['cpf'])) {
            return false;
        }

        if (empty($registro['rg'])) {
            return false;
        }

        if (empty($registro['endereco'])) {
            return false;
        }

        if (empty($registro['municipio'])) {
            return false;
        }

        if (empty($registro['uf'])) {
            return false;
        }

        if (empty($registro['pais'])) {
            //Pais não está sendo salvo no banco
            #return false;
        }

        if (empty($registro['cep'])) {
            return false;
        }

        return true;
    }

}

?>