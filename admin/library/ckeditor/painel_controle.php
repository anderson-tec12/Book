<?
require_once("../library/Util.php");
require_once("../config.php");
require_once("../persist/IDbPersist.php");
require_once("../persist/connAccess.php");
require_once("../persist/FactoryConn.php");
require_once("../inc_usuario.php");
require_once("../inc_ticket.php");
require_once("../library/SessionCliente.php");

$oConn = FactoryConn::getConn( constant("K_CONN_TYPE") );

function fn_write($data ){
    
    //return $data;
    return utf8_decode($data);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>

<title>Painel de Controle</title>

<!-- CSS -->
<link href="../css/padrao.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/painel_controle.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/skeleton.css" rel="stylesheet" type="text/css" media="all" />

<!-- Banner Slide Carrossel -->
<script src="js/banner_carrossel.js"></script>

<!-- Modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jquery.modal.colorbox-min.js?t=6"></script>    

<!-- Editor Rico -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../javascript/validacampos.js"></script>

<!-- Abas -->
<script type="text/javascript" src="js/simpletabs.js"></script>

</head>

<? 
 
     require_once 'inc_usuario_load.php';
     
     $G_USER = Usuario::loadById($oConn, $id_usuario_logado );
     
     $center_include = Util::request("cnt");
     $pag = Util::request("pag");

     $file_to_include ="";
     
     if ($pag == "" &&  SessionCliente::getIncludeUrlOnMessage() != "" ){
          $pag = SessionCliente::getIncludeUrlOnMessage();
          
     }
     if ( $pag == ""){
          $pag =SessionCliente::getValorSessao("include");
     }
     if ($pag == "" ){
         
        $ticket =  ticket::getLastTicket( $id_usuario_logado );
        //die ( "---> ". $ticket_id );
            if (is_array($ticket)  ){ 
                    SessionCliente::setValorSessao("ticket_id", $ticket["id"]);
                    $pag = "inc_segundo_acesso_iniciou_objetivo";
            } 
         
     }
     
     if ($pag == "" && $G_USER["origem_cadastro"] == "convite" ){
         
               $convite_id = ticket::getUltimoConvitePorParticipante($oConn , $id_usuario_logado, "convidado"  );
           
               if ( $convite_id != "" ){ 
                      SessionCliente::setValorSessao("convite_id", $convite_id);
                      $pag = "inc_convidado_primeiro_acesso_email";
               }
     }
    
     //die ( $pag . " 000 ");
     
				//die ( $pag . " -- ");
      if ( $pag != "" && file_exists(realpath(".").DIRECTORY_SEPARATOR. $pag.".php")){
							 
                            $file_to_include =  $pag.'.php';			 
                        } else {
                        
                            if (  $G_USER["origem_cadastro"] == "" )
                               $file_to_include =  'inc_box_conteudo.php'; 
                            else 
                               $file_to_include =  'inc_cadastro_conta_propria.php'; 
                                
       }

?>

<body>

<header>
	<div class="container">

        <!-- Cabeçalho -->
        <? require_once 'inc_header.php';  ?>

        <!-- Box Centro -->
        <div class="centro">
            <? if ( $center_include == "1") { 
                //Faz include no arquivo inteiro, sem as laterais.
                        if ( $file_to_include != "" ){
                             require_once($file_to_include);
                        }
            } else { //Com esquerda e Direita (Padrão) ?>
        </div><!-- /centro -->

        <!-- Banner Fixo -->
        <? require_once 'inc_banner.php';  ?>

    </div><!-- /container -->
</header>



<div class="container">

    <!-- Box Esquerdo -->
    <aside class="left">  
		<? require_once 'inc_box_user.php';  ?>
    </aside><!-- /left -->  

    <!-- Box Direito -->
    <aside class="right">
        <? if ( $file_to_include != "" ){
             require_once($file_to_include);
        } ?>
    </aside><!-- /right -->  
      
    <? } ?>    

    <a name="end_wrapper" id="end_wrapper"></a>

</div><!-- /container -->


<footer>

<div class="container container-twelve">
    <div class="three columns">
        <nav class="menu_rodape">
        <h3>Menu 1</h3>
            <ul>
                <li><a href="#">Lorem ipsum dolor</a></li>
                <li><a href="#">Lorem ipsum dolor</a></li>
                <li><a href="#">Lorem ipsum dolor</a></li>
                <li><a href="#">Lorem ipsum dolor</a></li>
                <li><a href="#">Lorem ipsum dolor</a></li>
                <li><a href="#">Lorem ipsum dolor</a></li>
                <li><a href="#">Lorem ipsum dolor</a></li>
            </ul>
        </nav>
    </div>

    <div class="three columns">
        <nav class="menu_rodape">
        <h3>Menu 2</h3>
            <ul>
                <li><a href="#">Lorem ipsum dolor</a></li>
            </ul>
        </nav>
    </div>

    <div class="three columns">
        <nav class="menu_rodape">
        <h3>Menu 3</h3>
            <ul>
                <li><a href="#">Lorem ipsum dolor</a></li>
            </ul>
        </nav>
    </div>

    <div class="three columns">
        <div class="linguagem"></div>
    </div>
</div>



<div class="contato">

    <div class="container container-twelve">
        <div class="two columns">
            <a href="/portal/" target="_top" class="logo_rodape bt"><span>Possível Acordo</span></a>
        </div>

        <div class="two columns offset-by-eight">
            <div class="rede_social">
                <a class="youtube" href="https://www.youtube.com" target="_blank"><span>Youtube</span></a>
                <a class="linkedin" href="https://br.linkedin.com/" target="_blank"><span>Linkedin</span></a>
                <a class="twitter" href="https://twitter.com/" target="_blank"><span>Twitter</span></a>
                <a class="facebook" href="https://www.facebook.com/" target="_blank"><span>Facebook</span></a>
            </div>
        </div>
    </div>

</div>

</footer>



<!-- Modal -->  
<script>
	$(document).ready(function(){
		$(".youtube_modal").colorbox({iframe:true, innerWidth:845, innerHeight:445});
		$(".vimeo_modal").colorbox({iframe:true, innerWidth:845, innerHeight:476});
		$(".iframe_modal").colorbox({iframe:true, innerWidth:925, innerHeight:700});
		$(".imagem_modal").colorbox({imagem_modal:true, innerWidth:845, height:"auto"});
	});
</script>

</body>
</html>



<? //SessionCliente::setMensagem("");
$oConn->disconnect(); ?>