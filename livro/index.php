<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atlas da Cuesta</title>

    <!-- Biblioteca jquery -->
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script-->

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/base.min.css">
    <link rel="stylesheet" href="css/reset.min.css">
    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/alert-custom.min.css">
    <link rel="stylesheet" href="css/style.min.css">

</head>

<body>
    <!-- Filtro Topo -->
    <header class="header-filtro">
        <? require_once 'inc_menu-top.php'; ?>
    </header>
    <!-- Gaveta -->
    <nav class="drawer">
        <? require_once 'inc_drawer.php'; ?>
    </nav>
    <!-- Mapa / Livro -->
    <section id="atlas" class="atlas">
        <? require_once 'inc_atlas-da-cuesta.php'; ?>
    </section>
    <!-- Chat -->
    <aside class="chat">
        <? require_once 'inc_chat.php'; ?>
    </aside>


<!-- JS -->
<script src="js/jquery.min.js"></script>
<script src="js/modal-jquery-colorbox.js"></script>
<script src="js/alert-custom.js"></script>
<script src="js/dragdealer.js"></script>
<script src="js/script.js"></script>

<script type="text/javascript">
  $(document).ready(function () {

    function highlight(){
      var color = $('.wrapper').css('color');
      console.log(color);
      $('.highlight').css('background-color', color);
    };
    highlight();

    var navLink = $('.menu-item-link'), // Links que fazer a requisição
      content = '.wrapper' //'#content', //Conteudo que é requisitado
      main = $('#atlas');//$('#main'); //Conteiner que recebe o conteudo

    //Adicionado propriedades a primeira pagina aberta pelo browser
    //--------------------------------------------------------------
    //Definindo o state
    var local = window.location.pathname.split('/').pop();
    window.history.pushState({page: local}, null, "");

    menuFeedback();

    //Requisitando o conteudo
    //--------------------------------------------------------------
    navLink.on('click', function(e){
      var href = $(this).attr('href');
      e.preventDefault();
      //Carregando o especifco requisitado
      main.fadeOut('fast', function(){
        main.load(href+' '+content, function(){
          main.fadeIn('fast');
        });
      });
      //Definindo o state
      window.history.pushState({page: href}, null, href);

      menuFeedback();
    });

    //Garante a navegação as páginas que o usuario já navegou
    //--------------------------------------------------------------
    window.addEventListener('popstate', function(event) {
      //Definindo o state
      if(event.state) {
        var pageState = event.state.page;
      }
      //Carregando o especifco requisitado
      main.fadeOut('fast', function(){
        main.load(pageState+' '+content, function(){
          main.fadeIn('fast');
        });
      });

      menuFeedback();
    });

    //verifica a pagina atual e adiciona a classe .active ao seu link no menu
    //--------------------------------------------------------------
    function menuFeedback() {
      $(this).addClass('active');
      var local = window.location.pathname.split('/').pop();
      navLink.each(function(){
        if ($(this).attr('href') == local ) {
          $(this).parent().addClass('actived');
        } else {
          $(this).parent().removeClass('actived');
        }
      });
    };
  });
</script>
</script>

</body>
</html>
