<?php
 
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
 


Route::apiResource('users', UserController::class);
Route::apiResource('resumes', ResumeController::class);
