<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContadorTable extends Migration
{
    public function up()
    {
        Schema::create('contador', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contador');
    }
}
