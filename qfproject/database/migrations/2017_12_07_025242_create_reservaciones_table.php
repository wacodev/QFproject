<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('local_id')->unsigned();
            $table->integer('asignatura_id')->unsigned();
            $table->integer('actividad_id')->unsigned();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('tema')->nullable();
            $table->string('responsable')->nullable();
            $table->enum('tipo', ['Ordinaria', 'Extraordinaria']);
            $table->string('codigo')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('local_id')->references('id')->on('locales')->onDelete('cascade');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservaciones');
    }
}
