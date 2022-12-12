<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'API'], function(){
    Route::post('login', 'AuthController@login');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('is_admin')->group(function(){
            Route::resource('questions', \APIQuestionController::class);
            Route::resource('users', \APIUserController::class);
        });
    });
});

