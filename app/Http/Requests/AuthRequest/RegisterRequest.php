<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class RegisterRequest extends FormRequest
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
            'username' => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase(),
            ],
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'An email address is required',
            'email.email' => 'The email address must be valid',
            'password.required' => 'A password is required',
            'password.min' => 'The password must be at least 8 characters and mixed cases',
            // 'password.mixedCase' => 'The password must contain mixed cases'
        ];
    }
}
