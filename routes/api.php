<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationControllerr;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [JWTAuthController::class, 'register']);
Route::post('/login', [JWTAuthController::class, 'login']);
Route::get('/user', [JWTAuthController::class, 'getUser']);
Route::post('/logout', [JWTAuthController::class, 'logout']);

// Quotations
Route::post('/quotations/{id}/approve', [QuotationController::class, 'approve'])
    ->middleware(['jwt.auth','action.logger']);
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
Route::post('/shipments/{id}/assign', [ShipmentController::class, 'assignVehicleDriver'])
    ->middleware(['jwt.auth','action.logger']);


// Shipment
Route::post('/shipments/{id}/approve', [ShipmentController::class, 'approve'])
    ->middleware(['jwt.auth','action.logger']);

Route::get('/shipments/{id}/costs', [ShipmentController::class, 'getCosts'])
    ->middleware(['jwt.auth','action.logger']);

Route::get('/shipments/invoice', [ShipmentController::class, 'getShipmentsForInvoice'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/shipments/{id}/arrived', [ShipmentController::class, 'arrivedAtPickup'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/shipments/{id}/cancel', [ShipmentController::class, 'cancel'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/shipments/{id}/attend', [ShipmentController::class, 'attend'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/shipments/{id}/ongoing', [ShipmentController::class, 'setOngoing'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/shipments/{id}/complete', [ShipmentController::class, 'setComplete'])
    ->middleware(['jwt.auth','action.logger']);

Route::get('/shipments/{id}/print-gatepass', [ShipmentController::class, 'printGatepass'])
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

// Vehicle
Route::apiResource('vehicles', VehicleController::class)
    ->middleware(['jwt.auth','action.logger']);

// Employee
Route::apiResource('employees', EmployeeController::class)
    ->middleware(['jwt.auth','action.logger']);

// Company
Route::apiResource('company', CompanyController::class)
    ->middleware(['jwt.auth','action.logger']);

// User
Route::post('/users/{id}/approve', [UserController::class, 'approve'])
    ->middleware(['jwt.auth','action.logger']);
Route::post('/users/{id}/reject', [UserController::class, 'reject'])
    ->middleware(['jwt.auth','action.logger']);
Route::apiResource('users', UserController::class)
    ->middleware(['jwt.auth','action.logger']);

// Backup
Route::get('/database-backup', [ConfigController::class, 'downloadBackup'])
    ->middleware(['jwt.auth','action.logger']);

// Invoice
Route::post('/addCosts', [InvoiceController::class, 'addCosts'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/invoice/{id}/approve', [InvoiceController::class, 'approveInvoice'])
    ->middleware(['jwt.auth','action.logger']);

Route::post('/invoice/{id}/cancel', [InvoiceController::class, 'cancelInvoice'])
    ->middleware(['jwt.auth','action.logger']);
    
Route::get('/invoices/generate-invoice-no', [InvoiceController::class, 'generateInvoiceNumber'])
    ->middleware(['jwt.auth','action.logger']);

Route::get('/invoice/{id}/print', [InvoiceController::class, 'printInvoice'])
    ->middleware(['jwt.auth','action.logger']);

Route::apiResource('invoice', InvoiceController::class)
    ->middleware(['jwt.auth','action.logger']);

// TEST EMAIL 
Route::get('/test-email', [ReportController::class, 'sendtestmail']);