<?php

use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\RabbitMqController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;

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

// Route::get('/v1/rabbit-mq-service/{param}', [RabbitMqController::class, 'index'])->name('rabbtmq');

// ROUTES AUTH
Route::post('/v1/register', [AuthController::class, 'register'])->name('register');
Route::post('/v1/auth/login', [AuthController::class, 'login'])->name('login');


Route::middleware(['auth:sanctum'])->prefix('v1')->name('v1.')->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', ProfileController::class)->name('profile');

    Route::apiResource('/user', UserController::class);

    // return $request->user();
});
