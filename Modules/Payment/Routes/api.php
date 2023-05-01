<?php

use Modules\Payment\Http\Controllers\Api\PaymentApiController;

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

Route::group(['prefix' => 'v1', 'as' => 'payment.api.'], function () {
    Route::post('/payment', [PaymentApiController::class, 'save_payment'])->name('save');
    Route::post('/user/create/payment/{record}', [PaymentApiController::class, 'request_link']);
});
