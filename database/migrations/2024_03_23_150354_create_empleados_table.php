<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id()->nullable(false);
      
            $table->string('nombres')->unique()->nullable(false);
            $table->string('apellido')->nullable(false);
            $table->string('correo')->unique()->nullable(false);
            $table->string('contrasenia')->nullable(false);
            $table->boolean('super_usuario')->nullable(false);
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
        Schema::dropIfExists('empleados');
    }
}
