<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\OAuthController;

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware(['jwt-auth'])->group(function() {
    Route::post('/product', [ProductsController::class,'Store']);
    Route::get('/product', [ProductsController::class,'ShowAll']);
    Route::get('/product/{id}', [ProductsController::class,'ShowById']);
    Route::put('/product/{id}', [ProductsController::class,'update']);
    Route::delete('/product/{id}', [ProductsController::class,'delete']);
    
    Route::post('/category', [CategoryController::class,'Store']);
    Route::get('/category', [CategoryController::class,'ShowAll']);
    Route::get('/category/{id}', [CategoryController::class,'ShowById']);
    Route::put('/category/{id}', [CategoryController::class,'update']);
    Route::delete('/category/{id}', [CategoryController::class,'delete']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/auth/google', 'oauthController@redirectToGoogle');
Route::get('/auth/google/callback', 'oauthController@handleGoogleCallback');
