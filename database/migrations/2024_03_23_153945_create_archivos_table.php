<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->unsignedBigInteger('id_tarea_archivo')->nullable(false);
            $table->string('nombre_archivo')->nullable(false);
            $table->timestamps();

            // Definir la clave externa
            $table->foreign('id_tarea_archivo')->references('id')->on('tareas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos');
    }
}
