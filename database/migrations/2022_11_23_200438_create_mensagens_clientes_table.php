<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mensagens_clientes', function (Blueprint $table) {
            $table->id();
            $table->boolean('visualizada')->default(0);
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('mensagem_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('mensagem_id')->references('id')->on('mensagens');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensagens_clientes');
    }
};
