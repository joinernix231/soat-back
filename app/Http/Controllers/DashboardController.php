<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\PolizaSoat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Cliente::count();
        $totalVehiculos = Vehiculo::count();
        $totalPolizas = PolizaSoat::count();
        $polizasVigentes = PolizaSoat::where('estado', 'vigente')->count();
        
        $clientesRecientes = Cliente::with('vehiculos.polizas')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClientes',
            'totalVehiculos',
            'totalPolizas',
            'polizasVigentes',
            'clientesRecientes'
        ));
    }
}
