<?php

class ResultadoKappa implements IComponent {

    private $avaliacaoKappa = null;
    private $nota = "";
    private $ressalva = "";
    private $classe = "kappa_normal";

    public function __construct($avaliacaoKappa, $classe = "") {
        $this->avaliacaoKappa = $avaliacaoKappa;
        if (!empty($classe)) {
            $this->classe = $classe;
        }
    }

    public function printHTML() {


        if ($this->avaliacaoKappa != null) {

            $this->nota = $this->avaliacaoKappa['nota'];
            $this->ressalva = $this->avaliacaoKappa['ressalva'];

            $classeKappa = "class = " . $this->classe . "_titulo";
            $classeNota = "class = " . $this->classe . "_nota";
            $classeRessalva = "class = " . $this->classe . "_ressalva";
            
            ?>
            <div class="container container-twelve">
                <div class="twelve columns comp_kappa">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td rowspan="1"><img <?= $classeKappa ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_k.png"/><a name="acapa"></td>

                                <? if ($this->nota == 1) { ?>
                                    <td rowspan="2" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_1_ativo.png"/></td>
                                <? } else { ?>
                                    <td rowspan="2" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_1.png"/></td>
                                <? } ?>

                                <? if ($this->nota == 2) { ?>
                                    <td rowspan="3" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_2_ativo.png"/></td>
                                <? } else { ?>
                                    <td rowspan="3" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_2.png"/></td>
                                <? } ?>

                                <? if ($this->nota == 3) { ?>
                                    <td rowspan="4" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_3_ativo.png"/></td>
                                <? } else { ?>
                                    <td rowspan="4" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_3.png"/></td>
                                <? } ?>

                                <? if ($this->nota == 4) { ?>
                                    <td rowspan="5" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_4_ativo.png"/></td>
                                <? } else { ?>
                                    <td rowspan="5" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_4.png"/></td>
                                <? } ?>

                                <? if ($this->nota == 5) { ?>
                                    <td rowspan="6" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_5_ativo.png"/></td>
                                <? } else { ?>
                                    <td rowspan="6" class="td_bt_nota"><img <?= $classeNota ?> src="<?= K_RAIZ ?>painel/images/botoes_kappa_5.png"/></td>
                                <? } ?>

                            </tr>
                        </tbody>
                    </table>

                    <!-- Ressalvas -->
                    <? if ($this->nota == 2 || $this->nota == 4) { ?>
                        <div class="<?= $this->classe ?>_ressalva">
                            <label>Ressalva</label>
                            <textarea disabled="true"><?= $this->ressalva ?></textarea>
                        </div>
                        <?
                    }
                    ?>
                </div>
            </div>
            <?
        }
    }

}
