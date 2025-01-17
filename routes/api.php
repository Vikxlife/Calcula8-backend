<?php

use App\Http\Controllers\AuthController\LoginController;
use App\Http\Controllers\AuthController\PasswordResetController;
use App\Http\Controllers\AuthController\RegisterController;
use App\Http\Controllers\AuthController\VerifyEmailController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Exam\GetExamQuestionController;
use App\Http\Controllers\ExamsStatusController;
use App\Http\Controllers\Paystack\PaymentController;
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

Route::get('/getusers', [RegisterController::class, 'getusers'])->name('getusers');
// Route::middleware('auth:sanctum')->get('/getAuthUser', [RegisterController::class, 'getAuthUser'])->name('getAuthUser');





Route::post('/RegisterUser', [RegisterController::class, 'RegisterUser'])->name('RegisterUser'); 
Route::post('/LoginUser', [LoginController::class, 'LoginUser'])->name('LoginUser'); 
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/verifyAccount', [VerifyEmailController::class, 'verifyAccount'])->name('verifyAccount');
Route::post('/passwordReset', [PasswordResetController::class, 'passwordReset'])->name('passwordReset');
Route::post('/generateUserOtp', [BaseController::class, 'generateUserOtp'])->name('generateUserOtp');


Route::post('/CreateUserProfile', [UserProfileController::class, 'CreateUserProfile'])->name('CreateUserProfile');
Route::middleware('auth:sanctum')->get('/getuserprofile/{id}', [UserProfileController::class, 'getuserprofile'])->name('getuserprofile');
Route::middleware('auth:sanctum')->post('/updateuserprofile/{id}', [UserProfileController::class, 'updateuserprofile'])->name('updateuserprofile');


Route::get('/fetchQuestion/{paper}', [GetExamQuestionController::class, 'fetchQuestion'])->name('fetchQuestion');
Route::get('/fetchQuestionById/{id}', [GetExamQuestionController::class, 'fetchQuestionById'])->name('fetchQuestion');

Route::middleware('auth:sanctum')->post('/ExamsResponse', [ExamsStatusController::class, 'ExamsResponse'])->name('ExamsResponse');
Route::middleware('auth:sanctum')->get('/getexamresult', [ExamsStatusController::class, 'getexamresult'])->name('getexamresult');


Route::middleware('auth:sanctum')->post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback'])->name('paystack.callback');
Route::post('/paystack/webhook', [PaymentController::class, 'handleWebhook'])->name('paystack');
