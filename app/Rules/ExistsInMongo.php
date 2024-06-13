<?php

namespace App\Rules;

use App\Models\UserVerify;
use Illuminate\Contracts\Validation\Rule;

class ExistsInMongo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return UserVerify::where($this->field, $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}

// class ExistsInMongo implements Rule
// {
//     private $field;

//     public function __construct($field)
//     {
//         $this->field = $field;
//     }

//     public function passes($attribute, $value)
//     {
//         return UserVerify::where($this->field, $value)->exists();
//     }

//     public function message()
//     {
//         return 'The selected :attribute is invalid.';
//     }
// }

