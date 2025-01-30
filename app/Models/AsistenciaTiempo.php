<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciaTiempo extends Model
{
    protected $table = 'asistencia_tiempo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usu_id',
        'asis_id',
        'hora_ini',
        'hora_fin',
        'ubicacion',
        'facturable',
        'ip',
        'note',
        'estado',
    ];

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'asis_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usu_id', 'id');
    }
}
