<?php

class enviar_email{
	

		
		
	var $host_name = 'smtp.gmail.com';
	var $host_port = 465;
	var $ssl = 1;
	var $start_tls = 0;
	var $user = 'sistemasrendti@gmail.com';
	var $password = 'abc@123123';
							
	
	
	
	
	/*
	Ele pode usar temporariamente: mail.kanchay.com.br
	
	user auth@kanchay.com.br
	senha: HqNZgKiUtJ
		
		
		
	const host_name = 'mail.kanchay.com.br'; //'mail.controlare.com.br';
	const host_port = 587;
	const ssl = true;
	const start_tls = 0;
	const user = 'auth@kanchay.com.br';
	const password = 'HqNZgKiUtJ'; //'abc@123';
	*/
	
	public static function enviar_old($to, $titulo, $mensagem, $nome = ""){
		
							// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
					require_once("Class.phpmailer.php");

					// Inicia a classe PHPMailer
					$mail = new PHPMailer();

					// Define os dados do servidor e tipo de conexão
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->IsSMTP(); // Define que a mensagem será SMTP
					$mail->Host = enviar_email::host_name; // Endereço do servidor SMTP
		            $mail->SMTPAuth = enviar_email::ssl; // Usa autenticação SMTP? (opcional)
		            $mail->Username = enviar_email::user; // Usuário do servidor SMTP
		            $mail->Password = enviar_email::password;  // Senha do servidor SMTP
		            $mail->Port = enviar_email::host_port;

					// Define o remetente
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->From = enviar_email::user; // Seu e-mail
					$mail->FromName = $nome; // Seu nome

					// Define os destinatário(s)
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->AddAddress($to);
					///$mail->AddAddress('ciclano@site.net');
					//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
					//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

					// Define os dados técnicos da Mensagem
					// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
					$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
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

					// Limpa os destinatários e os anexos
					$mail->ClearAllRecipients();
					$mail->ClearAttachments();

					// Exibe uma mensagem de resultado
					if ($enviado) {
					//echo "E-mail enviado com sucesso!";
					} else {
					//echo "Não foi possível enviar o e-mail.<br /><br />";
					//echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
					}
							
	}
	
	
	
	function enviar($to, $titulo, $mensagem, $nome = "", $specialHeader = array(), $replayTo = ""){
     
	
	
		if (  is_array($GLOBALS["arr_smtp"])   ){
			
			$item = $GLOBALS["arr_smtp"];
			
			$this->host_name = $item["smtpServer"];
			$this->host_port = $item["smtpPorta"];
			$this->ssl = $item["smtpSSL"];
			$this->start_tls = $item["smtpTLS"];
			$this->user = $item["smtpEmailAutentication"];
			$this->password = $item["smtpEmailPassw"];
			
		}
	
	require_once("smtp.php");

  /* Uncomment when using SASL authentication mechanisms */
	
		require_once("sasl.php");
	
	
	
		$from=$this->user;                           /* Change this to your address like "me@mydomain.com"; */ $sender_line=__LINE__;
	   
	
	    $smtp=new smtp_class;

		$smtp->host_name= $this->host_name;       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
		$smtp->host_port= $this->host_port;                /* Change this variable to the port of the SMTP server to use, like 465 */
		$smtp->ssl= $this->ssl;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
		$smtp->start_tls= $this->start_tls;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
		$smtp->localhost="localhost";       /* Your computer address */
		$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
		$smtp->timeout=10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
		$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
											   Set to 0 to use the same defined in the timeout variable */
		$smtp->debug= 0;                    /* Set to 1 to output the communication with the SMTP server */
		$smtp->html_debug=0;                /* Set to 1 to format the debug output as HTML */
		$smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
		$smtp->user= $this->user; /* Set to the user name if the server requires authetication */
		$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
		$smtp->password= $this->password;                 /* Set to the authetication password */
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
			
		if ( $replayTo == "" )
			$replayTo = $from;
			
		//"MIME-Version: 1.0\n",
				// construção do cabecalho
		$headers = array( 
				 "Content-Type: text/html; charset='ISO-8859-1'",
				"From: ".$nome." <".$from.">",
				 "Return-Path: <$from>",
				"Reply-to: $nome <$replayTo>",
				"Subject: $titulo",
				"Date:". strftime("%a, %d %b %Y %H:%M:%S %Z"),
				 "X-Priority: 1\n"); 
		
		if ( count($specialHeader) > 0 ){
			$headers = $specialHeader;
		}
		
		
		$windows = true;	
		
		//Testa se o sistema operacional é linux ou windows - Se for linux joga as configurações da ufc.
		if (stristr( PHP_OS, 'WIN')) { 
			$windows = true;
		} else { 
			$windows = false;
		}
			
		if ( $windows ){
			
			enviar_email::envia_comemail($to, $titulo, $mensagem, $nome);
			
		    //sendo windows então estamos numa máquina de deesnvolvimento.. não iremos enviar email.
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
	
	function envia_comemail($to, $titulo, $mensagem, $nome="", $replayTo = "" ){

							    $webmaster_email = $this->user;

								$message = new COM('CDO.Message');
								$messageCon= new COM('CDO.Configuration') ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpserver'] = $this->host_name;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendusername'] = $this->user;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendpassword'] = $this->password;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpserverport'] = $this->host_port;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendusing'] = 2 ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout'] = 60 ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/CdoProtocolsAuthentication'] = 1 ;
								$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpauthenticate'] = 1;
		                        $messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpusessl'] = $this->ssl == 1 ? true : false;
								

							 
									  
								$messageCon->Fields->Update();
								$message->Configuration = $messageCon;
								$message->To = $to;
								$message->From = $webmaster_email;
								$message->Subject = $titulo;
								if ( $replayTo != "" ){
								       $message->ReplyTo = $replayTo;
								}
		                        $message->HTMLBody = $mensagem;
								$message->Send() ;
}
	
	
}


//testando:

//ufc_email::enviar("rafaelrend@gmail.com, rafaelrend@hotmail.com","testando mais um envio de email","<br>Olá <b>Meu amigo</b>. Tudo bem ?","Teste de envio de email");


?>