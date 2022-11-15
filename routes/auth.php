<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/cadastro', 'UsuarioController@cadastro')->name('cadastro');
    Route::post('/login', 'UsuarioController@login')->name('login');
});
