<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->text('titulo', 100);
            $table->text('conteudo', 100);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('topico_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('topico_id')->references('id')->on('topicos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensagens');
    }
};
