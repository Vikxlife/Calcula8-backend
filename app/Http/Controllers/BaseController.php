<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function generateOTP(User $user): array
    {
        $token = random_int(100000, 999999);

        UserVerify::where(['user_id' => $user->id])->delete();

        $verify = UserVerify::create([
            'user_id'    => $user->id,
            'user_email' => $user->email,
            'expiresAt'  => now()->addMinutes(5),
            'token'      => $token,
        ]);
        
        return [
            'token'  => $token,
            'verify' => $verify,
        ];
    }


    protected function success($data)
    {
        return response(
            [
                'data'   => $data,
                'status' => 'Successful',
            ]);
    }


    public function generateUserOtp(Request $request)
    {

        $user_id = $request->only('user_id');

        $token = random_int(100000, 999999);

        $user = User::where('user_id', $user_id)->first();

        if(!$user){
            return response()->json([
                'error' => 'Does not exist'
            ]);
        }

        UserVerify::where('user_id', $user_id)->delete();

        $verify = UserVerify::create([
            'user_id'    => $user->id,
            'user_email' => $user->email,
            'expiresAt'  => now()->addMinutes(5),
            'token'      => $token,
        ]);
        
        return [
            'token'  => $token,
            'verify' => $verify,
        ];
    }
}
