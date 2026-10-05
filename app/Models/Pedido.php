<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $fillable = [
        'cliente',
        'telefono',
        'direccion',
        'producto',
        'cantidad',
        'total',
        'estado',
        'costo_express',
        'fecha_pedido',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'costo_express' => 'decimal:2',
        'fecha_pedido' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
