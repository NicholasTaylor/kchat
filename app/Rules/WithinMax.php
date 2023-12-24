<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithinMax implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $characterCount = count(Character::where('user_id', $value)->get());
        $characterMax = env('CHARACTER_MAX') && is_numeric(env('CHARACTER_MAX')) ? env('CHARACTER_MAX') : 4;
        if ($characterCount + 1 > $characterMax){
            $fail('User is at max characters. Please delete a character to create a new one.');
        }
    }
}
