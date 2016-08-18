<?php

/**
 * @author Rodrigo Augusto Benedicto
 * 
 * Interface que define as funções que uma classe de disparador de alertas para o kappa de rounds deve implementar
 * 
 */
interface IGerenciadorAlertaKappaRounds {

    public function enviarAlertaAoSalvarKappaRounds(AvaliacaoKappa $avaliacaoKappa);
    
}
