<div class="menu-atlas">
  <ul class="menu">
    <li><a class="menu-item-link" data-href="Inicio" href="/atlas/livro/">Inicio</a></li>
    <li><a class="menu-item-link" data-href="Sobre o Atlas da Cuesta" href="inc_sobre-o-atlas.php">Sobre o Atlas da Cuesta</a></li>
    <li><a class="menu-item-link" data-href="Glossário" href="inc_glossario.php">Glossário</a></li>
    <li><a class="menu-item-link" data-href="Referências Bibliográficas" href="inc_referencias-bibliograficas.php">Referências Bibliográficas</a></li>
  </ul>
  <div class="search-box">
    <form class="search-form" action="">
      <label class="label-hidden" for="search">Search</label>
      <input type="text" name="search" class="search" placeholder="Pesquisar">
    </form>
  </div>
</div>
<script>
  function fn_pesquisa(obj,event){
    var f = document.frm_busca;
    if ( f.search.value != ""){
      if ( enter(obj, event ) ){
        f.action = "index.php";
        f.method="post";
        f.submit();
      }
   }
   return true;
 }
 /*So aceita numeros*/
 function enter(obj, event,code) {
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
