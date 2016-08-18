<?php

class KappaVotacao implements IComponent {

    private $idRegistro;
    private $nomeTabela;
    private $respostasOcultas = true;
    private $bdAvaliacaoKappa;
    private $regras;
    private $idUsuarioLogado;
    
    public $desabilitarNota1 = false ;
    public $desabilitarNota2 = false ;
    public $desabilitarNota3= false ; 
    public $desabilitarNota4 = false ;
    public $desabilitarNota5= false ;

    public function __construct($idRegistro, $nomeTabela, IRegraKappaVotacao $regras, $respostasOcultas = true) {
        global $id_usuario_logado;
        $this->idRegistro = $idRegistro;
        $this->nomeTabela = $nomeTabela;
        $this->respostasOcultas = $respostasOcultas;
        $this->bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();
        $this->regras = $regras;
        $this->idUsuarioLogado = $id_usuario_logado;
        
        if (gettype( $regras) == "AvaliacaoRegrasLiberado" ){

                $this->desabilitarNota2 = true ;
                 $this->desabilitarNota3= true ; 
                 $this->desabilitarNota4 = true ;
        }
        
    }

    public function printHTML() {

        $podeAvaliarRegistro = $this->regras->verificaUsuarioPodeAvaliarRegistro($this->idUsuarioLogado, $this->idRegistro, $this->nomeTabela);

        if (!empty($this->idRegistro) && (!empty($this->nomeTabela))) {

            $listaAvaliacaoKappa = $this->bdAvaliacaoKappa->buscaPorRegistro($this->idRegistro, $this->nomeTabela, AvaliacaoKappa::TIPO_AVALIACAO_BASE);
            $listaAvaliacoesFinais = $this->bdAvaliacaoKappa->buscaPorRegistro($this->idRegistro, $this->nomeTabela, AvaliacaoKappa::TIPO_AVALIACAO_FINAL);
            $registro = $this->bdAvaliacaoKappa->buscaRegistroAvaliado($this->idRegistro, $this->nomeTabela);
            $idUsuarioAvaliado = null;
            if (!empty($registro) && isset($registro['id_usuario'])) {
                $idUsuarioAvaliado = $registro['id_usuario'];
            }
            ?>
            <input type="hidden" id="id_registro_base_kappa" value="<?= $this->idRegistro ?>"/>
            <input type="hidden" id="nome_tabela_base_kappa" value="<?= $this->nomeTabela ?>"/>
            <input type="hidden" id="id_usuario_avaliado" value="<?= $idUsuarioAvaliado ?>"/>
            <?
            if (count($listaAvaliacaoKappa) > 0) {
                #Imprime a opção para visualizar a opção "Resposta(s)"
                ?>
                <a class="bt_respostas" onclick="mostrar_respostas('div_kappa_principal');">
                    <?= $this->bdAvaliacaoKappa->contaAvaliacoesPorRegistro($this->idRegistro, $this->nomeTabela) ?> Resposta(s) &#187;
                </a>
                <?
            }

            if (count($listaAvaliacoesFinais) > 0) {
                #Imprime a opção para visualizar a opção "Avaliação Final"
                ?>
                <a class="bt_respostas" onclick="mostrar_respostas_finais();">
                    <?= count($listaAvaliacoesFinais) ?> Decisão Final &#187;
                </a>
                <?
            }

            if ($podeAvaliarRegistro) {

                #Imprime uma nova avaliação kappa
                ?>
                <div id="div_resposta_kappa_principal" class="kappa_avaliar_1nivel">
                    <?
                    $novaAvaliacaoKappa = new NovaAvaliacaoKappa('', $this->desabilitarNota1, $this->desabilitarNota2,
                            $this->desabilitarNota3, $this->desabilitarNota4, 
                            $this->desabilitarNota5, AvaliacaoKappa::TIPO_AVALIACAO_BASE);
                    $novaAvaliacaoKappa->printHTML();
                    ?>
                </div>

                <?
            }
            ?>
            <link href="<?= K_RAIZ ?>library/kappa/css/kappa_grid.css?t=5" rel="stylesheet" type="text/css">
            <?
            $this->imprimeListaKappaVotacao($listaAvaliacaoKappa);
            $this->imprimeAvaliacoesFinais($listaAvaliacoesFinais);
            ?>
            <script src= "<?= K_RAIZ ?>library/kappa/kappa_votacao/js/kappa_votacao.js"></script>

            <script type="text/javascript">
                setRaizSistemaKappaVotacao('<?= K_RAIZ ?>');
            </script>
            <?
        }
    }

    private function imprimeListaKappaVotacao($listaAvaliacaoKappa) {

        if (count($listaAvaliacaoKappa) > 0) {
            ?>
            <div class = "comentario_grid kappa_pai" id = "div_kappa_principal" <?= $this->respostasOcultas ? "style='display: none'" : "style='display: block'" ?>>&#65279;&#65279;
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

                            $this->imprimeKappasInterno($avaliacaoKappa);

                            if ($usuarioPodeReplicar) {

                                $oUsuarioLogadoEhUsuarioAvaliado = $this->idUsuarioLogado == $avaliacaoKappa->getIdUsuarioAvaliado();
                                $oUsuarioLogadoEhAutorKappaRaiz = $this->idUsuarioLogado == $avaliacaoKappa->getIdUsuario();

                                if ($oUsuarioLogadoEhUsuarioAvaliado || $oUsuarioLogadoEhAutorKappaRaiz) {
                                    #Apresenta o kappa já aberto
                                    ?>
                                    <div id="kappa_resposta_<?= $avaliacaoKappa->getId() ?>" class="kappa_avaliar_2nivel">
                                        <?
                                        $novaAvaliacaoKappa = new NovaAvaliacaoKappa($avaliacaoKappa->getId(), false, false, false, false, false, AvaliacaoKappa::TIPO_REPLICA);
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

    private function imprimeKappasInterno($avaliacaoKappa) {

        if (!empty($avaliacaoKappa)) {
            ?>
            <div class="comentario_grid grid_filho" id="div_kappa_<?= $avaliacaoKappa->getId() ?>" <?= $this->respostasOcultas ? "style='display: none'" : "style='display: block'" ?>>&#65279;&#65279;
                <?
                $listaAvaliacoesFilhas = $this->bdAvaliacaoKappa->buscaPorIdKappaRaiz($avaliacaoKappa->getId());

                if (!empty($listaAvaliacoesFilhas)) {

                    foreach ($listaAvaliacoesFilhas as $avaliacaoKappaFilha) {

                        $ultimaAvaliacaoFeita = false;

                        if ($listaAvaliacoesFilhas[count($listaAvaliacoesFilhas) - 1] == $avaliacaoKappaFilha) {
                            $ultimaAvaliacaoFeita = true;
                        }

                        $avaliacaoKappaComponente = new AvaliacaoKappaComponent($avaliacaoKappaFilha, $this->regras, $ultimaAvaliacaoFeita, 1);
                        $avaliacaoKappaComponente->printHTML();
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
            <div class = "comentario_grid kappa_pai" id = "div_kappa_principal_respostas_finais" style="display: none">&#65279;&#65279;
                <div class="avaliar_primeiro_nivel">
                    <?
                    foreach ($listaAvaliacoesFinais as $avaliacaoKappa) {
                        ?>

                        <div class="comentario_grid grid_filho" >&#65279;&#65279;
                            <?
                            $avaliacaoKappaComponente = new AvaliacaoKappaComponent($avaliacaoKappa, $this->regras);
                            $avaliacaoKappaComponente->printHTML();
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

            $registro = $this->bdAvaliacaoKappa->buscaRegistroAvaliado($this->idRegistro, $this->nomeTabela);

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
                <a class="bt_avaliar_responder bt_avaliar_responder_2nivel" style="" onclick="avaliar_responder_click('<?= $avaliacaoKappa->getId() ?>', 'kappa_resposta_<?= $avaliacaoKappa->getId() ?>', '<?= AvaliacaoKappa::TIPO_REPLICA ?>');">
                    Responder &#187;
                </a>
                <?
            }
            $usuarioPodeAdiantarAvaliacaoFinal = $this->regras->verificaUsuarioPodeAdiantarAvaliacaoFinal($this->idUsuarioLogado, $avaliacaoKappa->getId());
            #$usuarioPodeAdiantarAvaliacaoFinal = true;
            if ($usuarioPodeAdiantarAvaliacaoFinal) {
                ?>
                <a class="bt_avaliar_responder bt_avaliar_responder_2nivel" style="" onclick="avaliar_responder_click('<?= $avaliacaoKappa->getId() ?>', 'kappa_resposta_<?= $avaliacaoKappa->getId() ?>', '<?= AvaliacaoKappa::TIPO_AVALIACAO_FINAL ?>');">
                    Fazer Avaliacao Final &#187;
                </a>
                <?
            }
            ?>
            <a class="bt_respostas" onclick="mostrar_respostas('div_kappa_<?= $avaliacaoKappa->getId() ?>');">
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
