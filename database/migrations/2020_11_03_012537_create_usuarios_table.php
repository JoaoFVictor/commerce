<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('senha');
            $table->boolean('status')->default(0);
            $table->string('codigo_confirmacao', 50)->nullable();
            $table->unique('email', 'categories_email_unique');
            $table->string('telefone');
            $table->string('plano')->nullable();
            $table->unsignedBigInteger('imagem_id')->nullable();
            $table->foreign('imagem_id')->references('id')->on('imagens');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
