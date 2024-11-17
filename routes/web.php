<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function() {
    return response()->json([
        'message' => 'Please Login to continue',
    ]);
})->name('login');

Route::get('/password/reset/{token}', function ($token) {
    return response()->json(['message' => 'Password reset page for token: ' . $token]);
})->name('password.reset');

Route::get('/', function () {
    return view('welcome');
});
