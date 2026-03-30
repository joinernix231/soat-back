<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Información del Cliente</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Editar
                            </a>
                            <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Volver
                            </a>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-4 border-b pb-2">Datos del propietario</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nombre completo</label>
                                <p class="text-lg font-semibold">{{ $cliente->nombre_completo }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tipo de Documento</label>
                                <p class="text-lg font-semibold">{{ $cliente->tipo_documento }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Número de Documento</label>
                                <p class="text-lg font-semibold">{{ $cliente->numero_documento }}</p>
                            </div>
                        </div>
                    </div>

                    @foreach($cliente->vehiculos as $vehiculo)
                        <div class="mb-6 border-t pt-6">
                            <h4 class="text-lg font-semibold mb-4">Vehículo: {{ $vehiculo->placa }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                @if($vehiculo->linea)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Línea</label>
                                    <p class="font-semibold">{{ $vehiculo->linea }}</p>
                                </div>
                                @endif
                                @if($vehiculo->marca)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Marca</label>
                                    <p class="font-semibold">{{ $vehiculo->marca }}</p>
                                </div>
                                @endif
                                @if($vehiculo->año)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Modelo (año)</label>
                                    <p class="font-semibold">{{ $vehiculo->año }}</p>
                                </div>
                                @endif
                                @if($vehiculo->clase)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Clase</label>
                                    <p class="font-semibold">{{ $vehiculo->clase }}</p>
                                </div>
                                @endif
                                @if($vehiculo->tipo_vehiculo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tipo de vehículo</label>
                                    <p class="font-semibold">{{ str_replace('_', ' ', $vehiculo->tipo_vehiculo) }}</p>
                                </div>
                                @endif
                                @if($vehiculo->modelo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Referencia modelo</label>
                                    <p class="font-semibold">{{ $vehiculo->modelo }}</p>
                                </div>
                                @endif
                            </div>

                            @if($vehiculo->polizas->count() > 0)
                                <h5 class="text-md font-semibold mb-3">Pólizas SOAT</h5>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Número de Póliza</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Fin</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aseguradora</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($vehiculo->polizas as $poliza)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $poliza->numero_poliza }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $poliza->fecha_inicio->format('d/m/Y') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $poliza->fecha_fin->format('d/m/Y') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">${{ number_format($poliza->valor, 0, ',', '.') }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            @if($poliza->estado == 'vigente') bg-green-100 text-green-800
                                                            @elseif($poliza->estado == 'vencida') bg-red-100 text-red-800
                                                            @else bg-yellow-100 text-yellow-800
                                                            @endif">
                                                            {{ ucfirst(str_replace('_', ' ', $poliza->estado)) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $poliza->aseguradora }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">No hay pólizas registradas para este vehículo.</p>
                            @endif
                        </div>
                    @endforeach

                    @if($cliente->vehiculos->count() == 0)
                        <p class="text-gray-500">No hay vehículos registrados para este cliente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




