<?php

class enviar_email{
	

	
	/*
	
	
	Ele pode usar temporariamente: mail.kanchay.com.br

	user auth@kanchay.com.br
	senha: HqNZgKiUtJ
	
   const host_name = 'smtps.uol.com.br';
	const host_port = 587;
	const ssl = 0;
	const start_tls = 1;
	const user = 'rendti@uol.com.br';
	const password = 'xuxu25';
         * 
         * 
         const host_name = 'mail.kanchay.com.br'; //'mail.controlare.com.br';
	const host_port = 587;
	const ssl = 1;
	const start_tls = 0;
	const user = 'auth@kanchay.com.br';
	const password = 'HqNZgKiUtJ'; //'abc@123';
        
         * 
         * 
         * 	const host_name = 'smtp.gmail.com'; //'mail.controlare.com.br';
	const host_port = 587;
	const ssl = 0;
	const start_tls = 1;
	const SMTPAuth    = 1;
	const user = 'sistemasrendti@gmail.com';
	const password = 'abc@123123';	
	
	
 
     
	
	*/

	const host_name = 'smtps.uol.com.br';
	const host_port = 587;
	const ssl = 0;
	const start_tls = 1;
	const SMTPAuth    = 1;
	const user = 'rendti@uol.com.br';
	const password = 'xuxu25';
	
	public static function getLanguage(){
            
            $PHPMAILER_LANG = array();
     
                $PHPMAILER_LANG["provide_address"] = 'You must provide at least one ' .
                                                    'recipient email address.';
               $PHPMAILER_LANG["mailer_not_supported"] = ' mailer is not supported.';
               $PHPMAILER_LANG["execute"] = 'Could not execute: ';
               $PHPMAILER_LANG["instantiate"] = 'Could not instantiate mail function.';
               $PHPMAILER_LANG["authenticate"] = 'SMTP Error: Could not authenticate.';
               $PHPMAILER_LANG["from_failed"] = 'The following From address failed: ';
               $PHPMAILER_LANG["recipients_failed"] = 'SMTP Error: The following ' .
                                                      'recipients failed: ';
               $PHPMAILER_LANG["data_not_accepted"] = 'SMTP Error: Data not accepted.';
               $PHPMAILER_LANG["connect_host"] = 'SMTP Error: Could not connect to SMTP host.';
               $PHPMAILER_LANG["file_access"] = 'Could not access file: ';
               $PHPMAILER_LANG["file_open"] = 'File Error: Could not open file: ';
               $PHPMAILER_LANG["encoding"] = 'Unknown encoding: ';
            
               return $PHPMAILER_LANG;
        }
	public static function enviar($to, $titulo, $mensagem, $nome = ""){
		
							// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
					require_once("class.phpmailer.php");

					// Inicia a classe PHPMailer
					$mail = new PHPMailer();
$mail->SMTPDebug  = 1;
					// Define os dados do servidor e tipo de conex�o
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->IsSMTP(); // Define que a mensagem ser� SMTP
					$mail->Host = enviar_email::host_name; // Endere�o do servidor SMTP
                                        
                                        if ( enviar_email::ssl )
                                            $mail->SMTPSecure = "ssl";
                                        
                                        if ( enviar_email::start_tls )
                                            $mail->SMTPSecure = "tls";
                                        
                                        $mail->SMTPAuth = enviar_email::SMTPAuth; // Usa autentica��o SMTP? (opcional)
                                        $mail->Username = enviar_email::user; // Usu�rio do servidor SMTP
                                        $mail->Password = enviar_email::password;  // Senha do servidor SMTP
                                        $mail->Port = enviar_email::host_port;
                                       
                                        
                                        //$mail->SetLanguage( enviar_email::getLanguage() );
					// Define o remetente
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->From = enviar_email::user; // Seu e-mail
					$mail->FromName = $nome; // Seu nome

					// Define os destinat�rio(s)
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->AddAddress($to);
					///$mail->AddAddress('ciclano@site.net');
					//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
					//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // C�pia Oculta

					// Define os dados t�cnicos da Mensagem
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
					//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

					// Define a mensagem (Texto e Assunto)
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->Subject  = $titulo; // Assunto da mensagem
					$mail->Body = $mensagem;
		            $mail->AltBody = strip_tags( $mensagem );

					// Define os anexos (opcional)
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

				
					// Envia o e-mail
					$enviado = $mail->Send();

					// Limpa os destinat�rios e os anexos
					$mail->ClearAllRecipients();
					$mail->ClearAttachments();

					// Exibe uma mensagem de resultado
					if ($enviado) {
					//echo "E-mail enviado com sucesso!";
					} else {
					echo "Não foi possível enviar o email.<br /><br />";
					echo "<b>Erro:</b> <br />" . $mail->ErrorInfo;
					}
                                        
                                        
                       return $mail->ErrorInfo;                 
                                        
                                        
                                        
							
	}
	
	
	
	public static function enviar_old($to, $titulo, $mensagem, $nome = "", $specialHeader = array()){
     
	
	require_once("smtp.php");

  /* Uncomment when using SASL authentication mechanisms */
	
		require_once("sasl.php");
	
	
	
		$from=enviar_email::user;                           /* Change this to your address like "me@mydomain.com"; */ $sender_line=__LINE__;
	   
	
	    $smtp=new smtp_class;

		$smtp->host_name= enviar_email::host_name;       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
		$smtp->host_port= enviar_email::host_port;                /* Change this variable to the port of the SMTP server to use, like 465 */
		$smtp->ssl= enviar_email::ssl;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
		$smtp->start_tls= enviar_email::start_tls;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
		$smtp->localhost="localhost";       /* Your computer address */
		$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
		$smtp->timeout=10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
		$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
											   Set to 0 to use the same defined in the timeout variable */
		$smtp->debug= 0;                    /* Set to 1 to output the communication with the SMTP server */
		$smtp->html_debug=0;                /* Set to 1 to format the debug output as HTML */
		$smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
	    $smtp->user= enviar_email::user; /* Set to the user name if the server requires authetication */
		$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
	    $smtp->password= enviar_email::password;                 /* Set to the authetication password */
		$smtp->workstation="";              /* Workstation name for NTLM authentication */
		$smtp->authentication_mechanism=""; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
											   Leave it empty to make the class negotiate if necessary */

        //$smtp->
			if($smtp->direct_delivery)
			{
				if(!function_exists("GetMXRR"))
				{
					$_NAMESERVERS=array();
					include("getmxrr.php");
				}
			
			}
			
		//"MIME-Version: 1.0\n",
				// constru��o do cabecalho
		$headers = array( 
				 "Content-Type: text/html; charset='ISO-8859-1'",
				"From: ".$nome." <".$from.">",
				 "Return-Path: <$from>",
				"Reply-to: $nome <$from>",
				"Subject: $titulo",
				"Date:". strftime("%a, %d %b %Y %H:%M:%S %Z"),
				 "X-Priority: 1\n"); 
		
		if ( count($specialHeader) > 0 ){
			$headers = $specialHeader;
		}
		
		
		$windows = true;	
		
		//Testa se o sistema operacional � linux ou windows - Se for linux joga as configura��es da ufc.
		if (stristr( PHP_OS, 'WIN')) { 
			$windows = true;
		} else { 
			$windows = false;
		}
			
		if ( $windows ){
			
			enviar_email::envia_comemail($to, $titulo, $mensagem, $nome);
			
		    //sendo windows ent�o estamos numa m�quina de deesnvolvimento.. n�o iremos enviar email.
		   	return 1;	
		}
		
		
		//die("oiii?");
		
		
		return $smtp->SendMessage(
				$from,
				explode(",",$to)
				,$headers
				,$mensagem
				);
				

		
		
	}
	
	static function envia_comemail($to, $titulo, $mensagem, $nome="" ){

							$webmaster_email = enviar_email::user;

								$message = new COM('CDO.Message');
								$messageCon= new COM('CDO.Configuration') ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpserver'] = enviar_email::host_name;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendusername'] = enviar_email::user;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendpassword'] = enviar_email::password;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpserverport'] = enviar_email::host_port;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendusing'] = 2 ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout'] = 60 ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/CdoProtocolsAuthentication'] = 1 ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpauthenticate'] = 1;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpusessl'] = true;
								

							 
									  
								$messageCon->Fields->Update();
								$message->Configuration = $messageCon;
								$message->To = $to;
								$message->From = $webmaster_email;
								$message->Subject = $titulo;
								
		$message->HTMLBody = $mensagem;
								$message->Send() ;
}
	
	
}


//testando:

//ufc_email::enviar("rafaelrend@gmail.com, rafaelrend@hotmail.com","testando mais um envio de email","<br>Ol� <b>Meu amigo</b>. Tudo bem ?","Teste de envio de email");


?>