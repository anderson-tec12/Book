<?php
/**
 * Classe responsável por montar o menu circular
 *
 * @author Rodrigo Augusto Benedicto - 27/11/2014
 */
require_once 'pre_analise_item_menu_circular.php';
//require_once ($_SERVER["DOCUMENT_ROOT"].'/sistema/custom/inc_componente_template_item.php');

$path_to_custom = K_RAIZ."custom";

if (file_exists($path_to_custom.DIRECTORY_SEPARATOR.
        "inc_componente_template_item.php")) {

    require_once ( $path_to_custom.DIRECTORY_SEPARATOR.
        "inc_componente_template_item.php" );
}

class PreAnaliseMenuCircular implements IComponent
{

    public function __construct()
    {

    }

    public function printHTML()
    {
        ?>
        <!-- Modal que abrirá por trás do menu para que seja possivel fecha-lo ao clicar fora dele-->
        <div id="modal_menu_circular"></div>
        <!--Menu Circular-->
        <div id ="menu_circular" name ="menu_circular">
            <!--<div class="menu_relato_circular" name ="menu_relato_circular">-->
            <div id="rotatescroll">

                <div class="inf"></div>
                <div class="viewport">
                    <ul class="overview">
                        <?
                        $templates = componente_template_item::getListaComponenteTemplate();

                        foreach ($templates as $template) {
                            $item = new ItemMenuCircular($template['id'], $template['nome'], "../../files/icons/".$template['imagem01'], $template['cor'], $template['descricao']);
                            $item->printHTML();
                        }
                        ?>
                    </ul>
                </div>
                <div class="dot"></div>
                <div class="overlay"></div>
                <div class="thumb"></div>

            </div><!-- #rotatescroll -->
            <!--</div> /menu_relato_circular -->
        </div><!-- /menu_circular -->
        <?
    }
}
?>
