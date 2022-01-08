<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaceBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use \App\Http\Controllers\VerificationController;


Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::get('/user', [AuthController::class, 'profile'])->name('profile');
});

Route::prefix('facebook')->name('facebook.')->group( function(){
    Route::get('auth', [FaceBookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [FaceBookController::class, 'callbackFromFacebook'])->name('callback');
});

Route::group([
    'middleware' => ['api', 'role:admin'],
    'prefix' => 'admin'
], function ($router) {
    Route::get('/', [AdminController::class, 'index']);
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
});
