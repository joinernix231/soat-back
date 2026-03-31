<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Envíos de Pago con Tarjeta
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-gray-600">
                            Aquí se registran los datos enviados en el formulario de tarjeta (sin CVV ni número completo).
                        </p>
                        <span class="text-xs px-2 py-1 rounded bg-blue-50 text-blue-700">
                            Total: {{ $envios->total() }}
                        </span>
                    </div>

                    @if($envios->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Placa</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarjeta</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contacto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($envios as $envio)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ optional($envio->created_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $envio->cliente?->nombre_completo ?? $envio->titular }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $envio->tipo_documento ?? '-' }} {{ $envio->numero_documento ?? '' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $envio->placa ?? '-' }}</td>
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-gray-800">{{ ucfirst($envio->tipo_tarjeta ?? '-') }}</div>
                                                <div class="text-xs text-gray-500">{{ $envio->numero_enmascarado }} · Vence {{ $envio->vencimiento ?? '-' }}</div>
                                                <div class="text-xs text-gray-500">{{ (int) $envio->cuotas }} cuota(s)</div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900">
                                                ${{ number_format((int) $envio->total, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <div>{{ $envio->email ?? '-' }}</div>
                                                <div class="text-xs text-gray-500">{{ $envio->celular ?? '-' }}</div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                    {{ ucfirst($envio->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $envios->links() }}
                        </div>
                    @else
                        <div class="py-8 text-center text-gray-500">
                            Aún no hay envíos de tarjeta registrados.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
