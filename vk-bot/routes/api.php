<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Laravel\Sanctum\Http\Controllers\LoginController;
use Laravel\Sanctum\Http\Controllers\LogoutController;
use Laravel\Sanctum\Http\Controllers\RegisteredUserController;

Route::post('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth:sanctum')->post('/logout', [LogoutController::class, 'logout']);


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
