<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table = 'ordenes';
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function detallesDeOrden()
    {
    return $this->hasMany(DetalleDeOrden::class);
    }
}
