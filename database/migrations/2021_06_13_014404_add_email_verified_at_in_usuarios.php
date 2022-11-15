<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailVerifiedAtInUsuarios extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
}
