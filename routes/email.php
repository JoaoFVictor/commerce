<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/email')->name('verification.')->group(function () {
    Route::post('/reenviar', 'EmailController@reenviarEmail')->middleware('auth:sanctum')->name('send');
    Route::get('/verify/{id}/{hash}', 'EmailController@verificarEmail')->middleware('signed')->name('verify');
});
