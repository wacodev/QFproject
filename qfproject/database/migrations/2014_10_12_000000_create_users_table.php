<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('carnet')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('tipo', ['Administrador', 'Asistente', 'Docente', 'Visitante'])->default('Docente');
            $table->string('imagen')->default('user_default.jpg');
            $table->rememberToken();
            $table->timestamps();
            
            /*
             * ---------------------------------------------------------------------------
             * Agregar luego en caso de usar acceso por medio de Google y permitir que
             * password sea nula:
             *
             * $table->string('provider');
             * $table->string('provider_id')->unique();
             * ---------------------------------------------------------------------------
             */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
