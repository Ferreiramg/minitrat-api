<?php

namespace App\Helpers;

use DateTime;
use Throwable;

class Helper
{

    /**
     * Converte uma string em um decimal valido
     * @param string $str Numero Ex: 3,50 -- 3.500,89
     * @return float numero
     */
    public static function toDecimal(?string $str): float
    {
        if (is_null($str))
            return 0;
        if (strstr($str, ',')) {
            $str = str_replace('.', '', $str); // replace dots (thousand seps) with blancs
            $str = str_replace(',', '.', $str); // replace ',' with '.'
        }

        if (preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
            return floatval($match[0]);
        } else {
            return floatval($str); // take some last chances with floatval
        }
    }
    
    /**
     * Converte uma string em uma data valida
     * @param string $str data Ex: 2020-01-01
     * @return datetime data
     */
    public static function ParaDate(?string $str)
    {
        if (is_null($str))
            return null;

        return date('Y-m-d', strtotime($str));
    }

    /**
     * Converte uma string em uma data hora valida
     * @param string $str data Ex: 2020-01-01 12:00:000
     * @return datetime data
     */
    public static function ParaDateTime(?string $str)
    {
        if (is_null($str))
            return null;

        return date('Y-m-d H:i:s', strtotime($str));
    }

    /**
     * Converte uma string em uma data hora valida
     * @param string $str data Ex: 2020-01-01 12:00:000
     * @return datetime data Brasil
     */
    public static function ParaDateTimeBr(?string $str)
    {
        if (is_null($str))
            return null;

        return date('d/m/Y H:i', strtotime($str));
    }

    /**
     * Converte uma string em uma data hora valida
     * @param string $str data Ex: 2020-01-01 12:00:000
     * @return date data Brasil
     */
    public static function ParaDateBr(?string $str)
    {
        if (is_null($str))
            return null;

        return date('d/m/Y', strtotime($str));
    }

    /**
     * Em caso de divisã por zero retorna zero
     * @param float dividendo
     *
     * @return float divisor
     */
    public static function divisaoValida($x, $y)
    {
        try {
            return $x / $y;
        } catch (Throwable $e) {
            return 0;
        }
    }

}
