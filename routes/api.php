<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\MeController;
use App\Http\Controllers\API\V1\Auth\RefreshController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\API\V1\Role\User\ListController as RoleUserListController;
use App\Http\Controllers\API\V1\User\DestroyController as UserDestroyController;
use App\Http\Controllers\API\V1\User\IndexController as UserIndexController;
use App\Http\Controllers\API\V1\User\ShowController as UserShowController;
use App\Http\Controllers\API\V1\User\StoreController as UserStoreController;
use App\Http\Controllers\API\V1\User\UpdateController as UserUpdateController;
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

    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('users')->as('users::')->group(function () {
            Route::prefix('roles')->as('roles::')->group(function () {
                Route::withoutMiddleware(['auth:api'])->group(function () {
                    Route::get('/list', RoleUserListController::class)->name('list');
                });
            });
            Route::get('/', UserIndexController::class)->name('index');
            Route::get('/{user}', UserShowController::class)->name('show');
            Route::put('/{user}', UserUpdateController::class)->name('update');
            Route::delete('/{user}', UserDestroyController::class)->name('destroy');
        });
    });
});
