<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ConfirmPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    //** Register Routes */
    Route::get('/register', [RegisterController::class, 'create'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'store']);

    //** Login Routes */
    Route::get('/login', [AuthenticateController::class, 'create'])->name('auth.login');
    Route::post('/login', [AuthenticateController::class, 'store']);

    //** Forgot Password */
    Route::get('/forgot-password', [ResetPasswordController::class, 'requestPassword'])
        ->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])
        ->name('password.email');

    //** Reset Password */
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetHandler'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::delete('/logout', [AuthenticateController::class, 'destroy'])->name('auth.logout');

    //** Email Verification */
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'handler'])
        ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    //** --- Password Confirmation --- */
    Route::get('/confirm-password', [ConfirmPasswordController::class, 'create'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->middleware('throttle:6,1');
});