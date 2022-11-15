<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsuarioTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('numero', 10)->change();
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('numero')->change();
        });
    }
}
