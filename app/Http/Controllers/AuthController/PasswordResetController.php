<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyResetPasswordOtp;
use App\Mail\PasswordResetLink;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends BaseController
{
    public function passwordReset(Request $request)
    {
        $email = $request->only('email');
        $user  = User::where('email', $email)->first();
        if (!$user) {
            return response([
                'status'  => 'error',
                'message' => 'Email does not exist',
            ]);
        }

        $token = random_int(100000, 999999);


        PasswordReset::create([
            'email' => $user->email,
            'token' => $token,
        ]);

        Mail::to($request->email)->send(new PasswordResetLink($token));
        return $this->success($user);
    }

        public function verifyPassWordOtp(VerifyResetPasswordOtp $request)
        {
            $data = $request->validated();

            if ($verify = PasswordReset::where(['email' => $data['email'], 'token' => $data['token']])->first()) {

                return response([
                    'user'      => $verify->email,
                ]);

            }
            
            return response ([
                'status' => 'Error',
                'message' => 'Invalid Token',
            ]);
        }

}
