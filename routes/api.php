<?php

use LaraHR\Http\Controllers\API\AttendanceController;
use LaraHR\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;
use LaraHR\Http\Controllers\API\EmployeeController;

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

// Auth routes (login, register, etc.)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

// Protected routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    // Employee routes
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

    // Attendance routes
    Route::post('/attendance/checkin', [AttendanceController::class, 'recordCheckin']);
    Route::post('/attendance/checkout', [AttendanceController::class, 'recordCheckout']);
});
