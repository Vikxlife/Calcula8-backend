<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function LoginUser(LoginRequest $request){

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response([
                'error' => 'Invalid credentials',
            ], 422);
        }

        $user = Auth::user();
        
        if (!$user) {
            return response(['error' => 'Auth::user() returned null'], 500);
        }

        /** @var \App\Models\User $user **/
        $token = $user->createToken('main')->plainTextToken;

    
        return response([
            'user'  => $user,
            'token' => $token,
        ]);








        // if (!Auth::attempt($credentials, $request->get('remember'))) {
        //     return response([
        //         'error' => 'Invalid credentials',
        //     ], 422);

        // }

        // $user = Auth::user();

        // if (!$user->is_verified == 1) {
        //     $otp = $this->generateOTP($user);
        //     Mail::to($request->email)->send(new VerifyAccount($otp['token']));

        //     return response([
        //         'user' => $user,
        //     ]);
        // }

        // /** @var \App\Models\User $user * */
        // $token = $user->createToken('main')->plainTextToken;

        // return response([
        //     'user'  => $user,
        //     'token' => $token,
        // ]);

    }
}
