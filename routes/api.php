<?php

use App\Http\Controllers\Api\AccessController;
use App\Http\Controllers\Api\AdditionController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AddressesContactController;
use App\Http\Controllers\Api\AddressesGalleryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
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

Route::controller(UserController::class)->prefix('users')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store')->withTrashed();
    Route::get('/{id}', 'show')->withTrashed();
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
    Route::post('/role', 'addRole');
    Route::delete('/role', 'removeRole');
});

Route::controller(UsersContact::class)->prefix('contacts')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/{userId}', 'updateOrCreate');
});

Route::controller(RoleController::class)->prefix('roles')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store')->withTrashed();
    Route::get('/{id}', 'show')->withTrashed();
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
    Route::post('/access', 'addAccess');
    Route::delete('/access', 'removeAccess');
});

Route::controller(AccessController::class)->prefix('accesses')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::controller(CategoryController::class)->prefix('categories')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store')->withTrashed();
    Route::get('/{id}', 'show')->withTrashed();
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
});

Route::controller(ProductController::class)->prefix('products')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::post('/addition', 'addAddition');
    Route::delete('/addition', 'removeAddition');
    Route::post('/position', 'addPosition');
    Route::delete('/position', 'removePosition');
    Route::post('/tag', 'addTag');
    Route::delete('/tag', 'removeTag');
});

Route::controller(AdditionController::class)->prefix('additions')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::controller(PositionController::class)->prefix('positions')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
});

Route::controller(PartnerController::class)->prefix('partners')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
});

Route::controller(AddressController::class)->prefix('addresses')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
});

Route::controller(AddressesGalleryController::class)->prefix('addresses-galleries')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
});

Route::controller(AddressesContactController::class)->prefix('addresses-contacts')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::patch('/{id}', 'restore');
});
