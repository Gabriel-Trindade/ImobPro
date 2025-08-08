<?php

namespace App\Helpers;

class CompanyHelper
{
    public static function isCnpj($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14) return false;

        if (preg_match('/(\d)\1{13}/', $cnpj)) return false;

        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$c] != $d) return false;
        }

        return true;
    }
}
