<?php

class DateHelper {
    /*
     * Função responsavel por pegar e retornar a hora de um Timestamp
     * exemplo utilizacao: DateHelper::getHora(strtotime(2015-08-20-10:15:00));
     * retorna 10:15:00
     */

    public static function getHora($timestamp) {
        if (is_numeric($timestamp)) {
            return date('H:i:s', $timestamp);
        }
        return null;
    }

    /*
     * Função responsavel por pegar e retornar a data de um Timestamp
     * exemplo utilizacao: DateHelper::getHora(strtotime(2015-08-20-10:15:00));
     * retorna 20/08/2015
     */

    public static function getData($timestamp, $paraUsuario = true) {
        if (is_numeric($timestamp)) {
            if ($paraUsuario) {
                return date('d/m/Y', $timestamp);
            } else {
                return date('Y-m-d', $timestamp);
            }
        }
        return null;
    }

    public static function somaDiasNaData($qtdeDias, $data = "", $hora = "") {

        if (empty($qtdeDias)) {
            $qtdeDias = 0;
        }
        if (empty($data)) {
            $data = date("Y-m-d");
        }
        if (empty($hora)) {
            $hora = date("H:i:s");
        }

        $data = explode("-", $data);
        $hora = explode(":", $hora);

        $datetime = new DateTime();
        $datetime->setDate($data[0], $data[1], $data[2]);
        $datetime->setTime($hora[0], $hora[1], $hora[2]);

        $datetime->modify("+" . $qtdeDias . " days");

        return $datetime->format("Y-m-d H:i:s");
    }

    public static function somaHorasNaData($qtdeHoras, $data = "", $hora = "") {

        if (empty($qtdeHoras)) {
            $qtdeHoras = 0;
        }
        if (empty($data)) {
            $data = date("Y-m-d");
        }
        if (empty($hora)) {
            $hora = date("H:i:s");
        }

        $data = explode("-", $data);
        $hora = explode(":", $hora);

        $datetime = new DateTime();
        $datetime->setDate($data[0], $data[1], $data[2]);
        $datetime->setTime($hora[0], $hora[1], $hora[2]);

        $datetime->modify("+" . $qtdeHoras . " hours");

        return $datetime->format("Y-m-d H:i:s");
    }

    public static function setPrimeiraHoraDia($data = "", $hora = "") {
        if (empty($data)) {
            $data = date("Y-m-d");
        }

        $data = explode("-", $data);

        $datetime = new DateTime();
        $datetime->setDate($data[0], $data[1], $data[2]);
        $datetime->setTime(00, 00, 00);

        return $datetime->format("Y-m-d H:i:s");
    }

    public static function setUltimaHoraDia($data = "") {

        if (empty($data)) {
            $data = date("Y-m-d");
        }

        $data = explode("-", $data);

        $datetime = new DateTime();
        $datetime->setDate($data[0], $data[1], $data[2]);
        $datetime->setTime(23, 59, 59);

        return $datetime->format("Y-m-d H:i:s");
    }

}
