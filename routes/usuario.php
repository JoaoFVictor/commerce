<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/show', 'DadosController@show')->name('show');
    Route::post('/update', 'DadosController@update')->name('update');
    Route::delete('/delete', 'DadosController@destroy')->name('delete');
});
