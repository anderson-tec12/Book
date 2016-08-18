<?php

class Kappa implements IComponent {

    private $idKappa = "";

    public function __construct($idKappa) {
        $this->idKappa = $idKappa;
    }

    public function printHTML() {
        ?>
        <table border="0" cellspacing="0" cellpadding="0">

            <thead>
                <tr><td colspan="6"><img src="<?= K_RAIZ ?>painel/images/botoes_kappa_concordo.png"/></td></tr>
            </thead>

            <tfoot>
                <tr><td colspan="6"><img src="<?= K_RAIZ ?>painel/images/botoes_kappa_discordo.png"/></td></tr>
            </tfoot>

            <tbody>
                <tr>
                    <td rowspan="1"><img src="<?= K_RAIZ ?>painel/images/botoes_kappa_k.png"/><a name="acapa"></a></td>
                    <td rowspan="2" id="<?= $this->idKappa ?>_nota1" class="td_bt_nota"><a class="hint--bottom" data-hint="Concordo Plenamente" onclick="setNota(1, '<?= $this->idKappa ?>');"><img id="imgNota1_kappa<?= $this->idKappa ?>" src="<?= K_RAIZ ?>painel/images/botoes_kappa_1.png"/></a></td>
                    <td rowspan="3" id="<?= $this->idKappa ?>_nota2" class="td_bt_nota"><a class="hint--bottom" data-hint="Concordo com Ressalvas" onclick="setNota(2, '<?= $this->idKappa ?>');"><img  id="imgNota2_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_2.png"/></a></td>
                    <td rowspan="4" id="<?= $this->idKappa ?>_nota3" class="td_bt_nota"><a class="hint--bottom" data-hint="Não sei" onclick="setNota(3, '<?= $this->idKappa ?>');"><img  id="imgNota3_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_3.png"/></a></td>
                    <td rowspan="5" id="<?= $this->idKappa ?>_nota4" class="td_bt_nota"><a class="hint--bottom" data-hint="Discordo com Ressalvas" onclick="setNota(4, '<?= $this->idKappa ?>');"><img  id="imgNota4_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_4.png"/></a></td>
                    <td rowspan="6" id="<?= $this->idKappa ?>_nota5" class="td_bt_nota"><a class="hint--bottom" data-hint="Discordo Totalmente" onclick="setNota(5, '<?= $this->idKappa ?>');"><img id="imgNota5_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_5.png"/></a></td>
                </tr>
            </tbody>
        </table>

        <!-- Ressalvas -->

        <div class="botoes_kappa_link" id="div_ressalva_<?= $this->idKappa ?>" style="display:none">
            <label>Escreva suas Ressalvas abaixo</label><br/>
            <input type="hidden" id="<?= $this->idKappa ?>_registro" name="<?= $this->idKappa ?>_registro" value="" >
            <input type="hidden" id="<?= $this->idKappa ?>_tabela" name="<?= $this->idKappa ?>_tabela" value="" >
            <input type="hidden" id="<?= $this->idKappa ?>_componente_template" name="<?= $this->idKappa ?>_componente_template" value="" >
            <input type="hidden" id="<?= $this->idKappa ?>_usuario" name="<?= $this->idKappa ?>_usuario" value="" >
            <textarea class="kappa_ressalva" id="<?= $this->idKappa ?>_ressalva" name="<?= $this->idKappa ?>_ressalva"></textarea>
            <input type="hidden" id="<?= $this->idKappa ?>_nota" name="<?= $this->idKappa ?>_nota" value="" >
            <input type="hidden" id="<?= $this->idKappa ?>_data" name="<?= $this->idKappa ?>_data" value="" >
        </div>
        <?
    }

}
