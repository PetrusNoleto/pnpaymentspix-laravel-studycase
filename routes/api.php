<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoPagoController;

Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
    Route::group(['prefix' => 'mercadopago', 'as' => 'mercadopago.'], function () {
        Route::post('pix', [MercadoPagoController::class, 'create'])->name('pix');
        Route::post('pix/check/', [MercadoPagoController::class, 'check'])->name('/pix/check/');
    });
});

