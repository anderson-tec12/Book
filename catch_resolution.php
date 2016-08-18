<?php
require_once("admin/library/SessionFacade.php");

session_start();

$acao = @$_GET["acao"];
$x = @$_GET["x"];
$y = @$_GET["y"];

if ( $acao == "redir"){
    
    SessionFacade::setResolution($x, $y);
    
    die("<script>document.location.href='index.php';</script>");
    
}



?>
<body>
    Obtendo resolução para melhor exibição do mapa.
</body>
<script>
   
   function getResolution(){
       
       
       var w = window,
                d = document,
                e = d.documentElement,
                g = d.getElementsByTagName('body')[0],
                x = w.innerWidth || e.clientWidth || g.clientWidth,
                y = w.innerHeight|| e.clientHeight|| g.clientHeight;

       document.location.href='catch_resolution.php?x='+x.toString()+"&y="+y.toString()+'&acao=redir';
   } 
  getResolution();  
</script>
