<?php


use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/iam',function (){
   return 'iam route';
});