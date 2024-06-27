<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Mail\VerifyAccount;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function RegisterUser(RegisterRequest $request){


        $data = Validator::make($request->all(), $request->rules());

        // dd($data);

        if($data->fails()){
            return response()->json([
               $data->messages()
            ],400);
        }

        $data = $request->post();
        
        $createUser = $this->create($data);

        // $otp = $this->generateOTP($createUser);

        // Mail::to($data['email'])->send(new VerifyAccount($otp['token']));


        return response()->json([
            'data' => $createUser,
        ],200);

    }


    public function create(array $data)
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            // 'email_verified_at' => null,
        ]);
    }
}
