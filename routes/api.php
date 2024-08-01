<?php 

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\SkillController;
use Illuminate\Routing\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('users.experiences', ExperienceController::class);
Route::apiResource('users.educations', EducationController::class);
Route::apiResource('users.skills', SkillController::class);


