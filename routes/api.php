<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationControllerr;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [JWTAuthController::class, 'register']);
Route::post('/login', [JWTAuthController::class, 'login']);
Route::get('/user', [JWTAuthController::class, 'getUser']);
Route::post('/logout', [JWTAuthController::class, 'logout']);

// Quotations
Route::apiResource('quotations', QuotationController::class)
    ->middleware(['jwt.auth','action.logger']);
Route::post('/quotations/{id}/approve', [QuotationController::class, 'approve'])
    ->middleware(['jwt.auth','action.logger']);

// Vehicle Type
Route::apiResource('vehicle-types', VehicleTypeController::class)
    ->middleware(['jwt.auth','action.logger']);

// Shipments
Route::get('/shipments/getRequestNo', [ShipmentController::class, 'getRequestNo'])
    ->middleware(['jwt.auth','action.logger']);
Route::apiResource('shipments', ShipmentController::class)
    ->middleware(['jwt.auth','action.logger']);

// Customer
Route::get('/customers/getRequestNo', [CustomerController::class, 'getRequestNo'])
    ->middleware(['jwt.auth','action.logger']);
Route::apiResource('customers', CustomerController::class)
    ->middleware(['jwt.auth','action.logger']);

// Locations 
Route::apiResource('locations', LocationController::class)
    ->middleware(['jwt.auth','action.logger']);