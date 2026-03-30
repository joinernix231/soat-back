<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolizasSoatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polizas_soat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained()->onDelete('cascade');
            $table->string('numero_poliza')->unique();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('valor', 15, 2);
            $table->enum('estado', ['vigente', 'vencida', 'proxima_vencer'])->default('vigente');
            $table->string('aseguradora')->default('Seguros Mundial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polizas_soat');
    }
}
