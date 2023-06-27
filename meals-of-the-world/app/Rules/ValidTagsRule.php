<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTagsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tags = explode(',', $value);
        foreach ($tags as $tag) {
            if (!is_numeric($tag)) {
                $fail('The :attribute must be a comma-separated list of numeric values.');
            }
        }
    }
}
