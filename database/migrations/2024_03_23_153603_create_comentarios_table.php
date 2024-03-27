<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id()->nullable(false);
            $table->unsignedBigInteger('id_tarea_comentario')->nullable(false);
            $table->string('descripcion')->nullable(false);
            $table->timestamps();

            // Definir la clave externa
            $table->foreign('id_tarea_comentario')->references('id')->on('tareas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
