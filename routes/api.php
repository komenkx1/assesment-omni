<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
//verifyEmail
Route::get('/email/verify/{user:id}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::post('user/batch-insert', [UserController::class, 'batchInsert']);
    Route::get('/get-auth-user', [AuthController::class, 'getUser']);
    Route::get('/get-log', [LogController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
