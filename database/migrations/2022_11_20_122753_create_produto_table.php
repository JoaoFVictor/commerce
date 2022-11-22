<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barras');
            $table->string('nome');
            $table->string('marca');
            $table->float('preco_custo')->nullable();
            $table->float('preco_venda')->nullable();
            $table->date('validade')->nullable();
            $table->bigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto');
    }
};
