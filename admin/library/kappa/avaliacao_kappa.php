<?php

class AvaliacaoKappa implements IComponent {

    private $idKappa = "";
    private $id_registro = "";
    private $tabela = "";
    private $componente_template = "";
    private $classe = "";

    public function __construct($idKappa = "", $id_registro = "", $tabela = "", $componente_template = "", $classe = "kappa_normal") {
        $this->idKappa = $idKappa;
        $this->id_registro = $id_registro;
        $this->tabela = $tabela;
        $this->componente_template = $componente_template;
        $this->classe = $classe;
    }

    public function printHTML() {
        ?>
        <div class="container container-twelve">
            <div class="twelve columns">

                <table border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td rowspan="1"><img class="<?= $this->classe ?>_titulo" src="<?= K_RAIZ ?>painel/images/botoes_kappa_k.png"/><a name="acapa"></a></td>
                            <td rowspan="2" id="<?= $this->idKappa ?>_nota1"><a onclick="setNota(1, '<?= $this->idKappa ?>');"><img class="<?= $this->classe ?>_nota" id="imgNota1_kappa<?= $this->idKappa ?>" src="<?= K_RAIZ ?>painel/images/botoes_kappa_1.png"/></a></td>
                            <td rowspan="3" id="<?= $this->idKappa ?>_nota2"><a onclick="setNota(2, '<?= $this->idKappa ?>');"><img class="<?= $this->classe ?>_nota" id="imgNota2_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_2.png"/></a></td>
                            <td rowspan="4" id="<?= $this->idKappa ?>_nota3"><a onclick="setNota(3, '<?= $this->idKappa ?>');"><img class="<?= $this->classe ?>_nota" id="imgNota3_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_3.png"/></a></td>
                            <td rowspan="5" id="<?= $this->idKappa ?>_nota4"><a onclick="setNota(4, '<?= $this->idKappa ?>');"><img class="<?= $this->classe ?>_nota" id="imgNota4_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_4.png"/></a></td>
                            <td rowspan="6" id="<?= $this->idKappa ?>_nota5"><a onclick="setNota(5, '<?= $this->idKappa ?>');"><img class="<?= $this->classe ?>_nota" id="imgNota5_kappa<?= $this->idKappa ?>"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_5.png"/></a></td>
                        </tr>
                    </tbody>
                </table>

                <div class="<?= $this->classe ?>_ressalva" id="div_ressalva_<?= $this->idKappa ?>" style="display:none">
                    <label>Escreva suas Ressalvas abaixo</label>
                    <textarea id="<?= $this->idKappa ?>_ressalva" name="<?= $this->idKappa ?>_ressalva"></textarea>
                    <input type="hidden" id="<?= $this->idKappa ?>_nota" name="<?= $this->idKappa ?>_nota" value="" >
                    <input type="hidden" id="<?= $this->idKappa ?>_registro" name="<?= $this->idKappa ?>_registro" value="<?= $this->id_registro ?>" >
                    <input type="hidden" id="<?= $this->idKappa ?>_tabela" name="<?= $this->idKappa ?>_tabela" value="<?= $this->tabela ?>" >
                    <input type="hidden" id="<?= $this->idKappa ?>_componente_template" name="<?= $this->idKappa ?>_componente_template" value="<?= $this->componente_template ?>" >
                </div>
            </div>
        </div>
        <?
    }

}
