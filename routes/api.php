<?php

use App\Http\Controllers\API\Admin\ItemController as AdminItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ResetPasswordController;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('admin/register', [AuthController::class, 'adminRegister']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail']);
    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->middleware('verified');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [AuthController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'role:admin', 'verified']], function () {
    Route::get('/items/unapproved', [AdminItemController::class, 'unApproveItem']);
    Route::put('/items/{id}/approve', [AdminItemController::class, 'approve']);
    Route::put('/items/{id}/reject', [AdminItemController::class, 'reject']);
    Route::delete('/items/{id}', [AdminItemController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'role:user', 'verified']], function () {
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
});
