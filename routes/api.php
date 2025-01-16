<?php
 
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
 


Route::apiResource('users', UserController::class);
Route::apiResource('customer-details', CustomerController::class);
Route::apiResource('family-details', FamilyController::class);
Route::get('get-street-names', [CustomerController::class, 'getStreetNames']);
Route::get('get-customer', [CustomerController::class, 'getCustomer']);

