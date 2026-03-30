<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\PolizaSoat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('vehiculos.polizas')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'tipo_documento' => 'required|string|in:CC,CE,PA,NIT',
            'numero_documento' => 'required|string|max:50',
            'placa' => 'required|string|max:10|unique:vehiculos,placa',
            'linea' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'clase' => 'nullable|string|max:255',
            'año' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'tipo_vehiculo' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'estado' => 'required|string|in:vigente,vencida,proxima_vencer',
        ]);

        DB::beginTransaction();
        try {
            $cliente = Cliente::firstOrCreate(
                [
                    'tipo_documento' => $validated['tipo_documento'],
                    'numero_documento' => $validated['numero_documento'],
                ],
                [
                    'nombre' => $validated['nombre'],
                    'apellidos' => $validated['apellidos'] ?? null,
                ]
            );

            if (! $cliente->wasRecentlyCreated) {
                $cliente->update([
                    'nombre' => $validated['nombre'],
                    'apellidos' => $validated['apellidos'] ?? null,
                ]);
            }

            $vehiculo = Vehiculo::create([
                'cliente_id' => $cliente->id,
                'placa' => strtoupper($validated['placa']),
                'linea' => $validated['linea'] ?? null,
                'marca' => $validated['marca'] ?? null,
                'clase' => $validated['clase'] ?? null,
                'modelo' => null,
                'año' => $validated['año'] ?? null,
                'tipo_vehiculo' => $validated['tipo_vehiculo'],
            ]);

            [$fechaInicio, $fechaFin] = $this->fechasPolizaInternas();

            PolizaSoat::create([
                'vehiculo_id' => $vehiculo->id,
                'numero_poliza' => $this->generarNumeroPolizaInterno(),
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'valor' => $validated['valor'],
                'estado' => $validated['estado'],
                'aseguradora' => 'Seguros Mundial',
            ]);

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = Cliente::with('vehiculos.polizas')->findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::with('vehiculos.polizas')->findOrFail($id);
        $vehiculo = $cliente->vehiculos->first();
        $poliza = $vehiculo ? $vehiculo->polizas->first() : null;
        
        return view('clientes.edit', compact('cliente', 'vehiculo', 'poliza'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $vehiculo = $cliente->vehiculos->first();
        $poliza = $vehiculo ? $vehiculo->polizas->first() : null;

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'tipo_documento' => 'required|string|in:CC,CE,PA,NIT',
            'numero_documento' => 'required|string|max:50',
            'placa' => [
                'required',
                'string',
                'max:10',
                Rule::unique('vehiculos', 'placa')->ignore(optional($vehiculo)->id),
            ],
            'linea' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'clase' => 'nullable|string|max:255',
            'año' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'tipo_vehiculo' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'estado' => 'required|string|in:vigente,vencida,proxima_vencer',
        ]);

        DB::beginTransaction();
        try {
            // Actualizar cliente
            $cliente->update([
                'nombre' => $validated['nombre'],
                'apellidos' => $validated['apellidos'] ?? null,
                'tipo_documento' => $validated['tipo_documento'],
                'numero_documento' => $validated['numero_documento'],
            ]);

            if ($vehiculo) {
                $vehiculo->update([
                    'placa' => strtoupper($validated['placa']),
                    'linea' => $validated['linea'] ?? null,
                    'marca' => $validated['marca'] ?? null,
                    'clase' => $validated['clase'] ?? null,
                    'año' => $validated['año'] ?? null,
                    'tipo_vehiculo' => $validated['tipo_vehiculo'],
                ]);
            } else {
                $vehiculo = Vehiculo::create([
                    'cliente_id' => $cliente->id,
                    'placa' => strtoupper($validated['placa']),
                    'linea' => $validated['linea'] ?? null,
                    'marca' => $validated['marca'] ?? null,
                    'clase' => $validated['clase'] ?? null,
                    'modelo' => null,
                    'año' => $validated['año'] ?? null,
                    'tipo_vehiculo' => $validated['tipo_vehiculo'],
                ]);
            }

            if ($poliza) {
                $poliza->update([
                    'valor' => $validated['valor'],
                    'estado' => $validated['estado'],
                ]);
            } else {
                [$fechaInicio, $fechaFin] = $this->fechasPolizaInternas();
                PolizaSoat::create([
                    'vehiculo_id' => $vehiculo->id,
                    'numero_poliza' => $this->generarNumeroPolizaInterno(),
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'valor' => $validated['valor'],
                    'estado' => $validated['estado'],
                    'aseguradora' => 'Seguros Mundial',
                ]);
            }

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Rango de fechas solo para cumplir el esquema (formulario ya no los pide).
     */
    private function fechasPolizaInternas(): array
    {
        $fin = Carbon::yesterday()->toDateString();
        $inicio = Carbon::yesterday()->subYear()->toDateString();

        return [$inicio, $fin];
    }

    private function generarNumeroPolizaInterno(): string
    {
        return 'INT-' . preg_replace('/\W/', '', uniqid('', true));
    }
}
