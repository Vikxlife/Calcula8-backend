<?php

use App\Http\Controllers\AuthController\PasswordResetController;
use App\Models\PasswordReset;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/error', function () {
    $message = session('message', 'An error occurred.');
    return view('Error.error', compact('message'));
})->name('error.page');

Route::get('/password/reset/success', function () {
    return view('password.reset.success');
})->name('password.reset.success');


Route::get('/password_reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');





// Route::get('/password_reset/{token}', function ($token) {

//     $verify = PasswordReset::where('token', $token)->first();

//     if (!$verify) {
//         return redirect()->route('Error.error')->with('message', 'Invalid or expired token.');
//     }

//     // Optionally, check if the token has expired
//     if (strtotime($verify->expiresAt) <= strtotime(now())) {
//         return redirect()->route('Error.error')->with('message', 'Token has expired.');
//     }

//     return view('Email.PasswordReset', ['token' => $token]);
// })->name('password.reset');
