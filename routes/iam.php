<?php


use Illuminate\Support\Facades\Route;


Route::prefix('iam')->group(function () {
    Route::get('auth', \thiagovictorino\IAM\Controllers\IAMController::class.'@auth');
});