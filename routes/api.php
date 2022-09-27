<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsersContact;
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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/email/verify/{id}/{hash}', 'verify')->middleware(['auth', 'signed'])->name('verification.verify');
    Route::get('/info', 'userInfo')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'store')->withTrashed();
    Route::get('/{id}', 'show')->withTrashed();
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::controller(UsersContact::class)->prefix('contacts')->group(function () {
    Route::post('/{userId}', 'updateOrCreate');
});
