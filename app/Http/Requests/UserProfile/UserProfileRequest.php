<?php

namespace App\Http\Requests\UserProfile;

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
}