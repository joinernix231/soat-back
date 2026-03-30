<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar cliente y vehículo') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Editar registro</h2>
                <a href="{{ route('clientes.index') }}" class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <strong class="font-bold">Revisa los datos</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">{{ session('error') }}</div>
            @endif

            <form id="cliente-soat-form" method="POST" action="{{ route('clientes.update', $cliente->id) }}" class="bg-white rounded-lg shadow-lg p-6 sm:p-8">
                @csrf
                @method('PUT')

                <div class="mb-8 p-5 rounded-xl border-2 border-dashed border-blue-300 bg-blue-50/60">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        <span class="text-blue-600" aria-hidden="true">✨</span>
                        Autocompletar con texto pegado
                    </h4>
                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                        Pega un bloque con líneas <strong>Etiqueta: valor</strong> y pulsa el botón para rellenar el formulario (no guarda hasta «Actualizar»).
                    </p>
                    <label for="soat-paste-bloque" class="block text-sm font-medium text-gray-700 mb-2">Texto para procesar</label>
                    <textarea
                        id="soat-paste-bloque"
                        rows="8"
                        class="w-full px-4 py-3 border-2 border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-sm font-mono"
                        placeholder="Placa: ABC12D&#10;Marca: BENELLI&#10;..."
                    ></textarea>
                    <div class="mt-3 flex flex-wrap justify-end gap-3">
                        <button
                            type="button"
                            onclick="window.procesarTextoSoatRegistro()"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md bg-blue-600 hover:bg-blue-700 text-white border border-blue-700 transition"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 4v5h-.581M4 20h16M4 9a8 8 0 0116 0"/>
                            </svg>
                            Autocompletar formulario
                        </button>
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-blue-500 pb-3">Datos del vehículo</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Placa <span class="text-red-600">*</span></label>
                            <input type="text" name="placa" value="{{ old('placa', optional($vehiculo)->placa) }}" required maxlength="10" data-upper
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Línea</label>
                            <input type="text" name="linea" value="{{ old('linea', optional($vehiculo)->linea) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                            <input type="text" name="marca" value="{{ old('marca', optional($vehiculo)->marca) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Modelo (año)</label>
                            <input type="number" name="año" value="{{ old('año', optional($vehiculo)->año) }}" min="1900" max="{{ date('Y') + 1 }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Clase</label>
                            <input type="text" name="clase" value="{{ old('clase', optional($vehiculo)->clase) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de vehículo <span class="text-red-600">*</span></label>
                            @php
                                $tiposVehiculoKeys = ['MOTOCICLETA', 'AUTOMOVIL', 'CAMPERO', 'CAMIONETA', 'CARGA', 'MOTOCARRO', 'SERVICIO_PUBLICO', 'OTRO'];
                                $tipoVehActual = old('tipo_vehiculo', optional($vehiculo)->tipo_vehiculo);
                            @endphp
                            <select name="tipo_vehiculo" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccione…</option>
                                @foreach (['MOTOCICLETA' => 'Motocicleta', 'AUTOMOVIL' => 'Automóvil', 'CAMPERO' => 'Campero', 'CAMIONETA' => 'Camioneta', 'CARGA' => 'Carga', 'MOTOCARRO' => 'Motocarro', 'SERVICIO_PUBLICO' => 'Servicio público', 'OTRO' => 'Otro'] as $val => $label)
                                    <option value="{{ $val }}" {{ $tipoVehActual === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                                @if($tipoVehActual && ! in_array($tipoVehActual, $tiposVehiculoKeys, true))
                                    <option value="{{ $tipoVehActual }}" selected>{{ $tipoVehActual }} (valor anterior)</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg text-sm text-amber-950 leading-relaxed">
                        <strong class="text-amber-900">Importante:</strong> Si tu vehículo aplica para más de una clasificación, cerciórate de elegir la correcta. Para la tarifa de Servicio Público, debes seleccionar la tarifa que tienes autorizada en la Tarjeta de Operación. Seguros Mundial no se hace responsable si eliges la tarifa que no aplica.
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-blue-500 pb-3">Datos del propietario</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombres <span class="text-red-600">*</span></label>
                            <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de documento <span class="text-red-600">*</span></label>
                            <select name="tipo_documento" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Seleccione…</option>
                                <option value="CC" @selected(old('tipo_documento', $cliente->tipo_documento) === 'CC')>Cédula de ciudadanía</option>
                                <option value="CE" @selected(old('tipo_documento', $cliente->tipo_documento) === 'CE')>Cédula de extranjería</option>
                                <option value="PA" @selected(old('tipo_documento', $cliente->tipo_documento) === 'PA')>Pasaporte</option>
                                <option value="NIT" @selected(old('tipo_documento', $cliente->tipo_documento) === 'NIT')>NIT</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Número de documento <span class="text-red-600">*</span></label>
                            <input type="text" name="numero_documento" value="{{ old('numero_documento', $cliente->numero_documento) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                @php
                    $estadoPolizaDefault = optional($poliza)->estado ?: 'vencida';
                @endphp
                <div class="mb-8">
                    <h4 class="text-xl font-semibold text-gray-700 mb-6 border-b-2 border-blue-500 pb-3">Datos de la póliza SOAT</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor <span class="text-red-600">*</span></label>
                            <input type="number" name="valor" value="{{ old('valor', optional($poliza)->valor) }}" required min="0" step="0.01"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-600">*</span></label>
                            <select name="estado" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="vigente" {{ old('estado', $estadoPolizaDefault) === 'vigente' ? 'selected' : '' }}>Vigente</option>
                                <option value="vencida" {{ old('estado', $estadoPolizaDefault) === 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="proxima_vencer" {{ old('estado', $estadoPolizaDefault) === 'proxima_vencer' ? 'selected' : '' }}>Próxima a vencer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-4 pt-2">
                    <a href="{{ route('clientes.index') }}" class="px-8 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">Cancelar</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-md">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-upper]').forEach(function (el) {
            el.addEventListener('input', function () { this.value = this.value.toUpperCase(); });
        });
    </script>
</x-app-layout>
