<?php

class IncluirKappa implements IComponent {

    public function __construct() {
        
    }

    public function printHTML() {
        ?>

        <div class="kappa">

            <div class="botoes_kappa">

                <table border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                    <a name="acapa"></a>
                    <td rowspan="1" ><img class="kappa_medio_k" src="<?= K_RAIZ ?>painel/images/botoes_kappa_k.png"/></td>
                    <td rowspan="2"><img class="kappa_medio_nota" id="imgKappa1" src="<?= K_RAIZ ?>painel/images/botoes_kappa_1.png"/></td>
                    <td rowspan="3"><img class="kappa_medio_nota" id="imgKappa2"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_2.png"/></td>
                    <td rowspan="4"><img class="kappa_medio_nota" id="imgKappa3"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_3.png"/></td>
                    <td rowspan="5"><img class="kappa_medio_nota" id="imgKappa4"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_4.png"/></td>
                    <td rowspan="6"><img class="kappa_medio_nota" id="imgKappa5"  src="<?= K_RAIZ ?>painel/images/botoes_kappa_5.png"/></td>
                    </tr>
                    </tbody>
                </table>

            </div>

            <a id="btAdicionarKappa" class="link" onclick="incluirKappa()">Clique aqui para inserir o Botão Kappa</a>

        </div><!-- /kappa -->

        <?
    }

}
