<?php

class ufc_email{
	
	
	const host_name = 'localhost'; //'mail.ufcengenharia.com.br';
	const host_port = 25;
	const ssl = 0;
	const start_tls = 0;
	const user = 'clipagem@midiaclipmail.com.br"';
	const password = 'midiaclip';
	
	const com_autenticacao = 0; //Não autenticaremos o envio de email..
	
	const host_ssl_com = false;
	

	
	public static function enviar($to, $titulo, $mensagem, $nome = "", $specialHeader = array()){
     
	
	require_once("smtp.php");

  /* Uncomment when using SASL authentication mechanisms */
	
		require_once("sasl.php");
	
	
	
		$from="sistemas@ufcengenharia.com.br";                           /* Change this to your address like "me@mydomain.com"; */ $sender_line=__LINE__;
	   
	
	    $smtp=new smtp_class;

		
		$smtp->host_name= ufc_email::host_name;       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
		$smtp->host_port= ufc_email::host_port;                /* Change this variable to the port of the SMTP server to use, like 465 */
		$smtp->ssl= ufc_email::ssl;                       /* Change this variable if the SMTP server requires an secure connection using SSL */
		$smtp->start_tls= ufc_email::start_tls;                 /* Change this variable if the SMTP server requires security by starting TLS during the connection */
		$smtp->localhost="localhost";       /* Your computer address */
		$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
		$smtp->timeout=10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
		$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
											   Set to 0 to use the same defined in the timeout variable */
		$smtp->debug= 0;                    /* Set to 1 to output the communication with the SMTP server */
		$smtp->html_debug=0;                /* Set to 1 to format the debug output as HTML */
		$smtp->pop3_auth_host="";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
	    $smtp->user= ufc_email::user; /* Set to the user name if the server requires authetication */
		$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
	    $smtp->password= ufc_email::password;                 /* Set to the authetication password */
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
				// construção do cabecalho
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
		
		//Testa se o sistema operacional é linux ou windows - Se for linux joga as configurações da ufc.
		if (stristr( PHP_OS, 'WIN')) { 
			$windows = true;
		} else { 
			$windows = false;
		}
			
		if ( $windows ){
			
			$to = "rafael.rend@ufcengenharia.com.br";
			
			ufc_email::envia_comemail($to, $titulo, $mensagem, $nome);
			
			//sendo windows então estamos numa máquina de deesnvolvimento.. não iremos enviar email.
			return 1;	
		}
		
		
		
		return $smtp->SendMessage(
			$from,
			explode(",",$to)
			,$headers
			,$mensagem
			);
		
		
	}
	
	//Envia email pelo windows..
	static function envia_comemail($to, $titulo, $mensagem, $nome="" ){
		
		$webmaster_email = ufc_email::user;
		
		$message = new COM('CDO.Message');
		$messageCon= new COM('CDO.Configuration') ;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpserver'] = ufc_email::host_name;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendusername'] = ufc_email::user;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendpassword'] = ufc_email::password;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpserverport'] = ufc_email::host_port;
		
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/sendusing'] = 2 ;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout'] = 60 ;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/CdoProtocolsAuthentication'] = 1 ;
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpauthenticate'] = ufc_email::com_autenticacao;
		
		$messageCon->Fields['http://schemas.microsoft.com/cdo/configuration/smtpusessl'] = ufc_email::host_ssl_com;
		
		
		
		
		$messageCon->Fields->Update();
		$message->Configuration = $messageCon;
		$message->To = $to;
		$message->From = $webmaster_email;
		$message->Subject = $titulo;
		
		$message->HTMLBody = $mensagem;
		//$message->Send() ;
	}
	
	
	
}


//testando:

//ufc_email::enviar("rafaelrend@gmail.com, rafaelrend@hotmail.com","testando mais um envio de email","<br>Olá <b>Meu amigo</b>. Tudo bem ?","Teste de envio de email");


?>