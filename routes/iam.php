<?php


use Illuminate\Support\Facades\Route;
use thiagovictorino\IAM\Http\Controllers\IAMAuthController;
use thiagovictorino\IAM\Http\Controllers\IAMUserController;
use thiagovictorino\IAM\Http\Middleware\IAMAuthMiddleware;


Route::prefix('iam/v1/')->group(function () {
    Route::get('auth', IAMAuthController::class.'@auth');
    Route::post('auth', IAMAuthController::class.'@auth');

    Route::group(['middleware' => [IAMAuthMiddleware::class.":IAM_read"]], function () {
        Route::prefix('user')->group(function(){
            Route::get('/', IAMUserController::class.'@index');
        });
    });

});