<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCategoryRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value !== 'NULL' && $value !== '!NULL' && (!is_numeric($value) || $value <= 1)) {
            $fail('The :attribute must be NULL, !NULL, or a number greater than 1.');
        }
    }
}
