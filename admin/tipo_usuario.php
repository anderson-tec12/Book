<?php

abstract class TipoUsuario {

    const Convidado = "convidado";
    const Protagonista = "protagonista";
    const Antagonista = "antagonista";
    const MembroComissao = "membro_comissao";
    const Mediador = "mediador";
    const Moderador = "moderador";

    static function getIndiceHierarquia($tipo = "") {
        if (!empty($tipo)):
            switch ($tipo) {
                case self::MembroComissao:
                    return 1;
                case self::Mediador:
                    return 2;
                case self::Moderador:
                    return 3;
                case self::Protagonista:
                    return 4;
                case self::Antagonista:
                    return 5;
                case self::Convidado:
                    return 6;
                default :
                    return 0;
            }
        endif;
    }

    static function getTiposPorHierarquia() {
        return array(
            self::MembroComissao,
            self::Mediador,
            self::Moderador,
            self::Protagonista,
            self::Antagonista,
            self::Convidado
        );
    }

}
