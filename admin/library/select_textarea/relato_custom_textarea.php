<?php
/**
 * Classe responsável criação do textarea customizado que apresentará opções ao selecionar texto.
 *
 * @author Rodrigo Augusto Benedicto
 */

class RelatoCustomTextArea implements IComponent
{
    private $id    = "";
    private $value = "";
    private $class = "";

    public function __construct($id = "", $value = "", $class = "")
    {
        $this->id = $id;
        $this->value = $value;
        $this->class = $class;
    }

    public function printHTML()
    {
        echo '<textarea name="', $this->id, '" id="', $this->id, '" class="', $this->class, '" onselect="setSelectText(\'', $this->id, '\')" onkeyup="pressTextArea(event)" onclick="clickTextArea()" >', $this->value, '</textarea>';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
?>
