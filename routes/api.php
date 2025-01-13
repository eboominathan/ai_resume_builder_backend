<?php
 
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
 


Route::apiResource('users', UserController::class);
Route::apiResource('customer-details', CustomerController::class);
Route::apiResource('family-details', FamilyController::class);
