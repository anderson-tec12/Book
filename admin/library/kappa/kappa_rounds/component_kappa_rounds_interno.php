<?php
require_once K_DIR . "library/kappa/kappa_rounds/component_nova_avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_rounds/avaliacao_kappa.php";

class KappaRoundsInternoComponent implements IComponent {

    private $avaliacaoKappa;
    private $ultimaAvaliacaoFeita;
    private $contadorTipoAvaliacao;
    private $avaliacaoKappaRoundsRegras;
    private $nomeKappa;

    public function __construct(AvaliacaoKappa $avaliacaoKappa, $avaliacaoKappaRoundsRegras, $ultimaAvaliacaoFeita = false, $contadorTipoAvaliacao = null, $nomeKappa) {
        $this->avaliacaoKappa = $avaliacaoKappa;
        $this->ultimaAvaliacaoFeita = $ultimaAvaliacaoFeita;
        $this->avaliacaoKappaRoundsRegras = $avaliacaoKappaRoundsRegras;
        $this->contadorTipoAvaliacao = $contadorTipoAvaliacao;
        $this->nomeKappa = $nomeKappa;
    }

    public function printHTML() {

        global $id_usuario_logado;

        $autor = Usuario::getUser($this->avaliacaoKappa->getIdUsuario());

        $imagemAutor = Usuario::mostraImagemUser($autor['imagem'], $autor['id']);

        if (empty($imagemAutor) || substr($imagemAutor, -1) == "/") {
            $imagemAutor = K_RAIZ_DOMINIO . "sistema/painel/images/box_img_user.jpg";
        }

        $usuarioKappaPai = Usuario::getUser($this->avaliacaoKappa->getIdAvaliacaoKappaPaiUsuario());
        ?>
        <link href="<?= K_RAIZ ?>library/kappa/css/kappa_grid.css?t=5" rel="stylesheet" type="text/css">

        <div class="avaliar_segundo_nivel">

            <div class="left">
                <div class="img_user_avaliar"><img src="<?= $imagemAutor ?>"></div>
            </div>

            <div class="right">
                <div class="nome_avaliar"><?= $autor['nome_completo'] ?></div>
                <div class="nota_avaliar">
                    <img class="pop_comentario_imagem" src="../painel/images/nota_kappa_<?= $this->avaliacaoKappa->getNota() ?>.png">
                </div>

                <?                
                if ($this->avaliacaoKappa->getTipoAvaliacao() == AvaliacaoKappa::TIPO_AVALIACAO_FINAL) {
                    ?>
                    <div class="em_resposta_avaliar"><span><?= AvaliacaoKappa::TIPO_AVALIACAO_FINAL ?></span></div>
                    <?
                } elseif ($this->avaliacaoKappa->getTipoAvaliacao() == AvaliacaoKappa::TIPO_APELO) {
                    ?>
                    <div class="em_resposta_avaliar"><span><?= AvaliacaoKappa::TIPO_APELO ?></span></div>
                    <?
                } else {
                    ?>
                    <div class="em_resposta_avaliar"><?= $this->avaliacaoKappa->getContador() . "ª " ?><?= $this->avaliacaoKappa->getTipoAvaliacao() ?> em resposta a <span><?= $usuarioKappaPai['nome'] ?></span></div>
                    <?
                }
                ?>

                <div class="data_avaliar"><?= Util::PgToOut($this->avaliacaoKappa->getData(), true) ?><span style="margin-left: 10px;"><?= Util::HourToOut($this->avaliacaoKappa->getData()) ?></span></div>
                <p><?= $this->avaliacaoKappa->getRessalva() ?></p>

                <?
            #echo '<pre>';
            #print_r($this->avaliacaoKappa);
            #echo '</pre>';
            
            
                $podeTreplicar = $this->avaliacaoKappaRoundsRegras->verificaUsuarioPodeTreplicarAvaliacao($id_usuario_logado, $this->avaliacaoKappa->getId());
                
                if ($podeTreplicar) {
                    
                    $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
                    $avaliacaoKappaRaiz = $bdAvaliacaoKappa->buscaPorId($this->avaliacaoKappa->getIdKappaRaiz());

                    $mostraAvaliacaoKappaAberta = false;

                    $oUsuarioDoKappaPaiEhOUsuarioAvaliado = $this->avaliacaoKappa->getIdUsuario() == $this->avaliacaoKappa->getIdUsuarioAvaliado();
                    $oUsuarioDoKappaPaiEhOUsuarioDoKappaRaiz = $this->avaliacaoKappa->getIdUsuario() == $avaliacaoKappaRaiz->getIdUsuario();
                    $oUsuarioLogadoEhOUsuarioDoKappaRaiz = $id_usuario_logado == $avaliacaoKappaRaiz->getIdUsuario();
                    $oUsuarioLogadoEhOUsuarioAvaliado = $id_usuario_logado == $this->avaliacaoKappa->getIdUsuarioAvaliado();

                    if (($oUsuarioDoKappaPaiEhOUsuarioAvaliado || $oUsuarioDoKappaPaiEhOUsuarioDoKappaRaiz) && ($oUsuarioLogadoEhOUsuarioDoKappaRaiz || $oUsuarioLogadoEhOUsuarioAvaliado)) {
                        ?>
                        <div id="div_kappa_<?= $this->nomeKappa . "_" . $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel">
                            <?
                            $novaAvaliacaoKappa = new NovaAvaliacaoKappa($this->avaliacaoKappa->getId(), $this->avaliacaoKappa->getIdRegistro(), $this->avaliacaoKappa->getNomeTabela(), $this->avaliacaoKappa->getIdUsuarioAvaliado(), AvaliacaoKappa::TIPO_TREPLICA, $this->nomeKappa . "_" . $this->avaliacaoKappa->getId());
                            $novaAvaliacaoKappa->printHTML();
                            ?>
                        </div>
                        <?
                    } else {
                        ?>
                        <a class="bt_avaliar_responder bt_avaliar_responder_2nivel" style="" onclick="avaliar_responder_click('<?= $this->avaliacaoKappa->getId() ?>', 'div_kappa_<?= $this->nomeKappa . "_" . $this->avaliacaoKappa->getId() ?>', '<?= AvaliacaoKappa::TIPO_TREPLICA ?>', '<?= $this->nomeKappa . "_" . $this->avaliacaoKappa->getId() ?>', '<?= $this->avaliacaoKappa->getIdRegistro() ?>', '<?= $this->avaliacaoKappa->getNomeTabela() ?>', '<?= $this->avaliacaoKappa->getIdUsuarioAvaliado() ?>');">
                            Responder &#187;
                        </a>
                        <div id="div_kappa_<?= $this->nomeKappa . "_" . $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel"></div>
                        <?
                    }
                }
                
                $ehHoraDaAvaliacaoFinal = $this->avaliacaoKappaRoundsRegras->ehHoraDaAvaliacaoFinal($id_usuario_logado, $this->avaliacaoKappa->getId());
                
                if ($ehHoraDaAvaliacaoFinal && $this->ultimaAvaliacaoFeita) {
                    ?>
                    <div id="div_grid_kappa_<?= $this->nomeKappa . "_" . $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel">
                        <?
                        $novaAvaliacaoKappa = new NovaAvaliacaoKappa($this->avaliacaoKappa->getId(), $this->avaliacaoKappa->getIdRegistro(), $this->avaliacaoKappa->getNomeTabela(), $this->avaliacaoKappa->getIdUsuarioAvaliado(), AvaliacaoKappa::TIPO_AVALIACAO_FINAL, $this->nomeKappa . "_" . $this->avaliacaoKappa->getId());
                        $novaAvaliacaoKappa->desabilitarNotas(array(2, 3, 4));
                        $novaAvaliacaoKappa->printHTML();
                        ?>
                    </div>
                    <?
                }

                $ehHoraDoApelo = $this->avaliacaoKappaRoundsRegras->ehHoraDoApeloFinal($id_usuario_logado, $this->avaliacaoKappa->getId());

                if ($ehHoraDoApelo && $this->ultimaAvaliacaoFeita) {
                    ?>
                    <div id="div_grid_kappa_<?= $this->nomeKappa . "_" . $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel">
                        <?
                        $novaAvaliacaoKappa = new NovaAvaliacaoKappa($this->avaliacaoKappa->getId(), $this->avaliacaoKappa->getIdRegistro(), $this->avaliacaoKappa->getNomeTabela(), $this->avaliacaoKappa->getIdUsuarioAvaliado(), AvaliacaoKappa::TIPO_APELO, $this->nomeKappa . "_" . $this->avaliacaoKappa->getId());
                        $novaAvaliacaoKappa->printHTML();
                        ?>
                    </div>
                    <?
                }
                ?>

            </div>
        </div>

        <?
    }

}
