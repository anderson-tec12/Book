<?php
require_once K_DIR . "library/kappa/kappa_votacao/component_nova_avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_votacao/avaliacao_kappa.php";

class AvaliacaoKappaComponent implements IComponent {

    private $avaliacaoKappa;
    private $ultimaAvaliacaoFeita;
    private $contadorTipoAvaliacao;
    private $avaliacaoKappaVotacaoRegras;

    public function __construct(AvaliacaoKappa $avaliacaoKappa, $avaliacaoKappaVotacaoRegras, $ultimaAvaliacaoFeita = false, $contadorTipoAvaliacao = null) {
        $this->avaliacaoKappa = $avaliacaoKappa;
        $this->ultimaAvaliacaoFeita = $ultimaAvaliacaoFeita;
        $this->avaliacaoKappaVotacaoRegras = $avaliacaoKappaVotacaoRegras;
        $this->contadorTipoAvaliacao = $contadorTipoAvaliacao;
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
                $podeTreplicar = $this->avaliacaoKappaVotacaoRegras->verificaUsuarioPodeTreplicarAvaliacao($id_usuario_logado, $this->avaliacaoKappa->getId());

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
                        <div id="kappa_resposta_<?= $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel">
                            <?
                            $novaAvaliacaoKappa = new NovaAvaliacaoKappa($this->avaliacaoKappa->getId(), false, false, false, false, false, AvaliacaoKappa::TIPO_TREPLICA);
                            $novaAvaliacaoKappa->printHTML();
                            ?>
                        </div>
                        <?
                    } else {
                        ?>
                        <a class="bt_avaliar_responder bt_avaliar_responder_2nivel" style="" onclick="avaliar_responder_click('<?= $this->avaliacaoKappa->getId() ?>', 'kappa_resposta_<?= $this->avaliacaoKappa->getId() ?>', '<?= AvaliacaoKappa::TIPO_TREPLICA ?>');">
                            Responder &#187;
                        </a>
                        <div id="kappa_resposta_<?= $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel"></div>
                        <?
                    }
                }

                $ehHoraDaAvaliacaoFinal = $this->avaliacaoKappaVotacaoRegras->ehHoraDaAvaliacaoFinal($id_usuario_logado, $this->avaliacaoKappa->getId());

                if ($ehHoraDaAvaliacaoFinal && $this->ultimaAvaliacaoFeita) {
                    ?>
                    <div id="kappa_resposta_<?= $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel">
                        <?
                        $novaAvaliacaoKappa = new NovaAvaliacaoKappa($this->avaliacaoKappa->getId(), false, true, true, true, false, AvaliacaoKappa::TIPO_AVALIACAO_FINAL);
                        $novaAvaliacaoKappa->printHTML();
                        ?>
                    </div>
                    <?
                }

                $ehHoraDoApelo = $this->avaliacaoKappaVotacaoRegras->ehHoraDoApeloFinal($id_usuario_logado, $this->avaliacaoKappa->getId());

                if ($ehHoraDoApelo && $this->ultimaAvaliacaoFeita) {
                    ?>
                    <div id="kappa_resposta_<?= $this->avaliacaoKappa->getId() ?>" class="kappa_avaliar_3nivel">
                        <?
                        $novaAvaliacaoKappa = new NovaAvaliacaoKappa($this->avaliacaoKappa->getId(), false, false, false, false, false, AvaliacaoKappa::TIPO_APELO);
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
