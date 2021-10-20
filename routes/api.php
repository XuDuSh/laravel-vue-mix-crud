<?php

use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\UserController;
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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'payments', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('add', [PaymentController::class, 'add']);
    Route::get('edit/{id}', [PaymentController::class, 'edit']);
    Route::post('update/{id}', [PaymentController::class, 'update']);
    Route::delete('delete/{id}', [PaymentController::class, 'delete']);
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('add', [UserController::class, 'add']);
    Route::get('get', [UserController::class, 'get']);
    Route::get('edit/{id}', [UserController::class, 'edit']);
    Route::get('{id}/history', [UserController::class, 'history']);
    Route::post('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'delete']);
});
