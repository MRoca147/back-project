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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout', 'AuthController@logout');

    Route::apiResource('activities', 'ActivityController');

    Route::get('tasks/completed/{id}', 'TaskController@completedTask');
    Route::apiResource('tasks', 'TaskController');
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');