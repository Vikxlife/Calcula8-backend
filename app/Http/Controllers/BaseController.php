<?php

namespace App\Http\Controllers;

use App\Mail\VerifyAccount;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            "user_id"    => "string",
        ]);

        if($data->fails()){
            return response()->json([
                "message"=> $data->errors(),
            ], 400);   
        }

        $validatedData = $data->validated();

        $user = User::where(['email' => $validatedData['email'], '_id' => $validatedData['user_id']])->first();


        if(!$user){
            return response()->json([
                'error' => 'Does not exist'
            ]);
        }

        $token = random_int(100000, 999999);

        UserVerify::where(['user_id' => $validatedData['user_id']])->delete();

        $verify = UserVerify::create([
            'user_id'    => $user->id,
            'user_email' => $user->email,
            'expiresAt'  => now()->addMinutes(5),
            'token'      => $token,
        ]);

        Mail::to($validatedData['email'])->send(new VerifyAccount($token));

        
        return [
            'token'  => $token,
            'verify' => $verify,
        ];
    }
}
