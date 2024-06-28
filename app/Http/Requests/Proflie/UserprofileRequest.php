<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;


class UserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [ 
            'user_id'        => 'string',
            'firstname'      => 'string',
            'lastname'       => 'string',
            'school'         => 'string',
            'gender'         => 'string',
            'age'            => 'string',
            'state'          => 'string',
            'lga'            => 'string',
            'user_image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        
        ];
    }


    // public function messages()
    // {
    //     return [
    //         'email.required' => 'An email address is required',
    //         'email.email' => 'The email address must be valid',
    //         'password.required' => 'A password is required',
    //         'password.min' => 'The password must be at least 6 characters',
    //         'password.mixedCase' => 'The password must contain mixed cases'
    //     ];
    // }
}
