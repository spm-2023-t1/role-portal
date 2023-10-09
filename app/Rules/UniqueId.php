<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Job;

class UniqueId implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        return !Job::where('id', $value)->exists();
    }

    public function message()
    {
        return 'This ID already exists in the database.';
    }
}
