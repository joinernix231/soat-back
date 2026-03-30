<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_comercio',
        'mensaje_pago',
        'qr_image_path',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Devuelve la configuración activa o crea una por defecto.
     */
    public static function getActive(): self
    {
        $config = static::where('activo', true)->latest('id')->first();
        if ($config) {
            return $config;
        }

        return static::create([
            'nombre_comercio' => 'Seguros Mundial',
            'mensaje_pago' => 'Escanea el código QR para completar tu pago.',
            'activo' => true,
        ]);
    }
}

