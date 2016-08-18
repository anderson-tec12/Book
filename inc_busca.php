<?php



$argumento_busca = componente_template::formataArgumentoPesquisa( Util::request("search") );


$sql = " select id, nome as titulo, ts_rank_cd( ct.texto_srch, plainto_tsquery('portuguese', ".$argumento_busca." )) as rank, 'pagina' as tipo from custom.componente_template ct "
        . "  where ( ct.id in ( select sub.id_componente_template from custom.componente_template_item sub where  "
        . "           plainto_tsquery('portuguese', ".$argumento_busca.") @@ sub.texto_srch ) 
                   or plainto_tsquery('portuguese', ".$argumento_busca.") @@ ct.texto_srch )
         UNION select id, titulo, ts_rank_cd( cap.texto_srch, plainto_tsquery('portuguese', ".$argumento_busca." )) as rank, 'capitulo' as tipo  from custom.capitulo cap 
                    where plainto_tsquery('portuguese', ".$argumento_busca.") @@ cap.texto_srch  order by rank, titulo ";
                   

$lista = connAccess::fetchData($oConn,$sql);

//print_r( $lista );
?>

<h1>Busca</h1>
<?
if ( count($lista) <= 0 ){
?>

<div>Não foram encontrados itens para a busca</div>
<? } ?>
<ul>
    <? for ( $i = 0; $i < count($lista) ; $i++ ){ 
        
        $item = $lista[$i];
        
        
        $url = "index.php?id=".$item["id"]."&tipo=".$item["tipo"]."&mod=livro";
        
        ?>
    <li><a href="<?=$url?>"><?= $item["titulo"] ?></a></li>
    
    <? } ?>
    
</ul>
