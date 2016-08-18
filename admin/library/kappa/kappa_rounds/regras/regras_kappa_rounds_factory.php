<?php

require_once (K_DIR . "library/kappa/kappa_rounds/regras/regras_kappa_rounds_rodadas.php");
require_once (K_DIR . "library/kappa/kappa_rounds/regras/regras_kappa_rounds_padrao.php");

class RegrasKappaRoundsFactory {

    const REGRA_KAPPA_ROUNDS_RODADAS_NEGOCIACAO = "regras_rodadas_negociacao";
    const REGRA_KAPPA_ROUNDS_PADRAO = "regras_padrao";

    static function getRegraKappaRounds($tipo, $conexao, $idTicket) {

        if (!empty($tipo) && !empty($conexao) && !empty($idTicket)) {

            switch ($tipo):
                case self::REGRA_KAPPA_ROUNDS_PADRAO:
                    return new RegrasKappaRoundsPadrao($conexao, $idTicket);
                case self::REGRA_KAPPA_ROUNDS_RODADAS_NEGOCIACAO:
                    return new RegrasKappaRoundsRodadas($conexao, $idTicket);
                default :
                    return null;
            endswitch;
        }

        return null;
    }

}
