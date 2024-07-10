<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $data = Validator::make($request->all(), [
            "email"  => "string",
            "id"    => "string",
        ]);

        if($data->fails()){
            return response()->json([
                "message"=> $data->errors(),
            ], 400);   
        }

        $validatedData = $data->validated();

        $user = User::where(['email' => $validatedData['email'], '_id' => $validatedData['id']])->first();

        if(!$user){
            return response()->json([
                'error' => 'Does not exist'
            ]);
        }

        $token = random_int(100000, 999999);

        UserVerify::where(['user_id' => $data['id']])->delete();

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
