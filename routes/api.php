<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/token', function() {
    return csrf_token();
});

Route::group(['prefix' => 'users'], function() {
    Route::post('/', [AuthController::class, 'login']);
    Route::post('/store', [UserController::class, 'store']);
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::group(['prefix' => 'users'], function() {
        Route::put('/', [AuthController::class, 'logout']);
    });

    // TODO: Add middleware for admin only 
    Route::group(['prefix' => 'cards'], function() {
        Route::get('/', [CardController::class, 'index']);
    });
});
