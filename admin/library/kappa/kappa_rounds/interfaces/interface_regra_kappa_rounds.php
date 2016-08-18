<?php

/**
 * @author Rodrigo Augusto Benedicto
 * 
 * Interface que define as funções que uma classe de regras para o kappa de rounds deve implementar
 * 
 */
interface IRegraKappaRounds {

    public function verificaUsuarioPodeAvaliarRegistro($idUsuario, $idRegistro, $nomeTabela);

    public function verificaUsuarioPodeReplicarAvaliacao($idUsuario, $idAvaliacaoKappa);

    public function verificaUsuarioPodeTreplicarAvaliacao($idUsuario, $idAvaliacaoKappa);

    public function verificaUsuarioPodeAdiantarAvaliacaoFinal($idUsuario, $idAvaliacaoKappa);

    public function ehHoraDaAvaliacaoFinal($idUsuario, $idAvaliacaoKappaPai);

    public function ehHoraDoApeloFinal($idUsuario, $idAvaliacaoKappaPai);
    
    public function setNumeroCiclosKappa($numeroCiclos);

}
