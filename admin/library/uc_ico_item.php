<?php

 echo Util::mostraImagem("arrow_refresh.png","atualizar_lista()",
"Atualizar lista de itens cadastrados","link_refresh"); 
echo "&nbsp;";
echo Util::mostraImagem("add2.png","adicionar_item()","Cadastrar item"); 

?>
<script>
function atualizar_lista(){

   var f = document.forms[0];
   f.acao2.value = "";
   f.submit();
}
function adicionar_item(){
     openPop("<?=  $this->url ( array ('module'=>'app','controller'=>'cadbasico','action' =>'listar' ), null, true ) ?>/popup/1/tipo/14","visitem",700,500);

}
</script>