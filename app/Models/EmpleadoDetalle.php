<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoDetalle extends Model
{
    protected $table = 'empleado_detalles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usu_id',
        'dep_id',
        'des_id',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usu_id');
    }

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'id', 'dep_id');
    }

    public function designacion()
    {
        return $this->hasOne(Designacion::class, 'id', 'des_id');
    }

    public function salario()
    {
        return $this->hasOne(EmpleadoSalario::class, 'usu_detalle_id', 'id');
    }

    public function compensaciones()
    {
        return $this->hasMany(EmpleadoDescuentoCompensacion::class, 'usu_detalle_id', 'id')
            ->where('tipo', 'compensacion')->with('items');
    }

    public function deducciones()
    {
        return $this->hasMany(EmpleadoDescuentoCompensacion::class, 'usu_detalle_id', 'id')
            ->where('tipo', 'deduccion')->with('items');
    }
}
