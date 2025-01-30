<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'hora_ini',
        'hora_fin',
        'latitud',
        'longitud',
    ];
}
