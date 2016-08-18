<?php
/**
 * Classe responsável por criar um painel de botões.
 *
 * @author Rodrigo Augusto Benedicto
 */
class CustomPanelButton implements IComponent
{
    var $_complemento = "";

    public function __construct()
    {
        
    }

    public function printHTML()
    {
        echo '<div id="customPanelButton">';
        echo'<a id="custom_painel_link" class="iframe_modal" href="pop_index.php?pag=falacias&amp;id_e=14">  Falacias  </a>';
        echo'<button type="button" onclick="bt2Clicked()" id="btTeste2">Teste 2</button>';
        echo'</div>';
    }
}
?>
