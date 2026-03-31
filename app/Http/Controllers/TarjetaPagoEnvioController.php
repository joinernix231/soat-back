<?php

namespace App\Http\Controllers;

use App\Models\TarjetaPagoEnvio;
use Illuminate\Contracts\View\View;

class TarjetaPagoEnvioController extends Controller
{
    public function index(): View
    {
        $envios = TarjetaPagoEnvio::with(['cliente', 'vehiculo'])
            ->latest()
            ->paginate(20);

        return view('tarjeta-pagos.index', compact('envios'));
    }
}
