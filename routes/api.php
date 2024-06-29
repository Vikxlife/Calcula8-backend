<?php

use App\Http\Controllers\AuthController\LoginController;
use App\Http\Controllers\AuthController\PasswordResetController;
use App\Http\Controllers\AuthController\RegisterController;
use App\Http\Controllers\AuthController\VerifyEmailController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/RegisterUser', [RegisterController::class, 'RegisterUser'])->name('RegisterUser'); 
Route::post('/LoginUser', [LoginController::class, 'LoginUser'])->name('LoginUser'); 
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/verifyAccount', [VerifyEmailController::class, 'verifyAccount'])->name('verifyAccount');
Route::post('/passwordReset', [PasswordResetController::class, 'passwordReset'])->name('passwordReset');
// Route::middleware('auth-sanctum')->post('/CreateUserProfile', [UserProfileController::class, 'CreateUserProfile'])->name('CreateUserProfile');
Route::post('/CreateUserProfile', [UserProfileController::class, 'CreateUserProfile'])->name('CreateUserProfile');



Route::get('/getusers', [RegisterController::class, 'getusers'])->name('getusers');
Route::get('/getuserprofile', [UserProfileController::class, 'getuserprofile'])->name('getuserprofile');


