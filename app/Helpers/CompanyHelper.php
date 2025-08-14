<?php

namespace App\Helpers;

class CompanyHelper
{
    public static function isCnpj(string $cnpj): bool
    {
        if (strlen($cnpj) !== 14) return false;
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) return false;

        $nums = array_map('intval', str_split($cnpj));

        $calc = function (array $slice, array $weights): int {
            $sum = 0;
            foreach ($slice as $i => $n) {
                $sum += $n * $weights[$i];
            }
            $rest = $sum % 11;
            return $rest < 2 ? 0 : 11 - $rest;
        };

        $d1 = $calc(array_slice($nums, 0, 12), [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $d2 = $calc(array_merge(array_slice($nums, 0, 12), [$d1]), [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);

        return $nums[12] === $d1 && $nums[13] === $d2;
    }
}
