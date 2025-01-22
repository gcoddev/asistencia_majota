<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReciboItem extends Model
{
    protected $table = 'recibo_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'recibo_id',
        'item_id',
        'tipo'
    ];

    public function item()
    {
        return $this->hasOne(EmpleadoDescuentoCompensacion::class, 'id', 'item_id');
    }
}
