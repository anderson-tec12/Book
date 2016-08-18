<?php

if ( Util::request("btEnviarEmail") != "" ){
	
	    $G_email_path = ".";
            $msg = "Teste de envio de email";
            $email = Util::request("email");
            
            $msg_retorno = Util::enviarEmail($email, utf8_decode("Página de testes de email 1Acordo"), $msg, "1Acordo");

            echo("<br> Mensagem de retorno ". $msg_retorno);
}

Util::mensagemCadastro(85);



?>
<h1>Página para testes do sistema.</h1>
<form method="post">
    <input type="hidden" name="pag" value="<?=Util::request("pag") ?>" >
    <input type="hidden" name="mod" value="<?=Util::request("mod") ?>" >
    <input type="text" placeholder="Informe o email que vai receber o teste" name="email" value="<?=Util::request("email") ?>" >
    
    
    <input type="submit" class="botao" name="btEnviarEmail" value="Testar Envio Email" >
</form>