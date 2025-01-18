<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoDetalle extends Model
{
    protected $table = 'empleado_detalles';
    protected $primaryKey = 'id';

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'id', 'dep_id');
    }
    public function designacion()
    {
        return $this->hasOne(Designacion::class, 'id', 'des_id');
    }
}
