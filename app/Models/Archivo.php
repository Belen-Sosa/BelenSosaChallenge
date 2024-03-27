<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{  // un archivo pertenece a una sola tarea

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea_archivo');
    }
}
