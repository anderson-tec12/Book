<?php
require_once K_DIR . "library/kappa/kappa_rounds/avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_rounds/bd_avaliacao_kappa.php";
require_once K_DIR . "library/kappa/kappa_rounds/component_kappa_rounds_interno.php";
require_once K_DIR . "library/kappa/inc_avaliacao_kappa.php";

class KappaRounds implements IComponent {

    private $idRegistro;
    private $nomeTabela;
    private $nomeTabelaBanco;
    private $respostasOcultas = true;
    private $avaliacaoKappaAberto = true;
    private $bdAvaliacaoKappa;
    private $regras;
    private $idUsuarioLogado;
    private $nomeKappa;
    private $idUsuarioAvaliado;

    public function __construct($idRegistro, $nomeTabela, IRegraKappaRounds $regras, $respostasOcultas = true, $nomeKappa = '', $avaliacaoKappaAberto = true) {

        global $id_usuario_logado;

        $this->idRegistro = $idRegistro;
        $this->nomeTabela = $nomeTabela;
        $arrayNomes = explode(":", $nomeTabela);
        $this->nomeTabelaBanco = $arrayNomes[0];
        $this->respostasOcultas = $respostasOcultas;
        $this->bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
        $this->regras = $regras;
        $this->idUsuarioLogado = $id_usuario_logado;
        $this->nomeKappa = $nomeKappa;
        $this->avaliacaoKappaAberto = $avaliacaoKappaAberto;
    }

    public function printHTML() {

        $podeAvaliarRegistro = $this->regras->verificaUsuarioPodeAvaliarRegistro($this->idUsuarioLogado, $this->idRegistro, $this->nomeTabela);

        if (!empty($this->idRegistro) && (!empty($this->nomeTabela))) {

            $listaAvaliacaoKappa = $this->bdAvaliacaoKappa->buscaPorRegistro($this->idRegistro, $this->nomeTabela, AvaliacaoKappa::TIPO_AVALIACAO_BASE);
            $listaAvaliacoesFinais = $this->bdAvaliacaoKappa->buscaPorRegistro($this->idRegistro, $this->nomeTabela, AvaliacaoKappa::TIPO_AVALIACAO_FINAL);

            $registro = $this->bdAvaliacaoKappa->buscaRegistroAvaliado($this->idRegistro, $this->nomeTabelaBanco);

            $this->idUsuarioAvaliado = null;

            if (!empty($registro) && isset($registro['id_usuario'])) {
                $this->idUsuarioAvaliado = $registro['id_usuario'];
            }

            //if (count($listaAvaliacaoKappa) > 0) {
                #Imprime a opção para visualizar a opção "Resposta(s)"
                ?>
                <a class="bt_respostas" onclick="mostrar_respostas('<?= $this->nomeKappa ?>');">
                    <?= $this->bdAvaliacaoKappa->contaAvaliacoesPorRegistro($this->idRegistro, $this->nomeTabela) ?> Resposta(s) &#187;
                </a>
                <?
            //}

            //if (count($listaAvaliacoesFinais) > 0) {
                #Imprime a opção para visualizar a opção "Avaliação Final"
                ?>
                <a class="bt_respostas" onclick="mostrar_respostas_finais('<?= $this->nomeKappa ?>');">
                    <?= count($listaAvaliacoesFinais) ?> Decisão Final &#187;
                </a>
                <?
            //}

            if ($podeAvaliarRegistro && $this->avaliacaoKappaAberto) {

                #Imprime uma nova avaliação kappa
                ?>
                <div id="<?= $this->nomeKappa ?>" class="kappa_avaliar_1nivel">
                    <?
                    $novaAvaliacaoKappa = new NovaAvaliacaoKappa('', $this->idRegistro, $this->nomeTabela, $this->idUsuarioAvaliado, AvaliacaoKappa::TIPO_AVALIACAO_BASE, $this->nomeKappa);
                    $novaAvaliacaoKappa->printHTML();
                    ?>
                </div>

                <?
            }
            ?>
            <link href="<?= K_RAIZ ?>library/kappa/css/kappa_grid.css?t=5" rel="stylesheet" type="text/css">
            <?
            $this->imprimeListaKappaRounds($listaAvaliacaoKappa);
            $this->imprimeAvaliacoesFinais($listaAvaliacoesFinais);
            ?>
            <script src= "<?= K_RAIZ ?>library/kappa/kappa_rounds/js/kappa_rounds.js"></script>

            <script type="text/javascript">
                setRaizSistemaKappaRounds('<?= K_RAIZ ?>');
            </script>
            <?
        }
    }

    private function imprimeListaKappaRounds($listaAvaliacaoKappa) {

        if (count($listaAvaliacaoKappa) > 0) {
            ?>
            <div class = "comentario_grid kappa_pai" id = "div_grid_kappa_<?= $this->nomeKappa ?>" <?= $this->respostasOcultas ? "style='display: none'" : "style='display: block'" ?>>&#65279;&#65279;
                <?
                foreach ($listaAvaliacaoKappa as $avaliacaoKappa) {

                    if ($avaliacaoKappa->getIdUsuario() === $this->idUsuarioLogado || $this->verificaSeUsuarioLogadoEhAutorRegistroBase()) {
                        $this->respostasOcultas = false;
                    } else {
                        $this->respostasOcultas = true;
                    }

                    $autor = Usuario::getUser($avaliacaoKappa->getIdUsuario());

                    $imagemAutor = Usuario::mostraImagemUser($autor['imagem'], $autor['id']);

                    if (empty($imagemAutor) || substr($imagemAutor, -1) == "/") {
                        $imagemAutor = K_RAIZ_DOMINIO . "sistema/painel/images/box_img_user.jpg";
                    }
                    ?>

                    <div class="avaliar_primeiro_nivel">

                        <div class="left">
                            <div class="img_user_avaliar"><img src="<?= $imagemAutor ?>"></div>
                        </div>

                        <div class="right">
                            <div class="nome_avaliar"><?= $autor['nome_completo'] ?></div>

                            <div class="nota_avaliar">
                                <img class="pop_comentario_imagem" src="../painel/images/nota_kappa_<?= $avaliacaoKappa->getNota() ?>.png">
                            </div>

                            <div class="data_avaliar"><?= Util::PgToOut($avaliacaoKappa->getData(), true) ?><span style="margin-left: 10px;"><?= Util::HourToOut($avaliacaoKappa->getData()) ?></span></div>

                            <p><?= $avaliacaoKappa->getRessalva() ?></p>

                            <?
                            $usuarioPodeReplicar = $this->regras->verificaUsuarioPodeReplicarAvaliacao($this->idUsuarioLogado, $avaliacaoKappa->getId());

                            $this->imprimeMenuRespostas($avaliacaoKappa, $usuarioPodeReplicar);

                            $this->imprimeKappasInternos($avaliacaoKappa);

                            if ($usuarioPodeReplicar) {

                                $oUsuarioLogadoEhUsuarioAvaliado = $this->idUsuarioLogado == $avaliacaoKappa->getIdUsuarioAvaliado();
                                $oUsuarioLogadoEhAutorKappaRaiz = $this->idUsuarioLogado == $avaliacaoKappa->getIdUsuario();

                                if (($oUsuarioLogadoEhUsuarioAvaliado || $oUsuarioLogadoEhAutorKappaRaiz) && $this->avaliacaoKappaAberto) {
                                    #Apresenta o kappa já aberto
                                    ?>
                                    <div id="div_kappa_<?= $this->nomeKappa . "_" . $avaliacaoKappa->getId() ?>" class="kappa_avaliar_2nivel">
                                        <?
                                        $novaAvaliacaoKappa = new NovaAvaliacaoKappa($avaliacaoKappa->getId(), $this->idRegistro, $this->nomeTabela, $this->idUsuarioAvaliado, AvaliacaoKappa::TIPO_REPLICA, $this->nomeKappa . "_" . $avaliacaoKappa->getId());
                                        $novaAvaliacaoKappa->printHTML();
                                        ?>
                                    </div>
                                    <?
                                } else {
                                    ?>
                                    <div id="kappa_resposta_<?= $avaliacaoKappa->getId() ?>" class="kappa_avaliar_2nivel"></div>
                                    <?
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
            <?
        }
    }

    private function imprimeKappasInternos($avaliacaoKappa) {

        if (!empty($avaliacaoKappa)) {
            ?>
            <div class="comentario_grid grid_filho" id="div_grid_kappa_<?= $this->nomeKappa . "_" . $avaliacaoKappa->getId() ?>" <?= $this->respostasOcultas ? "style='display: none'" : "style='display: block'" ?>>&#65279;&#65279;
                <?
                $listaAvaliacoesFilhas = $this->bdAvaliacaoKappa->buscaPorIdKappaRaiz($avaliacaoKappa->getId());

                if (!empty($listaAvaliacoesFilhas)) {

                    foreach ($listaAvaliacoesFilhas as $avaliacaoKappaFilha) {

                        $ultimaAvaliacaoFeita = false;

                        if ($listaAvaliacoesFilhas[count($listaAvaliacoesFilhas) - 1] == $avaliacaoKappaFilha) {
                            $ultimaAvaliacaoFeita = true;
                        }

                        $kappaRoundsInternoComponent = new KappaRoundsInternoComponent($avaliacaoKappaFilha, $this->regras, $ultimaAvaliacaoFeita, 1, '', $this->nomeKappa . "_" . $avaliacaoKappa->getId());
                        $kappaRoundsInternoComponent->printHTML();
                    }
                }
                ?>
            </div>
            <?
        }
    }

    private function imprimeAvaliacoesFinais($listaAvaliacoesFinais) {
        if (count($listaAvaliacoesFinais) > 0) {
            ?>
            <div class = "comentario_grid kappa_pai" id = "div_respostas_finais_<?= $this->nomeKappa ?>" style="display: none">&#65279;&#65279;
                <div class="avaliar_primeiro_nivel">
                    <?
                    foreach ($listaAvaliacoesFinais as $avaliacaoKappa) {
                        ?>

                        <div class="comentario_grid grid_filho" >&#65279;&#65279;
                            <?
                            $kappaRoundsInternoComponent = new KappaRoundsInternoComponent($avaliacaoKappa, $this->regras, null, 1, '', $this->nomeKappa . "_" . $avaliacaoKappa->getId());
                            $kappaRoundsInternoComponent->printHTML();
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

    private function verificaSeUsuarioLogadoEhAutorRegistroBase() {

        if (!empty($this->idRegistro) && !empty($this->nomeTabela)) {

            $registro = $this->bdAvaliacaoKappa->buscaRegistroAvaliado($this->idRegistro, $this->nomeTabelaBanco);

            if (!empty($registro) && isset($registro['id_usuario'])) {
                if ($registro['id_usuario'] === $this->idUsuarioLogado) {
                    return true;
                }
            }
        }

        return false;
    }

    private function imprimeMenuRespostas($avaliacaoKappa, $podeResponder = false) {
        ?>   
        <div class="menu_avaliar_h3">
            <?
            if ($podeResponder) {
                ?>
                <a class="bt_avaliar_responder bt_avaliar_responder_2nivel"  onclick="avaliar_responder_click('<?= $avaliacaoKappa->getId() ?>', 'kappa_resposta_<?= $avaliacaoKappa->getId() ?>', '<?= AvaliacaoKappa::TIPO_REPLICA ?>', '<?= $this->nomeKappa . "_" . $avaliacaoKappa->getId() ?>',<?= $this->idRegistro ?>, '<?= $this->nomeTabela ?>',<?=!empty($this->idUsuarioAvaliado) ? $this->idUsuarioAvaliado : 1 ?>);">
                    Responder &#187;
                </a>
                <?
            }
            $usuarioPodeAdiantarAvaliacaoFinal = $this->regras->verificaUsuarioPodeAdiantarAvaliacaoFinal($this->idUsuarioLogado, $avaliacaoKappa->getId());
            #$usuarioPodeAdiantarAvaliacaoFinal = true;
            if ($usuarioPodeAdiantarAvaliacaoFinal) {
                ?>
                <a class="bt_avaliar_responder bt_avaliar_responder_2nivel" style="" onclick="avaliar_responder_click('<?= $avaliacaoKappa->getId() ?>', 'kappa_resposta_<?= $avaliacaoKappa->getId() ?>', '<?= AvaliacaoKappa::TIPO_AVALIACAO_FINAL ?>', '<?= $this->nomeKappa . "_" . $avaliacaoKappa->getId() ?>',<?= $this->idRegistro ?>, '<?= $this->nomeTabela ?>',<?= !empty($this->idUsuarioAvaliado) ? $this->idUsuarioAvaliado : 1 ?>);">
                    Fazer Avaliacao Final &#187;
                </a>
                <?
            }
            ?>
            <a class="bt_respostas" onclick="mostrar_respostas('<?= $this->nomeKappa . "_" . $avaliacaoKappa->getId() ?>');">
                <?= $this->bdAvaliacaoKappa->contaAvaliacoesPorKappaRaiz($avaliacaoKappa->getId()) ?> Resposta(s) &#187;
            </a>
            <? ?>
        </div>
        <?
        if ($usuarioPodeAdiantarAvaliacaoFinal && !$podeResponder) {
            ?>
            <div id="kappa_resposta_<?= $avaliacaoKappa->getId() ?>" class="kappa_avaliar_2nivel"></div>
            <?
        }
    }

}
