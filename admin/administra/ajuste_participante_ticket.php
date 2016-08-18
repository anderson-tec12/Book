<?php
require_once("../library/Util.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");


        $oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );
	$oConn->connect();

        
        $sql = " alter table ticket_participante add id_convidado_por int ";
        
        //connAccess::executeCommand($oConn, $sql);
        
        
        $sql = " select tp.*, us.email from ticket_participante tp  "
                . " left join usuario us on us.id = tp.id_usuario  
                    where tp.id_convidado_por is null and tipo not in ('protagonista', 'titular')
                    and us.email is not null ";
        
        $lista = connAccess::fetchData($oConn, $sql);
        $conta = 0;
        for ( $i = 0; $i < count($lista); $i++ ){
            
            $item = $lista[$i];
            
            
            $email = $item["email"];
            
            
            $sql = " select  id_usuario from newsletter where id_ticket = " . $item["id_ticket"] . " and email_list like '%".$email."%' and tipo ='convidado' order by id desc ";
            
            $id_usuario_localizado = connAccess::executeScalar($oConn, $sql);
             echo("<br>". $sql );
            if ( $id_usuario_localizado != ""){
                 $sql = " update ticket_participante set id_convidado_por = " . $id_usuario_localizado . " where id = ". $item["id"];
                
                  connAccess::executeCommand($oConn, $sql);
                 
                  $conta++;
            }
            
            
        }
        
        echo("<br><br>Feito para ". $conta. " de ". count($lista));
                
        
        
        
        
        
   $oConn->disconnect();
?>
