<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidWithRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $values = explode(',', $value);
        foreach ($values as $singleValue) {
            $trimmedValue = trim($singleValue);
            if (!in_array($trimmedValue, ['tags', 'ingredients', 'category'])) {
                $fail('The :attribute contains invalid values.');
            }
        }
    }
}
