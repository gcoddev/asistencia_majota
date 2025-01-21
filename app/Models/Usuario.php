<?php

namespace App\Models;

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
        'username',
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
        return $this->hasOne(EmpleadoDetalle::class, 'usu_id','id');
    }
}
