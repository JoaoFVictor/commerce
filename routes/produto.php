<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/produtos', 'ProdutoController');
    Route::prefix('/produtos')->name('produtos.')->group(function () {
        Route::get('/nome/{nome}', 'ProdutoController@buscarPorNome')->name('buscar.nome');
        Route::get('/codigo_barras/{codigoBarras}', 'ProdutoController@buscarPorCodigoBarras')->name('buscar.codigo-barras');
        Route::get('/total/valor', 'ProdutoController@getValorTotal')->name('total.valor');
    });
});
