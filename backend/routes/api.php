<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum', 'admin')->group(function () {
    Route::get('/dashboard/kpis', [DashboardController::class, 'kpis']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
