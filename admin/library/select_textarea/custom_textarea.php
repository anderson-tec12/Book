<?php

/**
 * Classe responsável criação do textarea customizado que apresentará opções ao selecionar texto.
 *
 * @author Rodrigo Augusto Benedicto
 */

class CustomTextArea implements IComponent {

    private $id = "";
    private $value = "";
    private $class = "";
    var $_link = "";
    public $readOnly = false;

    public function __construct($id = "", $value = "", $class = "") {
        $this->id = $id;
        $this->value = $value;
        $this->class = $class;
    }

    public function printHTML() {
        $complemento = "style='display:none'"; 
        if (! $this->readOnly){            
        echo '<textarea name="', $this->id, '" id="', $this->id, '" class="', $this->class, '" onselect="setSelectText(\'', $this->id, '\')">', $this->value, '</textarea>';
       
        }else{
           echo '<div class="'.$this->class.' custom_textarea_readonly">'.  $this->value .'</div>';  
        }
        
        if ( Util::request("debug") == "1")
                   $complemento = "";
        echo "<div id='".$this->id."_link' ".$complemento." >". $this->_link . "</div>"; //armazena a URL do popup de falácia..
    }

    public function getId() {
        return $this->id;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

}
?>
