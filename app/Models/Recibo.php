<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table = 'recibos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'usu_detalle_id',
        'use_permiso',
        'use_descuento',
        'fecha_recibo',
        'salario_neto'
    ];

    public function empleado()
    {
        return $this->hasOne(EmpleadoDetalle::class, 'id', 'usu_detalle_id');
    }

    public function compensaciones()
    {
        return $this->hasMany(ReciboItem::class, 'recibo_id', 'id')->where('tipo', 'compensacion');
    }
    public function deducciones()
    {
        return $this->hasMany(ReciboItem::class, 'recibo_id', 'id')->where('tipo', 'deduccion');
    }
}
