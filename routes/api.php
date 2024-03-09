<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;


Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('tasks', TaskController::class);


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/verify-token', [AuthController::class, 'verifyToken'])->name('verify-token');

});
