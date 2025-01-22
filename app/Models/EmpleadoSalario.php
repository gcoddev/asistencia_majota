<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoSalario extends Model
{
    protected $table = 'empleado_salarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usu_detalle_id',
        'base',
        'salario_base',
        'metodo_pago',
        'pf_contribucion',
        'pf_numero',
        'pf_adicional',
        'pf_tasa_total',
        'esi_contribucion',
        'esi_numero',
        'esi_adicional',
        'esi_tasa_total',
    ];
}
