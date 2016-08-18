<?
  $texto = "";
  $msg = "";
  $tipo = Util::NVL( Util::request("tipo"),"tipo");
  $acao = Util::request("acao");

  $titulo = "Texto";
  $legenda = "";
  
  if ( $tipo == "audio" ){
      $legenda = "Informe a url do áudio.";
      $titulo = "Áudio";
  }

  if ( $tipo == "video" ){
      
      $legenda = "Informe a url do vídeo.";
      $titulo = "Vídeo";
  }
  
  if ( $acao == "editar"){
      $texto = Util::request("texto");
       $msg =  $titulo . " salvo com sucesso!";
      Usuario::setDadosUser($id_usuario_logado, $texto, $tipo );
      
  }
  
  
  $texto = Usuario::getDadosUser($id_usuario_logado, $tipo );
?>
<br>
    <?if ( $msg != ""){ ?>
    <div class="mensagem_aviso"><?=$msg?></div>
    <? } ?>
    <form  method="post" name="form_editar_perfil" enctype="multipart/form-data">
<div class="titulo_pagina">Editar Manifesto Pessoal - <?=$titulo ?></div>
<div id="box_conteudo">
    <span><?=$legenda?></span>
    <textarea
        name="texto" id="texto"
        style="width: 90%; height: 60px"><?=$texto?></textarea>
    
    
</div>


<input type="button" name="btSalvar" class="bt_salvar button" value="Salvar" onclick="fn_salvar()">

            <input type="hidden" name="acao" value="">
            <input type="hidden" name="pag" value="<?= Util::request("pag") ?>">
            <input type="hidden" name="tipo" value="<?= Util::request("tipo") ?>">
    </form>           
    <script type="text/javascript">
    
    
    function fn_salvar(){

                var f = document.forms[0];
                f.acao.value = "editar";
                f.submit();
    }
    
    </script>            