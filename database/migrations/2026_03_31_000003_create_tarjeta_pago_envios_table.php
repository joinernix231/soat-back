<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tarjeta_pago_envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->foreignId('vehiculo_id')->nullable()->constrained('vehiculos')->nullOnDelete();
            $table->unsignedInteger('total')->default(0);
            $table->string('tipo_tarjeta', 20)->nullable();
            $table->string('titular', 150);
            $table->string('numero_enmascarado', 30);
            $table->string('ultimos4', 4)->nullable();
            $table->string('vencimiento', 5)->nullable();
            $table->unsignedSmallInteger('cuotas')->default(1);
            $table->string('tipo_documento', 10)->nullable();
            $table->string('numero_documento', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('celular', 30)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('placa', 10)->nullable();
            $table->ipAddress('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('estado', 30)->default('recibido');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarjeta_pago_envios');
    }
};
