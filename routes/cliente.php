<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cliente/nome/{nome}', 'ClienteController@buscarPeloNome')->name('cliente.buscar.nome');
    Route::apiResource('/cliente', 'ClienteController');
});
