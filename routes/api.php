<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\User\InstructionController;

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

Route::group(['prefix' => 'v1'], function (){
    Route::post('sign-up', [RegisterController::class, 'signUp']);
    Route::post('sign-in', [LoginController::class, 'signIn']);
    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::post('logout',[LoginController::class, 'logout']);
        Route::group(['prefix' => 'user'], function (){
            Route::get('me', [LoginController::class, 'getMe']);
            Route::get('/instruction/{instruction}', [InstructionController::class, 'getInstruction']);
            Route::post('/sign/instruction/{instruction}', [InstructionController::class, 'signInstruction']);
        });
    });
});
