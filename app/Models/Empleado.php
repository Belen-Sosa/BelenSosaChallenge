<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model



{


    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_empleado');
    }
  
}
