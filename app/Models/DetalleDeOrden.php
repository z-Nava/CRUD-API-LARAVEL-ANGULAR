<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDeOrden extends Model
{
    use HasFactory;
    protected $table = 'detalles_de_orden';
    
    public function orden()
    {
    return $this->belongsTo(Orden::class);
    }

    public function producto()
    {
    return $this->belongsTo(Producto::class);
    }
}
