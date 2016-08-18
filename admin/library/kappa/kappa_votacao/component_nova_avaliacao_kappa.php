<?php
require_once (K_DIR . "library/kappa/kappa_votacao/bd_avaliacao_kappa.php");
require_once (K_DIR . "library/kappa/kappa_votacao/avaliacao_kappa.php");

class NovaAvaliacaoKappa implements IComponent {

    private $idAvaliacaoKappaPai;
    private $desabilitarNota1;
    private $desabilitarNota2;
    private $desabilitarNota3;
    private $desabilitarNota4;
    private $desabilitarNota5;
    private $tipoAvaliacao;

    public function __construct($idAvaliacaoKappaPai = null, $desabilitarNota1 = false, $desabilitarNota2 = false, $desabilitarNota3 = false, $desabilitarNota4 = false, $desabilitarNota5 = false, $tipoAvaliacao = '') {

        $this->idAvaliacaoKappaPai = $idAvaliacaoKappaPai;
        $this->desabilitarNota1 = $desabilitarNota1;
        $this->desabilitarNota2 = $desabilitarNota2;
        $this->desabilitarNota3 = $desabilitarNota3;
        $this->desabilitarNota4 = $desabilitarNota4;
        $this->desabilitarNota5 = $desabilitarNota5;
        $this->tipoAvaliacao = $tipoAvaliacao;
    }

    public function printHTML() {

        $oConn = FactoryConn::getConn(constant("K_CONN_TYPE"));

        global $id_usuario_logado;

        #Autor
        $autor = Usuario::getUser($id_usuario_logado);
        $imagemAutor = Usuario::mostraImagemUser($autor['imagem'], $autor['id']);
        if (empty($imagemAutor) || substr($imagemAutor, -1) == "/") {
            $imagemAutor = K_RAIZ_DOMINIO . "sistema/painel/images/box_img_user.jpg";
        }
        ?>

        &#65279;&#65279;

        <?
        if ($this->tipoAvaliacao === AvaliacaoKappa::TIPO_AVALIACAO_BASE) {
            ?>
            <div class="em_resposta_avaliar_kappa">
                <div class="em_resposta_avaliar"> <span><?= $autor['nome_completo'] ?></span> faça aqui sua avaliação</div>
            </div>
            <?
        } elseif ($this->tipoAvaliacao === AvaliacaoKappa::TIPO_AVALIACAO_FINAL) {
            ?>
            <div class="em_resposta_avaliar_kappa">
                <div class="em_resposta_avaliar"> <span><?= $autor['nome_completo'] ?></span>, após o debate e eventuais ajustes na proposta, agora você precisa decidir: aprova esta versão final?</div>
            </div>
            <?
        } elseif ($this->tipoAvaliacao === AvaliacaoKappa::TIPO_APELO) {
            ?>
            <div class="em_resposta_avaliar_kappa">
                <div class="em_resposta_avaliar"> <span><?= $autor['nome_completo'] ?></span>, faça aqui seu comentário final</div>
            </div>
            <?
        } elseif ($this->tipoAvaliacao === AvaliacaoKappa::TIPO_REPLICA || $this->tipoAvaliacao === AvaliacaoKappa::TIPO_TREPLICA) {

            $bdAvaliacaoKappa = BDAvaliacaoKappa::getInstance();

            $avaliacaoKappaPai = $bdAvaliacaoKappa->buscaPorId($this->idAvaliacaoKappaPai);

            $autorKappaPai = Usuario::getUser($avaliacaoKappaPai->getIdUsuario());
            ?>
            <div class="em_resposta_avaliar_kappa">
                <div class="em_resposta_avaliar">Faça a sua <?= $this->tipoAvaliacao ?> em resposta a <span><?= $autorKappaPai['nome'] ?></span></div>
            </div>
            <?
        }
        ?>

        <div class="box_avaliar_responder_kappa" id="box_avaliar_responder_kappa_<?= $this->idAvaliacaoKappaPai ?>">

            <div class="img_user_avaliar"><img src="<?= $imagemAutor ?>"></div>

            <textarea name="kappa_comentario_ressalva_<?= $this->idAvaliacaoKappaPai ?>" id="kappa_comentario_ressalva_<?= $this->idAvaliacaoKappaPai ?>" class="textarea_avaliar" placeholder="Digite aqui seu comentário, e clique ao lado para me dizer qual sua avaliação inicial."></textarea>

            <input type="hidden" name="kappa_comentario_nota_<?= $this->idAvaliacaoKappaPai ?>" id="kappa_comentario_nota_<?= $this->idAvaliacaoKappaPai ?>" value="">

            <div class="kappa_avaliar">
                <table>                            
                    <tbody>
                        <tr>
                            <td id="kappa_comentario_td_nota_1_<?= $this->idAvaliacaoKappaPai ?>" class="<?= $this->desabilitarNota1 ? "off" : "td_bt_nota" ?>"><a onclick="setNotaKappa('<?= $this->idAvaliacaoKappaPai ?>', 1);"><img id="kappa_comentario_img_Kappa_1_<?= $this->idAvaliacaoKappaPai ?>" class="kappa_medio_nota" src="<?= $this->desabilitarNota1 ? "../painel/images/botoes_kappa_1_alpha.png" : "../painel/images/botoes_kappa_1.png" ?>"></a></td>
                            <td id="kappa_comentario_td_nota_2_<?= $this->idAvaliacaoKappaPai ?>" class="<?= $this->desabilitarNota2 ? "off" : "td_bt_nota" ?>"><a onclick="setNotaKappa('<?= $this->idAvaliacaoKappaPai ?>', 2);"><img id="kappa_comentario_img_Kappa_2_<?= $this->idAvaliacaoKappaPai ?>" class="kappa_medio_nota" src="<?= $this->desabilitarNota2 ? "../painel/images/botoes_kappa_2_alpha.png" : "../painel/images/botoes_kappa_2.png" ?>"></a></td>
                            <td id="kappa_comentario_td_nota_3_<?= $this->idAvaliacaoKappaPai ?>" class="<?= $this->desabilitarNota3 ? "off" : "td_bt_nota" ?>"><a onclick="setNotaKappa('<?= $this->idAvaliacaoKappaPai ?>', 3);"><img id="kappa_comentario_img_Kappa_3_<?= $this->idAvaliacaoKappaPai ?>" class="kappa_medio_nota" src="<?= $this->desabilitarNota3 ? "../painel/images/botoes_kappa_3_alpha.png" : "../painel/images/botoes_kappa_3.png" ?>"></a></td>
                            <td id="kappa_comentario_td_nota_4_<?= $this->idAvaliacaoKappaPai ?>" class="<?= $this->desabilitarNota4 ? "off" : "td_bt_nota" ?>"><a onclick="setNotaKappa('<?= $this->idAvaliacaoKappaPai ?>', 4);"><img id="kappa_comentario_img_Kappa_4_<?= $this->idAvaliacaoKappaPai ?>" class="kappa_medio_nota" src="<?= $this->desabilitarNota4 ? "../painel/images/botoes_kappa_4_alpha.png" : "../painel/images/botoes_kappa_4.png" ?>"></a></td>
                            <td id="kappa_comentario_td_nota_5_<?= $this->idAvaliacaoKappaPai ?>" class="<?= $this->desabilitarNota5 ? "off" : "td_bt_nota" ?>"><a onclick="setNotaKappa('<?= $this->idAvaliacaoKappaPai ?>', 5);"><img id="kappa_comentario_img_Kappa_5_<?= $this->idAvaliacaoKappaPai ?>" class="kappa_medio_nota" src="<?= $this->desabilitarNota5 ? "../painel/images/botoes_kappa_5_alpha.png" : "../painel/images/botoes_kappa_5.png" ?>"></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <input class="bt_salvar button" onclick="salvar_avaliacao_kappa('<?= $this->idAvaliacaoKappaPai ?>', '<?= $this->tipoAvaliacao ?>')" type="button" value="Salvar">

        </div>
        <?
    }

}
