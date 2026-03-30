<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\QrConfig;
use App\Models\Vehiculo;
use App\Models\PolizaSoat;
use Illuminate\Http\Request;

class ConsultaSoatController extends Controller
{
    /**
     * Handle public consultation request.
     */
    public function consulta(Request $request)
    {
        if ($request->filled('sm_hp_company')) {
            return redirect()->back()->with('error', 'No se pudo verificar la solicitud.');
        }

        $request->validate([
            'tipo_documento' => ['required', 'string', 'in:CC,CE,PA,NIT'],
            'numero_documento' => ['required', 'string', 'max:50'],
            'placa' => ['required', 'string', 'max:10'],
            'acepta_privacidad' => ['required', 'accepted'],
            'acepta_comunicaciones' => ['nullable'],
            'human_confirm' => ['required', 'accepted'],
            'captcha_ts' => ['required', 'integer'],
            'captcha_sig' => ['required', 'string', 'size:64'],
        ]);

        $expectedSig = hash_hmac('sha256', (string) $request->captcha_ts, config('app.key'));
        if (! hash_equals($expectedSig, $request->captcha_sig)) {
            return redirect()->back()->with('error', 'Verificación de seguridad no válida. Actualiza la página e intenta de nuevo.');
        }

        $age = time() - (int) $request->captcha_ts;
        if ($age < 2 || $age > 7200) {
            return redirect()->back()->with('error', 'La verificación de seguridad expiró. Actualiza la página e intenta de nuevo.');
        }

        // Buscar cliente por documento
        $cliente = Cliente::where('tipo_documento', $request->tipo_documento)
            ->where('numero_documento', $request->numero_documento)
            ->first();

        if (!$cliente) {
            return redirect()->back()->with('error', 'No se encontraron registros para el documento ingresado.');
        }

        // Buscar vehículo por placa y cliente
        $vehiculo = Vehiculo::where('cliente_id', $cliente->id)
            ->where('placa', strtoupper($request->placa))
            ->with('polizas')
            ->first();

        if (!$vehiculo) {
            return redirect()->back()->with('error', 'No se encontró un vehículo con la placa ingresada para este documento.');
        }

        $request->session()->put('soat_confirmacion', [
            'cliente_id' => $cliente->id,
            'vehiculo_id' => $vehiculo->id,
        ]);

        return redirect()->route('soat.confirmacion');
    }

    /**
     * Pantalla de confirmación de compra (estilo flujo Seguros Mundial).
     */
    public function confirmacion(Request $request)
    {
        $payload = $request->session()->get('soat_confirmacion');
        if (! is_array($payload) || empty($payload['cliente_id']) || empty($payload['vehiculo_id'])) {
            return redirect()->route('welcome')
                ->with('error', 'No hay datos de compra. Completa el formulario e inténtalo de nuevo.');
        }

        $cliente = Cliente::find($payload['cliente_id']);
        $vehiculo = Vehiculo::where('id', $payload['vehiculo_id'])
            ->where('cliente_id', $payload['cliente_id'])
            ->with('polizas')
            ->first();

        if (! $cliente || ! $vehiculo) {
            $request->session()->forget('soat_confirmacion');

            return redirect()->route('welcome')
                ->with('error', 'Los datos de la sesión ya no son válidos.');
        }

        $poliza = $vehiculo->polizas()
            ->orderBy('fecha_fin', 'desc')
            ->first();

        return view('soat.confirmacion', compact('cliente', 'vehiculo', 'poliza'));
    }

    /**
     * Pantalla de pago (paso 3 del flujo).
     */
    public function pago(Request $request)
    {
        $payload = $request->session()->get('soat_confirmacion');
        if (! is_array($payload) || empty($payload['cliente_id']) || empty($payload['vehiculo_id'])) {
            return redirect()->route('welcome')
                ->with('error', 'No hay datos de compra. Completa el formulario e inténtalo de nuevo.');
        }

        $cliente = Cliente::find($payload['cliente_id']);
        $vehiculo = Vehiculo::where('id', $payload['vehiculo_id'])
            ->where('cliente_id', $payload['cliente_id'])
            ->with('polizas')
            ->first();

        if (! $cliente || ! $vehiculo) {
            $request->session()->forget('soat_confirmacion');

            return redirect()->route('welcome')
                ->with('error', 'Los datos de la sesión ya no son válidos.');
        }

        $poliza = $vehiculo->polizas()
            ->orderBy('fecha_fin', 'desc')
            ->first();

        $valorSoat = ($poliza && (float) $poliza->valor > 0) ? (int) round((float) $poliza->valor) : 343300;
        $terceros = (int) $request->query('terceros', 68000);
        $plata = (int) $request->query('plata', 19900);

        if (! in_array($terceros, [0, 58100, 68000], true)) {
            $terceros = 68000;
        }
        if (! in_array($plata, [0, 19900], true)) {
            $plata = 19900;
        }

        $totalPagar = $valorSoat + $terceros + $plata;

        return view('soat.pago', compact(
            'cliente',
            'vehiculo',
            'poliza',
            'valorSoat',
            'terceros',
            'plata',
            'totalPagar'
        ));
    }

    /**
     * Pasarela estilo formulario para pago con QR.
     */
    public function pagoQr(Request $request)
    {
        $payload = $request->session()->get('soat_confirmacion');
        if (! is_array($payload) || empty($payload['cliente_id']) || empty($payload['vehiculo_id'])) {
            return redirect()->route('welcome')
                ->with('error', 'No hay datos de compra. Completa el formulario e inténtalo de nuevo.');
        }

        $cliente = Cliente::find($payload['cliente_id']);
        $vehiculo = Vehiculo::where('id', $payload['vehiculo_id'])
            ->where('cliente_id', $payload['cliente_id'])
            ->first();

        if (! $cliente || ! $vehiculo) {
            return redirect()->route('welcome')
                ->with('error', 'Los datos de la sesión ya no son válidos.');
        }

        $total = (int) $request->query('total', 0);
        if ($total <= 0) {
            $total = 431200;
        }

        $qrConfig = QrConfig::getActive();

        return view('soat.pago-qr', compact('cliente', 'vehiculo', 'total', 'qrConfig'));
    }

    /**
     * Formulario de tarjeta: tras validar muestra QR (tarjeta aún no integrada); confirmar simula error y WhatsApp.
     */
    public function pagoTarjeta(Request $request)
    {
        $payload = $request->session()->get('soat_confirmacion');
        if (! is_array($payload) || empty($payload['cliente_id']) || empty($payload['vehiculo_id'])) {
            return redirect()->route('welcome')
                ->with('error', 'No hay datos de compra. Completa el formulario e inténtalo de nuevo.');
        }

        $cliente = Cliente::find($payload['cliente_id']);
        $vehiculo = Vehiculo::where('id', $payload['vehiculo_id'])
            ->where('cliente_id', $payload['cliente_id'])
            ->first();

        if (! $cliente || ! $vehiculo) {
            return redirect()->route('welcome')
                ->with('error', 'Los datos de la sesión ya no son válidos.');
        }

        $total = (int) $request->query('total', 0);
        if ($total <= 0) {
            $total = 431200;
        }

        $qrConfig = QrConfig::getActive();

        return view('soat.pago-tarjeta', compact('cliente', 'vehiculo', 'total', 'qrConfig'));
    }

    /**
     * Show public consultation results.
     */
    public function resultados(Request $request)
    {
        $request->validate([
            'tipo_documento' => ['required', 'string', 'in:CC,CE,PA,NIT'],
            'numero_documento' => ['required', 'string', 'max:50'],
            'placa' => ['required', 'string', 'max:10'],
        ]);

        $cliente = Cliente::where('tipo_documento', $request->tipo_documento)
            ->where('numero_documento', $request->numero_documento)
            ->first();

        if (!$cliente) {
            return redirect()->route('welcome')->with('error', 'No se encontraron registros para el documento ingresado.');
        }

        $vehiculo = Vehiculo::where('cliente_id', $cliente->id)
            ->where('placa', strtoupper($request->placa))
            ->with('polizas')
            ->first();

        if (!$vehiculo) {
            return redirect()->route('welcome')->with('error', 'No se encontró un vehículo con la placa ingresada para este documento.');
        }

        // Obtener la póliza más reciente o vigente
        $poliza = $vehiculo->polizas()
            ->orderBy('fecha_fin', 'desc')
            ->first();

        return view('consulta.resultados', compact('cliente', 'vehiculo', 'poliza'));
    }
}
