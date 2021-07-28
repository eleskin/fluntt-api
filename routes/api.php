<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperationsController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::patch('change-currency', [AuthController::class, 'changeCurrency']);
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'operations'], function () {
        Route::get('/', [OperationsController::class, 'getOperations']);
        Route::post('/', [OperationsController::class, 'addOperation']);
        Route::patch('/{id}', [OperationsController::class, 'editOperation']);
        Route::delete('/{id}', [OperationsController::class, 'deleteOperation']);
    });
});
