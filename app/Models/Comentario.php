<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{   

   
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea_comentario');
    }
}
