<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuración de Pago QR') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-300 bg-red-50 text-red-800 px-4 py-3">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('qr-config.update') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del comercio</label>
                    <input
                        type="text"
                        name="nombre_comercio"
                        value="{{ old('nombre_comercio', $config->nombre_comercio) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje de pago (opcional)</label>
                    <textarea
                        name="mensaje_pago"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >{{ old('mensaje_pago', $config->mensaje_pago) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen QR (PNG/JPG/WebP)</label>
                    <input
                        type="file"
                        name="qr_imagen"
                        accept="image/*"
                        class="w-full text-sm text-gray-700"
                    >
                    @if($config->qr_image_path)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">QR actual</p>
                            <img src="{{ asset($config->qr_image_path) }}" alt="QR actual" class="w-48 h-48 object-contain border rounded bg-white p-2">
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        id="activo"
                        name="activo"
                        value="1"
                        {{ old('activo', $config->activo) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    >
                    <label for="activo" class="text-sm text-gray-700">Configuración activa</label>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                    >
                        Guardar configuración QR
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

