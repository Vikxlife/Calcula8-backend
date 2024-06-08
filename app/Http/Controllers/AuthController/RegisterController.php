<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function RegisterUser(RegisterRequest $request){

        $data = Validator::make($request->all(), $request->rules());

        if($data->fails()){
            return response()->json([
               $data->messages()
            ],400);
        }

        $data = $request->post();
        $createData = $this->create($data);

        return response()->json([
            'data' => $createData,
        ],200);

    }


    public function create(array $data)
    {
        return User::create([
            'firstname'      => $data['firstname'],
            'lastname'      => $data['lastname'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            'email_verified_at' => null,
        ]);
    }
}
