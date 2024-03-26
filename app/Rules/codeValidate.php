<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Cache;

class codeValidate implements ValidationRule
{

    public $user;

    public function __construct($user)
    {
        $this->user = $user;  
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $resetCode = Cache::get($this->user->email); 

        if(! $resetCode || $resetCode != $value){
            $fail('The code you entered is invalid.');
            return;
        }

    }
}
