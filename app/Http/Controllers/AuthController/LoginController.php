<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthRequest\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Sanctum\PersonalAccessToken;

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

        // if (!$user->is_verified == 1) {
            // $otp = $this->generateOTP($user);
        //     Mail::to($request->email)->send(new VerifyAccount($otp['token']));

        //     return response([
        //         'user' => $user,
        //     ]);
        // }
        
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


    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'No token provided'], 401);
        }

        $tokenId = explode('|', $token, 2)[0];

        $accessToken = PersonalAccessToken::find($tokenId);

        if ($accessToken) {
            $accessToken->delete();
            return response()->json([
                'message' => 'Logged out successfully'
            ]);

        } else {
            return response()->json([
                'message' => 'User not found'], 
                404);
        }
    }
}
