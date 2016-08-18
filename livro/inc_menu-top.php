<div class="menu-atlas">
  <ul class="menu">
    <li><a class="menu-item-link" data-href="Inicio" href="inc_atlas-da-cuesta.php">Inicio</a></li>
    <li><a class="menu-item-link" data-href="Sobre o Atlas da Cuesta" href="inc_sobre-o-atlas.php">Sobre o Atlas da Cuesta</a></li>
    <li><a class="menu-item-link" data-href="Glossário" href="inc_glossario.php">Glossário</a></li>
    <li><a class="menu-item-link" data-href="Referências Bibliográficas" href="inc_referencias-bibliograficas.php">Referências Bibliográficas</a></li>
  </ul>
  <div class="search-box">
      <form class="search-form" action="" method="post" name="frm_busca" id="frm_busca">
        <input type="hidden" name="mod" value="busca">
      <label class="label-hidden" for="search" >Search</label>
      <input type="text" name="search" class="search" onkeypress="return fn_pesquisa(this, event)" value="<?= Util::request("search") ?>" placeholder="Pesquisar">
    </form>
  </div>
</div>
<script>
function fn_pesquisa(obj, event ){
 
   var fr = document.frm_busca;
   
   if ( fr.search.value != ""){
       
      if ( enter(obj, event ) ){
                   fr.action = "index.php";
                   fr.method="post";
                   fr.submit();
      } 
   }
   
   return false;
 
}


 function enter(obj, event,code) /*So aceita numeros*/{
        Tecla = event.which;
          if(Tecla == null)
            Tecla = event.keyCode;
    
          if ( Tecla == 13 && code == null)
            Login();
            return true;
    
          if ( obj.name == "login")
            return SoNumero(event);
          else
            return true;
      }
</script>

