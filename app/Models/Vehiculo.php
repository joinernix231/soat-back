<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'placa',
        'linea',
        'marca',
        'clase',
        'modelo',
        'año',
        'tipo_vehiculo',
    ];

    /**
     * Get the cliente that owns the vehiculo.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Get the polizas for the vehiculo.
     */
    public function polizas(): HasMany
    {
        return $this->hasMany(PolizaSoat::class);
    }
}
