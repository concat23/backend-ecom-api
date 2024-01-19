<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth',
    'controller' => App\Http\Controllers\Api\AuthenController::class,
], function ($router) {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/user', 'getUser')->middleware('auth:api');
    // Route::post('/logout', 'logout');
    // Route::post('/password/send_mail', 'password_send_mail');
    // Route::post('/password/verify', 'password_verify');
});

Route::group([
    'prefix' => 'users',
    'controller' => \App\Http\Controllers\Api\UserController::class,
    'middleware' => 'auth:api'
], function ($router) {
    Route::get('/', 'index');
});

//Dashboard API
Route::group([
    'prefix' => 'dashboard',
    'controller' => \App\Http\Controllers\Api\DashboardController::class,
    'middleware' => 'auth:api'
], function ($router) {
    Route::get('/info', 'index');
});

