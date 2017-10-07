<?php


use Illuminate\Support\Facades\Route;
use thiagovictorino\IAM\Http\Controllers\IAMAuthController;


Route::prefix('iam/v1.0/')->group(function () {
    Route::get('auth', IAMAuthController::class.'@auth');
});