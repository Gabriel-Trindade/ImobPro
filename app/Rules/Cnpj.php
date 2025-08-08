<?php

namespace App\Rules;

use Closure;
use App\Helpers\CompanyHelper;
use Illuminate\Contracts\Validation\ValidationRule;


class Cnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!CompanyHelper::isCnpj($value)) {
            $fail('O :attribute informado não é válido.');
        }
    }
}
