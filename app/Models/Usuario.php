<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Usuario extends User
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $guard = 'admin';
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'ci',
        'tipo',
        'celular',
        'password',
        'imagen',
        'direccion',
        'ciudad',
        'activo',
        'en_linea'
    ];

    public function detalle()
    {
        return $this->hasOne(EmpleadoDetalle::class, 'usu_id', 'id');
    }

    public function asistencia()
    {
        return $this->hasOne(Asistencia::class, 'usu_id', 'id')->where('fecha', date('Y-m-d'));
    }
}
