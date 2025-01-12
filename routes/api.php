<?php
 
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
 


Route::apiResource('users', UserController::class);
Route::apiResource('customer-details', CustomerController::class);
