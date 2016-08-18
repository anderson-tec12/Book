<?php

/**
 * Classe responsável por apresentar o grafico para o kappa
 *
 * @author Rodrigo Augusto
 */
class GraficoBarrasKappa implements IComponent {

    private $qtdeTotalAvaliacaoKappa = 0;
    private $qtdeAvaliacaoKappa1 = 0;
    private $qtdeAvaliacaoKappa2 = 0;
    private $qtdeAvaliacaoKappa3 = 0;
    private $qtdeAvaliacaoKappa4 = 0;
    private $qtdeAvaliacaoKappa5 = 0;
    private $desativarNota1 = false;
    private $desativarNota2 = false;
    private $desativarNota3 = false;
    private $desativarNota4 = false;
    private $desativarNota5 = false;
    private $apresentarEmPorcentagem = true;

    public function __construct($desativarNota1 = false, $desativarNota2 = false, $desativarNota3 = false, $desativarNota4 = false, $desativarNota5 = false) {
        $this->desativarNota1 = $desativarNota1;
        $this->desativarNota2 = $desativarNota2;
        $this->desativarNota3 = $desativarNota3;
        $this->desativarNota4 = $desativarNota4;
        $this->desativarNota5 = $desativarNota5;
    }

    function setValores($qtdeTotalAvaliacaoKappa, $qtdeAvaliacaoKappa1, $qtdeAvaliacaoKappa2, $qtdeAvaliacaoKappa3, $qtdeAvaliacaoKappa4, $qtdeAvaliacaoKappa5) {
        $this->qtdeTotalAvaliacaoKappa = $qtdeTotalAvaliacaoKappa;
        $this->qtdeAvaliacaoKappa1 = $qtdeAvaliacaoKappa1;
        $this->qtdeAvaliacaoKappa2 = $qtdeAvaliacaoKappa2;
        $this->qtdeAvaliacaoKappa3 = $qtdeAvaliacaoKappa3;
        $this->qtdeAvaliacaoKappa4 = $qtdeAvaliacaoKappa4;
        $this->qtdeAvaliacaoKappa5 = $qtdeAvaliacaoKappa5;
    }

    function setApresentarEmPorcentagem($apresentarEmPorcentagem) {
        $this->apresentarEmPorcentagem = $apresentarEmPorcentagem;
    }

    public function printHTML() {
        ?>
        <section class="chartVertical">
            <div class="charts-container">
                <div class="bar-chart-vertical">

                    <?
                    # A imagem do topo, que representa cada kappa, está em uma imagem só, portanto, foi necessário realizar esse tipo de implementação
                    if ($this->desativarNota2 && $this->desativarNota3 && $this->desativarNota4) {
                        ?>
                        <div class="top_grafico_kappa_alpha"></div>
                        <?
                    } else {
                        ?>
                        <div class="top_grafico_kappa"></div>
                        <?
                    }
                    ?>

                    <div class="bar-chart--track">
                        <span class="bar-chart--progress kappa_1" style="height: <?= $this->qtdeTotalAvaliacaoKappa > 0 ? ($this->qtdeAvaliacaoKappa1 * 100) / $this->qtdeTotalAvaliacaoKappa : 0 ?>%;"></span>
                    </div>
                    <div class="bar-chart--track">
                        <span class="bar-chart--progress kappa_2" style="height: <?= $this->qtdeTotalAvaliacaoKappa > 0 ? ($this->qtdeAvaliacaoKappa2 * 100) / $this->qtdeTotalAvaliacaoKappa : 0 ?>%;"></span>
                    </div>
                    <div class="bar-chart--track">
                        <span class="bar-chart--progress kappa_3" style="height: <?= $this->qtdeTotalAvaliacaoKappa > 0 ? ($this->qtdeAvaliacaoKappa3 * 100) / $this->qtdeTotalAvaliacaoKappa : 0 ?>%;"></span>
                    </div>
                    <div class="bar-chart--track">
                        <span class="bar-chart--progress kappa_4" style="height: <?= $this->qtdeTotalAvaliacaoKappa > 0 ? ($this->qtdeAvaliacaoKappa4 * 100) / $this->qtdeTotalAvaliacaoKappa : 0 ?>%;"></span>
                    </div>
                    <div class="bar-chart--track">
                        <span class="bar-chart--progress kappa_5" style="height: <?= $this->qtdeTotalAvaliacaoKappa > 0 ? ($this->qtdeAvaliacaoKappa5 * 100) / $this->qtdeTotalAvaliacaoKappa : 0 ?>%;"></span>
                    </div>


                    <div class="valor_grafico_kappa">
                        <ul>
                            <?
                            if ($this->apresentarEmPorcentagem) {
                                ?>
                                <li class="valor_kappa_1 <?= $this->desativarNota1 ? "alpha" : "" ?>"><?= $this->qtdeTotalAvaliacaoKappa > 0 ? number_format(($this->qtdeAvaliacaoKappa1 * 100) / $this->qtdeTotalAvaliacaoKappa, 1) : 0 ?>%</li>
                                <li class="valor_kappa_2 <?= $this->desativarNota2 ? "alpha" : "" ?>"><?= $this->qtdeTotalAvaliacaoKappa > 0 ? number_format(($this->qtdeAvaliacaoKappa2 * 100) / $this->qtdeTotalAvaliacaoKappa, 1) : 0 ?>%</li>
                                <li class="valor_kappa_3 <?= $this->desativarNota3 ? "alpha" : "" ?>"><?= $this->qtdeTotalAvaliacaoKappa > 0 ? number_format(($this->qtdeAvaliacaoKappa3 * 100) / $this->qtdeTotalAvaliacaoKappa, 1) : 0 ?>%</li>
                                <li class="valor_kappa_4 <?= $this->desativarNota4 ? "alpha" : "" ?>"><?= $this->qtdeTotalAvaliacaoKappa > 0 ? number_format(($this->qtdeAvaliacaoKappa4 * 100) / $this->qtdeTotalAvaliacaoKappa, 1) : 0 ?>%</li>
                                <li class="valor_kappa_5 <?= $this->desativarNota5 ? "alpha" : "" ?>"><?= $this->qtdeTotalAvaliacaoKappa > 0 ? number_format(($this->qtdeAvaliacaoKappa5 * 100) / $this->qtdeTotalAvaliacaoKappa, 1) : 0 ?>%</li>
                                <?
                            } else {
                                ?>
                                <li class="valor_kappa_1 <?= $this->desativarNota1 ? "alpha" : "" ?>"><?= $this->qtdeAvaliacaoKappa1 ?></li>
                                <li class="valor_kappa_2 <?= $this->desativarNota2 ? "alpha" : "" ?>"><?= $this->qtdeAvaliacaoKappa2 ?></li>
                                <li class="valor_kappa_3 <?= $this->desativarNota3 ? "alpha" : "" ?>"><?= $this->qtdeAvaliacaoKappa3 ?></li>
                                <li class="valor_kappa_4 <?= $this->desativarNota4 ? "alpha" : "" ?>"><?= $this->qtdeAvaliacaoKappa4 ?></li>
                                <li class="valor_kappa_5 <?= $this->desativarNota5 ? "alpha" : "" ?>"><?= $this->qtdeAvaliacaoKappa5 ?></li>
                                    <?
                                }
                                ?>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <script type="text/javascript">
            $(document).ready(function () {
                parent.$.fn.colorbox.resize({
                    innerWidth: 960,
                    innerHeight: $(document).height()
                });
            });

            $(function () {
                $('a[href*=#]:not([href=#])').click(function () {
                    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        if (target.length) {
                            $('html,body').animate({scrollTop: target.offset().top - 20}, 1000);
                            return false;
                        }
                    }
                });
            });
        </script>
        <?
    }

}
