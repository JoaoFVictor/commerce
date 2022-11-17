<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cliente/nome/{nome}', 'ClienteController@ListarPeloNome')->name('cliente.listar.nome');
    Route::apiResource('/cliente', 'ClienteController');
});
