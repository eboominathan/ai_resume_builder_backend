<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
 


Route::apiResource('users', UserController::class);
Route::apiResource('customer-details', CustomerController::class);
Route::apiResource('family-details', FamilyController::class);
Route::get('get-auto-complete', [CustomerController::class, 'getAutocomplete']);
Route::get('get-customer', [CustomerController::class, 'getCustomer']);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('subcategories', SubcategoryController::class);
