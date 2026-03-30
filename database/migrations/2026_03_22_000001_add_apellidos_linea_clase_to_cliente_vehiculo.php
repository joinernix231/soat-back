<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApellidosLineaClaseToClienteVehiculo extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('apellidos')->nullable()->after('nombre');
        });

        Schema::table('vehiculos', function (Blueprint $table) {
            $table->string('linea')->nullable()->after('placa');
            $table->string('clase')->nullable()->after('marca');
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('apellidos');
        });

        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropColumn(['linea', 'clase']);
        });
    }
}
