<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
   


    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_tarea_comentario');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'id_tarea_archivo');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado_tarea');
    }

}