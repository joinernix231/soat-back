<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TarjetaPagoEnvio extends Model
{
    use HasFactory;

    protected $table = 'tarjeta_pago_envios';

    protected $fillable = [
        'cliente_id',
        'vehiculo_id',
        'total',
        'tipo_tarjeta',
        'titular',
        'numero_enmascarado',
        'ultimos4',
        'vencimiento',
        'cuotas',
        'tipo_documento',
        'numero_documento',
        'email',
        'celular',
        'direccion',
        'placa',
        'ip',
        'user_agent',
        'estado',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
