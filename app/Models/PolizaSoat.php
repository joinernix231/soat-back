<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PolizaSoat extends Model
{
    use HasFactory;

    /** @var string Nombre real de la tabla (la convención daría `poliza_soats`). */
    protected $table = 'polizas_soat';

    protected $fillable = [
        'vehiculo_id',
        'numero_poliza',
        'fecha_inicio',
        'fecha_fin',
        'valor',
        'estado',
        'aseguradora',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'valor' => 'decimal:2',
    ];

    /**
     * Get the vehiculo that owns the poliza.
     */
    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
