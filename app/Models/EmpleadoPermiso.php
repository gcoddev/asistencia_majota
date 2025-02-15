<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoPermiso extends Model
{
    protected $table = 'empleado_permisos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usu_detalle_id',
        'tipo',
        'fecha_ini',
        'fecha_fin',
        'dias',
        'razones',
        'estado',
        'usu_id'
    ];

    public function detalle()
    {
        return $this->hasOne(EmpleadoDetalle::class, 'id', 'usu_detalle_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usu_id');
    }
}
