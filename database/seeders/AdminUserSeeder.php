<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Usuario para acceder al panel (/login).
     *
     * Credenciales por defecto (cámbialas en producción):
     *   Correo: admin@soatmundial.local
     *   Contraseña: password
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@soatmundial.local'],
            [
                'name' => 'Administrador SOAT',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
