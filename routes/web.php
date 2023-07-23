<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('forgot-password', [UserController::class, 'resetPasswordView'])->name('user.password-reset-view');

Route::post('reset-password', [UserController::class, 'passwordResetProcess'])->name('user.change-password');