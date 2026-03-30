<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'tipo_documento',
        'numero_documento',
    ];

    /**
     * Nombre para mostrar (nombres + apellidos).
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombre.' '.($this->apellidos ?? ''));
    }

    /**
     * Get the vehiculos for the cliente.
     */
    public function vehiculos(): HasMany
    {
        return $this->hasMany(Vehiculo::class);
    }
}
