<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\User\InstructionController;
use App\Http\Controllers\Api\V1\User\RecordController;
use App\Http\Controllers\Api\V1\Manager\ManagerController;
use App\Http\Controllers\Api\V1\Security\SecurityController;

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

            Route::get('/vehicle_types/{organization}', [RecordController::class, 'getVehicleTypes']);
            Route::get('/visit_purposes/{organization}', [RecordController::class, 'getVisitPurposes']);
            Route::get('/place_of_directions/{organization}', [RecordController::class, 'getPlaceOfDirections']);

            Route::get('/services/{organization}', [RecordController::class, 'getServices']);
            Route::get('/tariffs/{service}', [RecordController::class, 'getTariffs']);

            Route::post('/create_record/{organization}', [RecordController::class, 'createRecord']);
            Route::get('/records', [RecordController::class, 'getRecords']);
        });
        Route::group(['prefix' => 'manager'], function(){
            Route::get('/me', [ManagerController::class, 'getMe']);
            Route::get('/records', [ManagerController::class, 'getRecords']);
            Route::post('/records/create', [ManagerController::class, 'createRecord']);
            Route::delete('/records/{record}/delete', [ManagerController::class, 'deleteRecord']);

            Route::get('/search/iin', [ManagerController::class, 'searchByIIN']);
        });
        Route::group(['prefix' => 'security'], function(){
            Route::get('/scan_qr/{uuid}', [SecurityController::class, 'scan_qr']);
        });
    });
});
