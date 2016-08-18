<?php
class chat_ticket{
    
    
    public static function getIDUserSistema(){
        //Por enquanto vou trazer a menor ID de usuário, e vou assumir que ele é o master do sistema.
        //Se for outra forma, iremos ver depois como é isso.
         global $oConn;
         
         $sql = " select min(id) from usuario ";
         $id = connAccess::executeScalar($oConn, $sql);
         $id = -1;
         return $id;
    }
    
    //Gera um token para validações na página de ajax.. nenhuma ação poderá ser realizada sem que o token não esteja ok.
     public static function getMd5Token($id_ticket){
         
         $str = "chat.itapoty.". $id_ticket;
         
         return md5($str);
         
     }
     
     public static function getListaIDSUsuarioEmOrdem($ids ){
           global $oConn;
           
           $sql = " select id from usuario where id in (". $ids. ") order by id ";
           $lista = connAccess::fetchData($oConn, $sql);
           
           return Util::arrayToString($lista, "id");
         
     }
     
    public static function setaIDSChat($id_chat ){
           global $oConn;
           
           $tmp_id = connAccess::executeScalar($oConn, " select id from chat_ticket where coalesce(ids_usuarios,'') ='' and id = ". $id_chat);
           
           if ( $tmp_id != "" ){
           $sql = " select id_usuario from chat_ticket_participante where id_chat = ". $id_chat. " order by id_usuario ";
           $lista = connAccess::fetchData($oConn, $sql);
           
           $ids =  Util::arrayToString($lista, "id_usuario");
           
           $sql = " update chat_ticket  set ids_usuarios='". $ids. "' where id = ". $id_chat;
           
           connAccess::executeCommand($oConn, $sql);
           }
         
     }
     public static function forcaInteracaoDataChatParticipante($id_chat, $id_usuario, $forca_dt_ticket = false ){
           global $oConn;
           
           $sql = " update chat_ticket_participante set ultima_interacao= now() where id_chat = ". $id_chat . " and id_usuario = ".
                   $id_usuario;
           
           connAccess::executeCommand($oConn, $sql);
           if ( $forca_dt_ticket ){
                $sql = " update chat_ticket set ultima_interacao= now() where id = ". $id_chat;
                
                connAccess::executeCommand($oConn, $sql);
           }
           
         
     }
     
     //Identifica se é um bate papo com o sistema; nesse caso não é possível responder.
        public static function ehChatSistema($id_chat ){
                 global $oConn;
                 $id_user_sistema = chat_ticket::getIDUserSistema();
                 
                 
                 $sql = " select id from chat_ticket_participante where id_chat = ". $id_chat . " and id_usuario = ".
                         $id_user_sistema;
                 
                 
                 $lista = connAccess::fetchData($oConn, $sql);
                 if ( count($lista) > 0 )
                     return true;
                 
                 return false;

        }
     
     public static function forcaStatusLidoChatParticipante($id_chat, $id_usuario){
           global $oConn;
           
           $sql = " update chat_ticket set ultimo_lido = now() where id = ". $id_chat;
           connAccess::executeCommand($oConn, $sql);
           
           $sql = " update chat_ticket_mensagem_status set data_lido = now(), lido = 1 where id_chat = ". $id_chat . " and id_usuario = ".
                   $id_usuario. " and coalesce(lido,0) = 0  "; //and data_lido is null
           
           connAccess::executeCommand($oConn, $sql);
         
           $sql = " select count(*) from chat_ticket_mensagem_status where id_chat = ". $id_chat . " and id_usuario = ".
                   $id_usuario. " ";
           
           $qtde = connAccess::executeScalar($oConn, $sql);
           
           if ( $qtde > 15 ){ //Deixar umas 5 mensagens apenas nesse registro de status, para saber se foi lido ou não.
               
               $sql = " select id from chat_ticket_mensagem_status where id_chat = ". $id_chat . " and id_usuario = ".
                   $id_usuario. " order by id asc limit 1 OFFSET 10 ";
               
               $id_maior = connAccess::executeScalar($oConn, $sql);
               
               $sql  = " delete from chat_ticket_mensagem_status where id_chat = ". $id_chat . " and id_usuario = ".
                   $id_usuario. " and id <= " . $id_maior;
               
               connAccess::executeCommand($oConn, $sql); //Deleta o excedente.
           }
     }
     
     public static function mostraMensagensChat($id_chat, $id_ticket ){
           global $oConn;
         
          $id_usuario_ticket =  -1; // connAccess::executeScalar($oConn, " select id_usuario from ticket where id = ". $id_ticket );
           $qtde_mensagens_total = chat_ticket::getQtdeConversaChat($id_chat);
          
           $quebra_mensagem = 60;
           
           $limit = "";
           $id_user_sistema = chat_ticket::getIDUserSistema();
                   
           if ( $qtde_mensagens_total > $quebra_mensagem ){
           ?>
                <div class="mensagens_anteriores">
                    <span></span><a class="iframe_modal bt_link" href="pop_index.php?pag=mensagens_internas_filtro&filtro_chat=<?= $id_chat ?>">Visualize as mensagens anteriores &#187; (<?=$qtde_mensagens_total-$quebra_mensagem; ?>)</a>
                </div>
           <?
              $ini = $qtde_mensagens_total - $quebra_mensagem;
           
              $limit = " limit ".$quebra_mensagem." OFFSET ". $ini; // limit ". $ini .", ". $quebra_mensagem;
           
           }
           
           $sql =  " select ctm.*, us.nome_completo, us.imagem, us.id as id_usuario_ticket from chat_ticket_mensagem ctm "
                   . " left join usuario us on us.id = ctm.id_usuario "
                   . "where ctm.id_chat = ". $id_chat . " order by ctm.id asc ". $limit;
           
           
               //    . " left join ticket ti on ti.id = ctm.id_ticket "
           
         //  echo ( $sql );
           
           $lista = connAccess::fetchData($oConn, $sql);
           
           $nome_usuario_atual = "";
           
           for ( $i = 0; $i < count($lista); $i++ ){
              
              $item = $lista[$i];
              
           $imagem_icone = "images/icon_convidado.jpg";
           $imagem_usuario = "images/icon_convidado.jpg";
           
           
              $data_conversa= $item["data"];
              
                  if ( $item["id_usuario"] == $item["id_usuario_ticket"] ){
                        $imagem_icone ="images/icon_protagonista.jpg";
                  }
                  
                    
                  if ( $item["id_usuario"] == $id_user_sistema){
                        $imagem_icone ="images/icon_sistema.jpg";
                      
                  }
              
               $imagem_usuario = Usuario::mostraImagemUser( $item["imagem"],
                          $item["id_usuario"], false );
               
               if ( $nome_usuario_atual !=  $item["nome_completo"]) {
                   
                   if ( $i > 0 ){
                       ?>
                      	</div>
                       <?
                   }
                   
            ?>

	                                <div class="message aba box_sombra">
						<h4><?= Util::LimitaTamanhoString ( $item["nome_completo"], 30)?></h4>
						<h5><?= Util::PgToOut($data_conversa  ) ?></h5>
             <?       }    ?>
						<p> <?= Util::acento_para_html(  $item["mensagem"] ); ?></p>
                                           <!-- ##ID#<?= $item["id"]?>#ID## -->
				

                                    <? if ( false ) { ?>
                                    <div class="aba box_sombra">
                                         <div class="img_user_mensagens"><img src="<?=$imagem_usuario?>"></div>
                                         <div class="nome_mensagens"><?= Util::LimitaTamanhoString ( $item["nome_completo"], 15)?></div>
                                         <div class="img_tipo_user"><img src="<?=$imagem_icone?>"></div>
                                         <div class="data_mensagens"><?= Util::PgToOut($data_conversa  ) ?></div>
                                         <div class="texto_mensagens">
                                             <?= Util::acento_para_html(  $item["mensagem"] ); ?>
                                         </div>
                                         <!-- ##ID#<?= $item["id"]?>#ID## -->
                                     </div>
                                    <? } ?>
            <?
            $nome_usuario_atual = $item["nome_completo"];
           }
           
           if ( count($lista) > 0 ){
               ?>
                                        </div>                              
               <?                                  
           }
           
     }
     
     public static function mostraMensagem($id_mensagem, $id_usuario_ticket){
         global $oConn;
         
         $id_system_user = chat_ticket::getIDUserSistema();
         
           $lista = connAccess::fetchData($oConn, " select ctm.*, us.nome_completo, us.imagem from chat_ticket_mensagem ctm "
                   . " left join usuario us on us.id = ctm.id_usuario "
                   . "where ctm.id = ". $id_mensagem . " order by ctm.data asc ");
           
           
           if ( count($lista)  > 0  ){
              
              $item = $lista[0];
              
              
           $imagem_icone = "images/icon_convidado.jpg";
           $imagem_usuario = "images/icon_convidado.jpg";
              
              $data_conversa= $item["data"];
              
               if ( $id_usuario_ticket == $item["id_usuario"] ){
                        $imagem_icone ="images/icon_protagonista.jpg";
                  }
              
                  if ( $id_system_user == $item["id_usuario"] ){
                      
                        $imagem_icone ="images/icon_sistema.jpg";
                  }
               $imagem_usuario = Usuario::mostraImagemUser( $item["imagem"],
                          $item["id_usuario"], false );
            ?>
      <div class="message aba box_sombra">
						<h4><?= Util::LimitaTamanhoString ( $item["nome_completo"], 30)?></h4>
						<h5><?= Util::PgToOut($data_conversa  ) ?></h5>
						<p> <?= Util::acento_para_html(  $item["mensagem"] ); ?></p>
                                           <!-- ##ID#<?= $item["id"]?>#ID## -->
					</div>

                                    <? if ( false ) { ?>


                                                                        <div class="aba box_sombra">
                                                                             <div class="img_user_mensagens"><img src="<?=$imagem_usuario?>"></div>
                                                                             <div class="nome_mensagens"><?=Util::LimitaTamanhoString( $item["nome_completo"], 14)?></div>
                                                                             <div class="img_tipo_user"><img src="<?=$imagem_icone?>"></div>
                                                                             <div class="data_mensagens"><?= Util::PgToOut($data_conversa) ?></div>
                                                                             <div class="texto_mensagens">
                                                                                 <?= Util::acento_para_html(  $item["mensagem"] ); ?>
                                                                             </div>
                                                                             <!-- ##IDMSG#<?= $item["id"]?>#IDMSG## -->
                                                                         </div>
                                    <?  } ?>
            <?
            
           }
           
         
         
     }
     
     
     
     public static function getActiveChatID($id_ticket, $id_eu ){
          global $oConn;
          
          $sql = " select id_chat from chat_ticket_participante where id_usuario = ". $id_eu. " and id_ticket = ".
                   $id_ticket. " order by ultima_interacao desc  ";
          
          //echo ( $sql );
          $id_saida = connAccess::executeScalar($oConn, $sql);
          
          return $id_saida; 
         
     }
     
     public static function getTituloChatFormatado( $id_chat, $id_eu, $tipo ){
         
         $txt = self::getTituloChat($id_chat, $id_eu, $tipo);
         $tamanho = strlen("Roberto Vieira, Isabelly Fernanda, Sergio da Silva");
         $stxt = '<h4 class="hint--left" data-hint="'.$txt.'">'. Util::LimitaTamanhoString($txt, $tamanho).' </h4>';
         
         return $stxt;
         
         
     }
     
     public static function getTituloChat($id_chat, $id_eu , $tipo = "titulo"){
          global $oConn;
          
         
         
             $ls_participantes = connAccess::fetchData($oConn, " select us.nome, us.nome_completo, us.imagem "
                      . "  from chat_ticket_participante cp "
                      . "  left join usuario us on us.id = cp.id_usuario "
                      . " where cp.id_chat = " . 
                          $id_chat. " and cp.id_usuario not in ( ". $id_eu . " ) ");
              
             if ( $tipo == "titulo") {
                        if ( count($ls_participantes) == 1 ){                 
                            return $ls_participantes[0]["nome_completo"];
                        }else{

                            return Util::arrayToString($ls_participantes, "nome",", ");
                        }
             }
             
             if ( $tipo == "imagem" ){
                  if ( count($ls_participantes) > 0 ){                 
                      return $ls_participantes[0]["imagem"];
                  }
             }
     }
        public static function getMenuEsquerdoChat($id_ticket, $id_eu, $id_ativo = "" ){
          global $oConn;
          
          $id_usuario_ticket = $id_eu; //connAccess::executeScalar($oConn, " select id_usuario from ticket where id = ". $id_ticket );
          
          $sql = " select ct.* from chat_ticket ct ".
                  " inner join chat_ticket_participante ctp on (ctp.id_chat = ct.id and ctp.id_usuario = ". $id_eu. " ) ".
                 "  where ct.id_ticket = ". $id_ticket .    
                  " order by coalesce( ct.ultima_interacao , ct.data) desc ";
          
            //      " and ct.id in ( select distinct id_chat from chat_ticket_mensagem where id_ticket =  " . $id_ticket . " and coalesce(lido, 0 ) in (0,1)  ) ".
          //echo("<pre>". $sql . "</pre> ");
          $lista = connAccess::fetchData($oConn, $sql);
          
          $id_user_sistema = chat_ticket::getIDUserSistema();
          ?>
             <ul>
            <?
          for ( $i = 0; $i < count($lista); $i++ ){
              
              $item = $lista[$i];
              
              $ls_participantes = connAccess::fetchData($oConn, " select cp.*, us.nome, us.nome_completo, us.imagem, us.obs "
                      . "  from chat_ticket_participante cp "
                      . "  left join usuario us on us.id = cp.id_usuario "
                      . " where cp.id_chat = " . 
                          $item["id"]. " and cp.id_usuario not in ( ". $id_eu . " ) ");
              
              $sql_conta = " select count(*) from chat_ticket_mensagem_status where id_chat = ".
                       $item["id"]. " and id_usuario = ". $id_eu . " and coalesce(lido, 0 ) = 0 ";
              
              //echo( $sql_conta );
              $conta_nao_lida = connAccess::executeScalar($oConn, $sql_conta);
              
              $continua_classe = "";
              if (  $conta_nao_lida > 0 ){                  
                  $continua_classe .= " new";                  
              } else{
                  
                       if ( $id_ativo == $item["id"]){
                            $continua_classe .= " active";
                        }
                  
              }
              
              $nome_participante = "";
              $data_conversa = "";
              $imagem_usuario = "images/icon_convidado.jpg"; //<img src="images/icon_protagonista.jpg">
              $imagem_icone ="images/icon_convidado.jpg";
              $texto_ultima_mensagem = $item["ultima_mensagem"];
              $descricao = "";
              
              if ( count($ls_participantes) > 0 ){
                  
                  $nome_participante = $ls_participantes[0]["nome_completo"];
                  if ( count($ls_participantes) > 1 ){
                      $nome_participante =  Util::arrayToString($ls_participantes,"nome" ,", ");
                  }
                  $data_conversa = Util::NVL( $ls_participantes[0]["ultima_interacao"], $ls_participantes[0]["data"]);
                  $imagem_usuario = Usuario::mostraImagemUser( $ls_participantes[0]["imagem"],
                          $ls_participantes[0]["id_usuario"], false );
                  
                  if ( $id_usuario_ticket == $ls_participantes[0]["id_usuario"] ){
                        $imagem_icone ="images/icon_protagonista.jpg";
                  }
                  
                  if ( $ls_participantes[0]["id_usuario"] == $id_user_sistema){
                        $imagem_icone ="images/icon_sistema.jpg";
                      
                  }
                  $descricao = $ls_participantes[0]["obs"];
                  // $texto_ultima_mensagem = $ls_participantes[0]["ultima_mensagem"];
                   
                   
              }
              ?>
                                         <li id="div_aba<?=$item["id"]?>">
						<div class="popups">
							<a href="#" onclick=" load_chat('<?=$item["id"]?>');">
								<div class="badges">
									<img class="avatar-small" src="<?=$imagem_usuario?>">
                                                                        <? if ( $conta_nao_lida > 0 ) { ?>
									<div class="number-badges"><?=$conta_nao_lida?></div>
                                                                        <? } ?>
								</div>
							</a>
								<span>
									<div class="content-popup">
										<img class="avatar-medium" src="<?=$imagem_usuario?>">
										<h3><?=$nome_participante?></h3>
										<p><?=$descricao?></p>
                                                                                <? if ( false ) { ?>
										<div class="list-icon-posts">
											<div class="post-mini post-fogo"></div>
											<div class="post-mini post-animal"></div>
											<div class="post-mini post-peixe"></div>
											<div class="post-mini post-nadar"></div>
											<div class="post-mini post-escalar"></div>
											<div class="post-mini post-restaurante"></div>
										</div>
                                                                                <? } ?>
									</div>
								</span>
						</div>
					</li>





              <?
              
          }    ?>
                                        
            </ul>
   <?
         
            
         
     }
     
     
     public static function getMenuEsquerdoChat_OLD($id_ticket, $id_eu, $id_ativo = "" ){
          global $oConn;
          
          $id_usuario_ticket = connAccess::executeScalar($oConn, " select id_usuario from ticket where id = ". $id_ticket );
          
          $lista = connAccess::fetchData($oConn, " select ct.* from chat_ticket ct ".
                  " inner join chat_ticket_participante ctp on (ctp.id_chat = ct.id and ctp.id_usuario = ". $id_eu. " ) ".
                 "  where ct.id_ticket = ". $id_ticket .    
                  " and ct.id in ( select distinct id_chat from chat_ticket_mensagem where id_ticket =  " . $id_ticket . " and coalesce(lido, 0 ) in (0,1)  ) ".
                  " order by coalesce( ct.ultima_interacao , ct.data) desc ");
          
          $atual_usuario = "";
          
          $id_user_sistema = chat_ticket::getIDUserSistema();
          
          for ( $i = 0; $i < count($lista); $i++ ){
              
              $item = $lista[$i];
              
              $ls_participantes = connAccess::fetchData($oConn, " select cp.*, us.nome, us.nome_completo, us.imagem "
                      . "  from chat_ticket_participante cp "
                      . "  left join usuario us on us.id = cp.id_usuario "
                      . " where cp.id_chat = " . 
                          $item["id"]. " and cp.id_usuario not in ( ". $id_eu . " ) ");
              
              $sql_conta = " select count(*) from chat_ticket_mensagem_status where id_chat = ".
                       $item["id"]. " and id_usuario = ". $id_eu . " and coalesce(lido, 0 ) = 0 ";
              
              $conta_nao_lida = connAccess::executeScalar($oConn, $sql_conta);
              
              $continua_classe = "";
              if (  $conta_nao_lida > 0 ){                  
                  $continua_classe .= " new";                  
              } else{
                  
                       if ( $id_ativo == $item["id"]){
                            $continua_classe .= " active";
                        }
                  
              }
              
              $nome_participante = "";
              $data_conversa = "";
              $imagem_usuario = "images/icon_convidado.jpg"; //<img src="images/icon_protagonista.jpg">
              $imagem_icone ="images/icon_convidado.jpg";
              $texto_ultima_mensagem = $item["ultima_mensagem"];
              
              if ( count($ls_participantes) > 0 ){
                  
                  $nome_participante = $ls_participantes[0]["nome_completo"];
                  if ( count($ls_participantes) > 1 ){
                      $nome_participante =  Util::arrayToString($ls_participantes,"nome" ,", ");
                  }
                  $data_conversa = Util::NVL( $ls_participantes[0]["ultima_interacao"], $ls_participantes[0]["data"]);
                  $imagem_usuario = Usuario::mostraImagemUser( $ls_participantes[0]["imagem"],
                          $ls_participantes[0]["id_usuario"], false );
                  
                  if ( $id_usuario_ticket == $ls_participantes[0]["id_usuario"] ){
                        $imagem_icone ="images/icon_protagonista.jpg";
                  }
                  
                  if ( $ls_participantes[0]["id_usuario"] == $id_user_sistema){
                        $imagem_icone ="images/icon_sistema.jpg";
                      
                  }
                  
                  // $texto_ultima_mensagem = $ls_participantes[0]["ultima_mensagem"];
                   
                   
              }
              
              
              
              ?>
                 <div id="div_aba<?=$item["id"]?>" class="aba<?=$continua_classe?>" onclick=" load_chat('<?=$item["id"]?>');">
                     <div class="img_user_mensagens"><img src="<?=$imagem_usuario?>"></div>
                     <div class="nome_mensagens"><?= Util::LimitaTamanhoString( $nome_participante, 24) ?></div>
                     <div class="data_mensagens"><?= Util::PgToOut($data_conversa, true) ?></div>
                     <div class="img_tipo_user"><img src="<?=$imagem_icone?>"></div>
                     <div class="texto_mensagens"><?= Util::LimitaTamanhoString($texto_ultima_mensagem, 32) ?></div>
                 </div>

              <?
              
          }
         
            
         
     }
     
     
     public static function getQtdeConversaChat($id_chat, $complemento = ""){
         global $oConn;
         $sql_conta = " select count(*) from chat_ticket_mensagem where id_chat = ". $id_chat;
         
         $sql_conta .= $complemento;
         
         $qtde_mensagens = connAccess::executeScalar($oConn, $sql_conta);
         
         
         return $qtde_mensagens;
         
     }
     
       
     public static function getQtdeConversaTicket($id_ticket, $complemento = ""){ //Para o menu da esquerda do chat.
         global $oConn;
         $sql_conta = " select count(*) from chat_ticket_mensagem where id_ticket = ". $id_ticket;
         
         $sql_conta .= $complemento;
         
         $qtde_mensagens = connAccess::executeScalar($oConn, $sql_conta);
         
         return $qtde_mensagens;
         
     }
     
     //Obtém a quantidade de conversas ainda não lida, filtrando de acordo ao ticket..
       public static function getQtdeConversaNaoLidaTicket($id_ticket, $id_usuario, $complemento = ""){ //Para o menu da esquerda do chat.
         global $oConn;
         
         $sql_conta = " select count(stat.*) as qtde from chat_ticket cht                  
                          inner join chat_ticket_participante part on ( part.id_chat = cht.id and part.id_usuario =  ". $id_usuario ." ) 
                          inner join chat_ticket_mensagem msg on msg.id_chat = cht.id 
                          inner join chat_ticket_mensagem_status stat on ( stat.id_mensagem = msg.id and stat.id_usuario = ". $id_usuario ." ) 
                              where cht.id_ticket = " . $id_ticket . " and coalesce(stat.lido,0) = 0 ";
         
         $sql_conta .= $complemento;
         if ( Util::request("debug") == "1"){
                //  echo("<pre>" .$sql_conta. "</pre>");
             
         }
         $qtde_mensagens = connAccess::executeScalar($oConn, $sql_conta);
         
         return $qtde_mensagens;
         
     }
  
    
     public static function geraNovoChatTicket($id_ticket, $ids_usuarios){
         global $oConn;
         
        $registro = array(
                "id"=>"",
                "data"=>"",
                "id_ticket"=>"",
                "ultima_interacao"=>"",
                "status"=>"" ,"ids_usuarios"=>""          
            );
	
        $registro["data"] = Util::getCurrentBDdate();
        $registro["id_ticket"] = $id_ticket;
        $registro["status"] ="";
        $registro["ids_usuarios"]  = chat_ticket::getListaIDSUsuarioEmOrdem($ids_usuarios);	
        
  	connAccess::nullBlankColumns( $registro );	
	 
	if (! @$registro["id"] ){	
	     $registro["id"] = connAccess::Insert($oConn, $registro, "chat_ticket", "id", true);
        }
        
        $ars = explode(",", $ids_usuarios);
        $item = array("id_usuario"=>"", "id_ticket"=>"", "id_chat"=>"");
        
        for ( $y = 0; $y < count($ars); $y++){
         
            if ( trim($ars[$y]) == "")
                continue;
            
            $item["id_usuario"] = $ars[$y];
            $item["id_ticket"] = $id_ticket;
            $item["id_chat"]  = $registro["id"];
            $item["data"]  = Util::getCurrentBDdate();
            $item["ultima_interacao"]  = Util::getCurrentBDdate();			 
		    
  	    connAccess::nullBlankColumns( $item );  
            connAccess::Insert($oConn, $item, "chat_ticket_participante", "id", true);
        }
        return $registro["id"];
     }
     
     static function novaMensagem($id_ticket, $id_chat, $id_usuario, $mensagem ){
            global $oConn;
            
          $registro = array(
                "id"=>"",
                "data"=>"",
                "id_ticket"=>"",
                "id_chat"=>"",
                "mensagem"=>"",
                "id_usuario"=>""
            );
         
        $registro["data"] = Util::getCurrentBDdate();
        $registro["id_ticket"] = $id_ticket;
        $registro["id_usuario"] = $id_usuario;
        $registro["id_chat"] = $id_chat;
        $registro["mensagem"] = $mensagem;
        //$registro["status"] = 1;
        
  	connAccess::nullBlankColumns( $registro );  
        $registro["id"] = connAccess::Insert($oConn, $registro, "chat_ticket_mensagem", "id", true);
       
        chat_ticket::setaUltimaInteracaoChatParticipante($id_chat, $id_usuario );
        chat_ticket::indicaStatus($id_chat, $id_usuario, "" , $mensagem );
        
        $listas = connAccess::fastQuerie($oConn, "chat_ticket_participante"," id_chat = " . $id_chat);
        
        $reg_status = array("id_mensagem"=>"",
                    "id_usuario"=>"", "lido"=>"", "id_chat"=>"", "data_lido"=>""            
            );
        
        for ( $y = 0; $y < count($listas); $y++){
              $item = $listas[$y];
            
               $reg_status["id_usuario"] = $item["id_usuario"];
               $reg_status["id_mensagem"] = $registro["id"];
               $reg_status["id_chat"] = $id_chat;
               $reg_status["lido"] = "0";
               
               if ( $item["id_usuario"] == $id_usuario ){ //Quem escreveu já leu..
                   $reg_status["lido"] = "1";
                   $reg_status["data_lido"] = Util::getCurrentBDdate();
               }
               
        
  	        connAccess::nullBlankColumns( $reg_status );  
                $reg_status["id"] = connAccess::Insert($oConn, $reg_status, "chat_ticket_mensagem_status", "id", true);
               
        }
        
        
        return $registro["id"];
       
     }
     
     static function setaUltimaInteracaoChatParticipante($id_chat, $id_usuario ){
         global $oConn;
	    $registro = connAccess::fastOne($oConn, "chat_ticket_participante"," id_chat = " . $id_chat. " and id_usuario = ". $id_usuario );
            $registro["ultima_interacao"] =  Util::getCurrentBDdate();
  	    connAccess::nullBlankColumns( $registro );  
               
            connAccess::Update($oConn, $registro, "chat_ticket_participante", "id");
         
     }
     
     static function indicaStatus($id_chat, $id_usuario, $status, $msg = "" ){
           global $oConn;
         
	   $registro = connAccess::fastOne($oConn, "chat_ticket"," id = " . $id_chat );
           
           if ( count($registro) > 0 ){
               
                $registro["status"] =$status;
                $registro["ultima_interacao"] = Util::getCurrentBDdate();
                
                if ( $msg != "" ){
                    $registro["ultima_mensagem"] =$msg;                    
                }
  	        connAccess::nullBlankColumns( $registro );  
               
                connAccess::Update($oConn, $registro, "chat_ticket", "id");
           }
           
           
     }
     
     static function getListaUsuariosMensagem($id_ticket, $id_eu = ""){
          global $oConn;
            
          /*
          $sql = " select distinct p.id_usuario, u.nome , coalesce(u.nome_completo, u.nome ) as nome_completo, u.nome_completo as nome_completo02, u.email, u.email as email02 "
                  . " from ticket_participante p left join usuario u on u.id = p.id_usuario where p.id_ticket = ". $id_ticket. 
                " and p.tipo in ('convidado','protagonista') and u.verificado_email = 1 ";
          
          if ( $id_eu != "")
            $sql .= " and p.id_usuario not in ( ". $id_eu . " ) ";
           * 
           */
          
          $sql = " select distinct  u.nome , u.imagem,  coalesce(u.nome_completo, u.nome ) as nome_completo, u.nome_completo as nome_completo02, u.email, u.email as email02, u.id as id_usuario "
               . " from  usuario  u where u.verificado_email = 1 ";
          
          if ( $id_eu != "")
            $sql .= " and u.id not in ( ". $id_eu . " ) ";
          
          $sql .= "  order by u.nome_completo ";
        //echo($sql );
          $lista = connAccess::fetchData($oConn, $sql);
         
          return $lista;
     }
     
     
     
     
      static function enviaMensagemSistema($id_usuario, $id_ticket, $msg) {

        global $oConn;

        $idUsuarioSistema = chat_ticket::getIDUserSistema();

        $ids_testa = chat_ticket::getListaIDSUsuarioEmOrdem($id_usuario . "," . $idUsuarioSistema);

        $id_chat = "";

        $sql = " select id from chat_ticket where id_ticket = " . $id_ticket . " and ids_usuarios='" . $ids_testa . "' ";

        //echo($sql);
        $lista = connAccess::fetchData($oConn, $sql);

        if (count($lista) > 0) {
            $id_chat = $lista[0]["id"];
        }

        if ($id_chat == "") {
            $id_chat = chat_ticket::geraNovoChatTicket($id_ticket, $ids_testa);
        }

        chat_ticket::novaMensagem($id_ticket, $id_chat, $idUsuarioSistema, $msg);
    }
    
    
     public static function getMensagensNaoLida($id_usuario, $id_chat = "", $commando = "", $complemento = ""){
         
             global $oConn;
        
              $sql_conta = " select count(*) from chat_ticket_mensagem_status where "
                             . " id_usuario ".$commando." in ( ". $id_usuario . " ) and coalesce(lido, 0 ) = 0 ";

             if ( $id_chat != "" )
                 $sql_conta .= " and id_chat = ". $id_chat;
              
              $sql_conta .= $complemento;
              
             $qtde_conta =  connAccess::executeScalar($oConn, $sql_conta );
             
             return $qtde_conta;
         
     }
     
     
}  
    
    
?>