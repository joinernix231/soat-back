<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Consulta SOAT - SOAT Mundial</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }
        .header-soat {
            background: linear-gradient(135deg, #003087 0%, #0046a8 100%);
            padding: 1.5em 1em;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .logo-section h1 {
            color: white;
            margin: 0;
            font-size: 1.5em;
        }
        .header-contacts {
            display: flex;
            gap: 2em;
            color: white;
            font-size: 0.95em;
        }
        .header-contacts a {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }
        .container {
            max-width: 1000px;
            margin: 2em auto;
            padding: 0 1em;
        }
        .result-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 2em;
            margin-bottom: 1.5em;
        }
        .result-card h2 {
            color: #003087;
            margin-top: 0;
            margin-bottom: 1.5em;
            font-size: 1.8em;
            border-bottom: 2px solid #003087;
            padding-bottom: 0.5em;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5em;
            margin-bottom: 1.5em;
        }
        .info-item {
            padding: 1em;
            background: #f8f9fa;
            border-radius: 6px;
        }
        .info-item label {
            display: block;
            font-weight: 600;
            color: #666;
            font-size: 0.85em;
            margin-bottom: 0.5em;
            text-transform: uppercase;
        }
        .info-item .value {
            font-size: 1.1em;
            color: #333;
            font-weight: 600;
        }
        .poliza-status {
            display: inline-block;
            padding: 0.5em 1em;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
        }
        .status-vigente {
            background: #d4edda;
            color: #155724;
        }
        .status-vencida {
            background: #f8d7da;
            color: #721c24;
        }
        .status-proxima {
            background: #fff3cd;
            color: #856404;
        }
        .btn-back {
            display: inline-block;
            padding: 0.75em 2em;
            background: #003087;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #0046a8;
        }
        .no-results {
            text-align: center;
            padding: 3em;
            color: #666;
        }
        .footer-soat {
            background: #003087;
            color: white;
            padding: 2em 1em;
            margin-top: 3em;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2em;
            margin-bottom: 1em;
            flex-wrap: wrap;
        }
        .footer-links a {
            color: white;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1em;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header-soat">
        <div class="header-content">
            <div class="logo-section">
                <h1>SOAT Mundial</h1>
            </div>
            <div class="header-contacts">
                <a href="{{ route('welcome') }}">Nueva Consulta</a>
            </div>
        </div>
    </header>

    <!-- Results Container -->
    <div class="container">
        @if($poliza)
            <!-- Información del Cliente -->
            <div class="result-card">
                <h2>Información del Cliente</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tipo de Documento</label>
                        <div class="value">{{ $cliente->tipo_documento }}</div>
                    </div>
                    <div class="info-item">
                        <label>Número de Documento</label>
                        <div class="value">{{ $cliente->numero_documento }}</div>
                    </div>
                    <div class="info-item">
                        <label>Nombre</label>
                        <div class="value">{{ $cliente->nombre_completo }}</div>
                    </div>
                </div>
            </div>

            <!-- Información del Vehículo -->
            <div class="result-card">
                <h2>Información del Vehículo</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Placa</label>
                        <div class="value">{{ $vehiculo->placa }}</div>
                    </div>
                    @if($vehiculo->marca)
                    <div class="info-item">
                        <label>Marca</label>
                        <div class="value">{{ $vehiculo->marca }}</div>
                    </div>
                    @endif
                    @if($vehiculo->modelo)
                    <div class="info-item">
                        <label>Modelo</label>
                        <div class="value">{{ $vehiculo->modelo }}</div>
                    </div>
                    @endif
                    @if($vehiculo->año)
                    <div class="info-item">
                        <label>Año</label>
                        <div class="value">{{ $vehiculo->año }}</div>
                    </div>
                    @endif
                    @if($vehiculo->tipo_vehiculo)
                    <div class="info-item">
                        <label>Tipo de Vehículo</label>
                        <div class="value">{{ $vehiculo->tipo_vehiculo }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Información de la Póliza SOAT -->
            <div class="result-card">
                <h2>Información de la Póliza SOAT</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Número de Póliza</label>
                        <div class="value">{{ $poliza->numero_poliza }}</div>
                    </div>
                    <div class="info-item">
                        <label>Fecha de Inicio</label>
                        <div class="value">{{ $poliza->fecha_inicio->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-item">
                        <label>Fecha de Fin</label>
                        <div class="value">{{ $poliza->fecha_fin->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-item">
                        <label>Valor de la Póliza</label>
                        <div class="value">${{ number_format($poliza->valor, 0, ',', '.') }}</div>
                    </div>
                    <div class="info-item">
                        <label>Estado</label>
                        <div class="value">
                            <span class="poliza-status status-{{ $poliza->estado }}">
                                @if($poliza->estado == 'vigente')
                                    Vigente
                                @elseif($poliza->estado == 'vencida')
                                    Vencida
                                @else
                                    Próxima a Vencer
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <label>Aseguradora</label>
                        <div class="value">{{ $poliza->aseguradora }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="result-card">
                <div class="no-results">
                    <h2>No se encontró póliza SOAT</h2>
                    <p>No se encontró una póliza SOAT activa para este vehículo.</p>
                </div>
            </div>
        @endif

        <div style="text-align: center; margin-top: 2em;">
            <a href="{{ route('welcome') }}" class="btn-back">Nueva Consulta</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-soat">
        <div class="footer-content">
            <div class="footer-links">
                <a href="{{ route('politica.privacidad') }}">Política de Privacidad</a>
                <a href="{{ route('terminos.condiciones') }}">Términos y Condiciones</a>
            </div>
            <p style="margin: 0; font-size: 0.9em;">© {{ date('Y') }} Seguros Mundial. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>




