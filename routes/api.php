<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\MeController;
use App\Http\Controllers\API\V1\Auth\RefreshController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1::')->group(function () {
    Route::prefix('auth')->as('auth::')->group(function () {
        Route::middleware(['auth:api'])->group(function () {
            Route::post('/logout', LogoutController::class)->name('logout');
            Route::post('/refresh', RefreshController::class)->name('refresh');
            Route::post('/me', MeController::class)->name('me');
        });
        Route::post('/login', LoginController::class)->name('login');
        Route::post('/register', RegisterController::class)->name('register');
    });
});
