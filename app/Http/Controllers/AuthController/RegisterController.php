<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function RegisterUser(RegisterRequest $request){

    $data = Validator::make($request->all(), $request->rules());

    }
}
