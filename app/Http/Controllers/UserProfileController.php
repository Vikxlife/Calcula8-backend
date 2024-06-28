<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\UserProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends BaseController
{
    public function CreateUserProfile(UserProfileRequest $request){
        $data = Validator::make($request->all(), $request->rules());
        $user = Auth::user();
    }
}
