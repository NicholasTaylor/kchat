<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class Creator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $creatorUserId = Character::where('id', $value)->get()->firstOrFail()->user_id;
        $userId = Auth::user()->id;
        if($creatorUserId !== $userId){
            $fail('User not authorized to edit this character.');
        }
    }
}
