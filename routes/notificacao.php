<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('notificacao')->name('notificacao.')->group(function () {
    Route::apiResource('/topico', 'TopicoController');
    Route::apiResource('/mensagem', 'MensagemController');
    Route::prefix('/clientes')->name('clientes.')->group(function () {
        Route::apiResource('/topicos', 'ClienteTopicoController')->parameters([
            'topicos' => 'clienteTopico',
        ]);
        Route::post('/mensagem', 'ClienteMensagemController@store')->name('mensagem.store');
    });
});
