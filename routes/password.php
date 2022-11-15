<?php

use Illuminate\Support\Facades\Route;

Route::prefix('password')->name('password.')->group(function () {
    Route::post('/email', 'SenhaController@recuperarSenha')->name('email');
    Route::post('/reset', 'SenhaController@resetarSenha')->name('update');
    Route::get('/reset/{token}', 'SenhaController@requisicaoFormularioResetar')->middleware('web')->name('reset');
    Route::get('/reset', 'SenhaController@resetarSenhaFormulario')->middleware('web')->name('request');
});
