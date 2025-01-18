<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designacion extends Model
{
    protected $table = 'designaciones';
    protected $fillable = ['nombre', 'descripcion'];
}
