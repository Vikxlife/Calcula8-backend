<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\VerifyOtpRequest;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyEmailController extends BaseController
{
    public function verifyAccount(VerifyOtpRequest $request)
    {
        $data = Validator::make($request->all(), $request->rules());
    
        $validatedData = $data->validated();
    
        $verify = UserVerify::where([
            'user_email' => $validatedData['email'],
            'token' => (int) $validatedData['token'] 
        ])->first();
            
        if ($verify) {
            if (strtotime($verify->expiresAt) <= strtotime(now())) {
                return response([
                    'status'  => 'Error',
                    'message' => 'Token Expired!',
                ]);
            }
    
            $user = $verify->user;
    
            if (!$user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
                $user->is_verified = 1;
                $user->save();
    
                UserVerify::where(['user_id' => $user->id])->delete();
    
                return response([
                    'otpConfirmStatus' => 'success',
                    'user' => $user,
                    'message' => 'Your account has been verified, return to log in page and log in'
                ]);
            }
        }
    
        return response([
            'otpConfirmStatus' => 'Error',
            'message' => 'Action unsuccessful',
        ]);
    }
    
}
