<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationControllerr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [JWTAuthController::class, 'register']);
Route::post('/login', [JWTAuthController::class, 'login']);
Route::get('/user', [JWTAuthController::class, 'getUser']);
Route::post('/logout', [JWTAuthController::class, 'logout']);

Route::apiResource('quotations', QuotationController::class)
    ->middleware('jwt.auth')
    ->only(['index', 'store', 'show', 'update', 'destroy']);