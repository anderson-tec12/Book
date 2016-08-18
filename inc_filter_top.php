
<h3 class="hint--bottom" data-hint="Clique nas marcações ao lado para filtrar no mapa">Filtrar</h3>

<?
$sql = " select * from marcacao_tipo where id in ( select distinct id_tipo_marcacao from marcacao ) ";
$lista = connAccess::fetchData($oConn, $sql );
?>

<div class="filters-check">
  <? for ( $i = 0; $i < count($lista); $i++ ) { 
     
    $item = $lista[$i];
    $estilo = 'background: url(\'files/marcacao_tipo/'.$item["imagem"].'\') no-repeat;';
    $imagem = 'files/marcacao_tipo/'.$item["imagem"];
     
  ?>
    
  <!--<input type="checkbox"  id="myCheckbox<?=$i?>" class="myCheckbox"/>
	<label for="myCheckbox<?=$i?>" style="<?=$estilo?>" class="hint--bottom" data-hint="<?=$item["nome"]?>"></label>-->
  

  <!-- Todos estarão ativo "colorido", quando a pessoa clicar para filtrar, você deixa a class "icons-posts alpha" -->
  <a class="hint--bottom" data-hint="<?=$item["nome"]?>"><img class="icons-posts" onclick="layer_filtro(this, '<?=$item["id"]?>')" id="img_filtro_<?=$item["id"]?>" src="<?=$imagem?>"></a>
    
  <? } ?>
</div>

<div class="tips">
	<div class="icon-buttons">
		<a class="hint--bottom icon-move" data-hint="Clique e segure para movimentar o mapa"></a>
		<a class="hint--bottom icon-add-post" data-hint="Escolha o local desejado no mapa e clique duas vezes para fazer sua marcação"></a>
		<a class="hint--bottom icon-help" data-hint="Conheça mais o Protetores da Cuesta" href="#" target="blank"></a>
	</div>
</div>