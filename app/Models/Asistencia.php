<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usu_id',
        'fecha',
    ];

    public function asistencias()
    {
        return $this->hasMany(AsistenciaTiempo::class, 'asis_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id', 'usu_id');
    }
}
