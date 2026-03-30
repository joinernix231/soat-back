<?php

namespace App\Http\Controllers;

use App\Models\QrConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QrConfigController extends Controller
{
    /**
     * Muestra el formulario de configuración QR.
     */
    public function edit()
    {
        $config = QrConfig::getActive();

        return view('qr-config.edit', compact('config'));
    }

    /**
     * Actualiza la configuración QR.
     */
    public function update(Request $request)
    {
        $config = QrConfig::getActive();

        $validated = $request->validate([
            'nombre_comercio' => ['required', 'string', 'max:255'],
            'mensaje_pago' => ['nullable', 'string', 'max:1000'],
            'activo' => ['nullable', 'boolean'],
            'qr_imagen' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('qr_imagen')) {
            $destDir = public_path('images/qr');
            if (! File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }

            $file = $request->file('qr_imagen');
            $filename = 'qr-config-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destDir, $filename);

            $validated['qr_image_path'] = 'images/qr/' . $filename;
        }

        $validated['activo'] = $request->boolean('activo', true);

        $config->update($validated);

        return redirect()
            ->route('qr-config.edit')
            ->with('success', 'Configuración QR actualizada correctamente.');
    }
}

