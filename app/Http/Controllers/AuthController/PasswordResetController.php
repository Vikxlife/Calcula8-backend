<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyResetPasswordOtp;
use App\Mail\PasswordResetLink;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends BaseController
{
    public function passwordReset(Request $request)
    {
        $email = $request->only(['email']);

        $user  = User::where('email', $email['email'])->first();


        if (!$user) {
            return response([
                'status'  => 'error',
                'message' => 'Email does not exist',
            ]);
        }

        $token = random_int(100000000000, 999999999900);


        PasswordReset::create([
            'email' => $user->email,
            'token' => $token,
        ]);

        Mail::to($request->email)->send(new PasswordResetLink($token));
        return $this->success($user);
    }



    public function showResetForm($token)
    {
        $verify = PasswordReset::where('token', (int)$token)->first();

        if (!$verify) {
            return redirect()->route('error.page')->with('message', 'Invalid or expired token.');
        }

        // if (Carbon::parse($verify->expiresAt)->isPast()) {
        //     return redirect()->route('error.page')->with('message', 'Token has expired.');
        // }

        return view('auth.passwords.reset', ['token' => $token, 'email' => $verify->user_email]);
    }



    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $verify = PasswordReset::where('token', (int)$request->token)->first();

        if (!$verify) {
            return redirect()->route('error.page')->with('message', 'Invalid or expired token.');
        }

        // if (Carbon::parse($verify->expiresAt)->isPast()) {
        //     return redirect()->route('error.page')->with('message', 'Token has expired.');
        // }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->route('error.page')->with('message', 'User not found.');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        PasswordReset::where('user_id', $user->id)->delete();

        return redirect()->route('password.reset.success');
        
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
