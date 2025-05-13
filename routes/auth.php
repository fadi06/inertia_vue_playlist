<?php


use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class,'create'])->name('register');
    Route::post('/register', [RegisterController::class,'store'])->name('registerUser');

    Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'store'])->name('loginUser');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'destroy'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});