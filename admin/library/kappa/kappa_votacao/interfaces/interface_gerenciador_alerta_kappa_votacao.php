<?php

/**
 * @author Rodrigo Augusto Benedicto
 * 
 * Interface que define as funções que uma classe de disparador de alertas para o kappa de votação deve implementar
 * 
 */
interface IGerenciadorAlertaKappaVotacao {

    public function enviarAlertaAoSalvarKappaVotacao(AvaliacaoKappa $avaliacaoKappa);
    
}
