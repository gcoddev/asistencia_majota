<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoDescuentoCompensacion extends Model
{
    protected $table = 'empleado_descuentos_compensaciones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo',
        'usu_detalle_id',
        'nombre',
        'descripcion',
        'cantidad',
        'use',
        'usu_id',
    ];

    public function detalle()
    {
        return $this->hasOne(EmpleadoDetalle::class, 'id', 'usu_detalle_id');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usu_id');
    }

    public function items()
    {
        return $this->hasMany(ReciboItem::class, 'item_id', 'id');
    }
}
