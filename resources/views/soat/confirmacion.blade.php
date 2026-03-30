<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirma tus datos — Seguros Mundial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @php
        $tiposVehiculo = [
            'MOTOCICLETA' => 'MOTOCICLETA',
            'AUTOMOVIL' => 'AUTOMOVIL',
            'CAMPERO' => 'CAMPERO',
            'CAMIONETA' => 'CAMIONETA',
            'CARGA' => 'CARGA',
            'MOTOCARRO' => 'MOTOCARRO',
            'SERVICIO_PUBLICO' => 'SERVICIO PÚBLICO',
            'OTRO' => 'OTRO',
        ];
        $tipoVehCodigo = $vehiculo->tipo_vehiculo ?: 'MOTOCICLETA';
        $tipoVehEtiqueta = $tiposVehiculo[$tipoVehCodigo] ?? str_replace('_', ' ', $tipoVehCodigo);
        $valorSoat = ($poliza && (float) $poliza->valor > 0) ? (float) $poliza->valor : 343300;
        $tercerosOpc1 = 58100;
        $tercerosOpc2 = 68000;
        $planPlata = 19900;
        $totalCompra = $valorSoat + $tercerosOpc2 + $planPlata;
        $whatsAppJoinerUrl = 'https://api.whatsapp.com/send?phone=573219127738&text='
            . rawurlencode('Hola Joiner, quiero saber mas de esta poliza SOAT.');
    @endphp
    <style>
        :root {
            --sm-teal: #008a95;
            --sm-teal-dark: #006b74;
            --sm-azure: #009fe3;
            --sm-mint: #87e5c0;
            --sm-mint-hover: #6fd9b0;
            --sm-bg: #f8f9fa;
            --sm-card-head: #e8eef2;
            --sm-text: #1a2b2e;
            --sm-muted: #5a6d70;
            --sm-border: #dde5e8;
            --sm-white: #fff;
            --sm-link: #008a95;
            --sm-disclaimer: #009fe3;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body.sm-confirm-page {
            font-family: 'Open Sans', 'Montserrat', -apple-system, sans-serif;
            background: var(--sm-bg);
            color: var(--sm-text);
            min-height: 100vh;
            font-size: 15px;
            line-height: 1.5;
        }
        .sm-topbar {
            background: #2c3e50;
            padding: 0.45rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }
        .sm-topbar button {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            padding: 0.35rem 0.85rem;
            border-radius: 4px;
            font-size: 0.85rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .sm-header {
            background: var(--sm-white);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 0.85rem 1.5rem;
        }
        .sm-header-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .sm-logo {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: var(--sm-teal);
        }
        .sm-logo-img {
            display: block;
            height: 48px;
            width: auto;
            max-width: min(280px, 55vw);
            object-fit: contain;
        }
        .sm-nav-actions {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            flex-wrap: wrap;
        }
        .sm-nav-dropdown {
            border: 1px solid var(--sm-border);
            background: var(--sm-white);
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--sm-teal);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .sm-btn-renovar {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            padding: 0.65rem 1rem;
            border: none;
            border-radius: 999px;
            background: var(--sm-mint);
            color: #0d3d35;
            cursor: pointer;
            white-space: nowrap;
        }
        .sm-btn-renovar:hover { background: var(--sm-mint-hover); }
        .sm-main {
            max-width: 1180px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }
        .sm-page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.35rem, 3vw, 1.75rem);
            font-weight: 700;
            color: var(--sm-teal);
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.25;
        }
        .sm-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.75rem;
            align-items: start;
        }
        @media (max-width: 960px) {
            .sm-layout { grid-template-columns: 1fr; }
        }
        .sm-card {
            background: var(--sm-white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #eef2f4;
            margin-bottom: 1.25rem;
        }
        .sm-card-h {
            background: var(--sm-card-head);
            padding: 0.65rem 1.15rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--sm-teal);
            border-bottom: 1px solid var(--sm-border);
        }
        .sm-card-b { padding: 1.15rem 1.25rem 1.25rem; }
        .sm-dl { display: grid; gap: 0.65rem 1rem; }
        .sm-dl-row {
            display: grid;
            grid-template-columns: minmax(130px, 38%) 1fr;
            gap: 0.5rem;
            font-size: 0.92rem;
        }
        @media (max-width: 480px) {
            .sm-dl-row { grid-template-columns: 1fr; }
        }
        .sm-dl-row dt {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--sm-teal);
        }
        .sm-dl-row dd { color: var(--sm-text); font-weight: 400; }
        .sm-radio-block { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eef2f4; }
        .sm-radio-line {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: var(--sm-teal);
            font-size: 0.9rem;
        }
        .sm-radio-line input { accent-color: var(--sm-teal); width: 1.05rem; height: 1.05rem; }
        .sm-disclaimer {
            margin-top: 1rem;
            font-size: 0.72rem;
            line-height: 1.45;
            color: var(--sm-disclaimer);
        }
        .sm-input-label {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.82rem;
            color: var(--sm-teal);
            margin: 0.85rem 0 0.35rem;
        }
        .sm-input-label:first-of-type { margin-top: 0.25rem; }
        .sm-input {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1px solid var(--sm-border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
        }
        .sm-input:focus {
            outline: none;
            border-color: var(--sm-azure);
            box-shadow: 0 0 0 3px rgba(0, 159, 227, 0.15);
        }
        .sm-link-back {
            display: inline-block;
            margin-top: 1rem;
            color: var(--sm-link);
            font-weight: 600;
            font-size: 0.92rem;
            text-decoration: none;
        }
        .sm-link-back:hover { text-decoration: underline; }
        .sm-upsell-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--sm-teal);
            margin-bottom: 0.75rem;
        }
        .sm-option {
            border: none;
            border-radius: 0;
            padding: 0.5rem 0;
            margin-bottom: 0.4rem;
            background: transparent;
        }
        .sm-option-head {
            display: flex;
            align-items: flex-start;
            gap: 0.45rem;
            font-weight: 600;
            color: var(--sm-text);
            font-size: 0.98rem;
            line-height: 1.25;
        }
        .sm-option-head input {
            margin-top: 0.2rem;
            accent-color: var(--sm-teal);
            width: 22px;
            height: 22px;
        }
        .sm-option small {
            display: block;
            margin-top: 0.1rem;
            font-size: 0.86rem;
            color: #3f4d54;
            font-weight: 400;
            line-height: 1.25;
            padding-left: 2.1rem;
        }
        .sm-mas-info {
            display: inline-block;
            margin-top: 0.95rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--sm-link);
            text-decoration: none;
        }
        .sm-mas-info:hover { text-decoration: underline; }
        .sm-protect-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #0a6f9a;
            background: #eceff3;
            padding: 0.7rem 0.85rem;
            border: 1px solid #dbe3e8;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            font-size: 0.9rem;
        }
        .sm-protect-card {
            border: 1px solid #dbe3e8;
            border-radius: 0 0 10px 10px;
            padding: 0.95rem 1.05rem 1.1rem;
            background: #fff;
        }
        .sm-protect-subtitle {
            text-align: center;
            color: #0a6f9a;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.82rem;
            line-height: 1.2;
            margin-bottom: 0.9rem;
        }
        .sm-protect-highlight {
            text-align: center;
            color: #0092d1;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.75rem;
            margin: 0.35rem 0 0.85rem;
        }
        .sm-option-price {
            font-weight: 700;
        }
        .sm-resumen {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eef2f4;
            margin-top: 1.25rem;
            background: var(--sm-white);
        }
        .sm-resumen-h {
            background: var(--sm-azure);
            color: #fff;
            padding: 0.65rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .sm-resumen-toggle {
            background: none;
            border: none;
            color: #fff;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: underline;
        }
        .sm-resumen-body { padding: 1rem 1.1rem 1.15rem; }
        .sm-res-line {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 0.4rem 0;
            font-size: 0.9rem;
        }
        .sm-res-line .lbl { color: var(--sm-text); }
        .sm-res-line .val { font-weight: 600; }
        .sm-res-extra .lbl::before {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #e53935;
            margin-right: 0.4rem;
            vertical-align: middle;
        }
        .sm-res-right {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }
        .sm-btn-remove {
            width: 22px;
            height: 22px;
            border: none;
            border-radius: 999px;
            background: #f50045;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
        }
        .sm-btn-remove svg { width: 12px; height: 12px; }
        .sm-btn-remove:hover { filter: brightness(0.92); }
        .sm-res-line.removed { opacity: 0.55; }
        .sm-res-line.removed .lbl,
        .sm-res-line.removed .val { text-decoration: line-through; }
        .sm-total-row {
            margin-top: 0.75rem;
            padding-top: 0.85rem;
            border-top: 2px solid var(--sm-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sm-total-row .lbl {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--sm-teal);
        }
        .sm-total-row .val {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.35rem;
            color: var(--sm-text);
        }
        .sm-footer-actions {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 1.25rem 2.5rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
        }
        .sm-btn-siguiente {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.95rem 2.75rem;
            border: none;
            border-radius: 999px;
            background: var(--sm-mint);
            color: #0d3d35;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(135, 229, 192, 0.45);
        }
        .sm-btn-siguiente:hover { background: var(--sm-mint-hover); }
    </style>
</head>
<body class="sm-confirm-page">
    <div class="sm-topbar">
        <button type="button" aria-label="Ayuda">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9 9a3 3 0 1 1 5.5 2c0 2-3 3-3 3M12 17h.01"/></svg>
            Ayudas
        </button>
        <button type="button" aria-label="Contacto">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/><polyline points="22,6 12,13 2,6"/></svg>
            Contacto
        </button>
    </div>
    <header class="sm-header">
        <div class="sm-header-inner">
            <a href="{{ route('welcome') }}" class="sm-logo">
                <img
                    src="{{ asset('images/logos/seguros-mundial-logo.webp') }}"
                    alt="Seguros Mundial"
                    class="sm-logo-img"
                    width="304"
                    height="68"
                    decoding="async"
                >
            </a>
            <div class="sm-nav-actions">
                <button type="button" class="sm-nav-dropdown" aria-haspopup="true">
                    SOAT
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <button type="button" class="sm-btn-renovar">Quiero renovar mi SOAT</button>
            </div>
        </div>
    </header>

    <main class="sm-main">
        <h1 class="sm-page-title">Confirma tus datos y los de tu nave</h1>

        <div class="sm-layout">
            <div class="sm-col-left">
                <article class="sm-card">
                    <div class="sm-card-h">Datos de tu nave</div>
                    <div class="sm-card-b">
                        <dl class="sm-dl">
                            <div class="sm-dl-row"><dt>Placa</dt><dd>{{ $vehiculo->placa }}</dd></div>
                            <div class="sm-dl-row"><dt>Línea</dt><dd>{{ $vehiculo->linea ?: '—' }}</dd></div>
                            <div class="sm-dl-row"><dt>Marca</dt><dd>{{ $vehiculo->marca ?: '—' }}</dd></div>
                            <div class="sm-dl-row"><dt>Modelo</dt><dd>{{ $vehiculo->año ?: '—' }}</dd></div>
                            <div class="sm-dl-row"><dt>Clase</dt><dd>{{ $vehiculo->clase ?: '—' }}</dd></div>
                        </dl>
                        <div class="sm-radio-block">
                            <div class="sm-upsell-title" style="margin-bottom:0.5rem;font-size:0.88rem;">Tipo de vehículo</div>
                            <label class="sm-radio-line">
                                <input type="radio" name="tipo_veh_display" checked disabled>
                                {{ $tipoVehEtiqueta }}
                            </label>
                        </div>
                        <p class="sm-disclaimer">
                            *Si tu vehículo aplica para más de una clasificación, cerciórate de elegir la correcta. Para la tarifa de Servicio Público, debes seleccionar la tarifa que tienes autorizada en la Tarjeta de Operación. Seguros Mundial no se hace responsable si eliges la tarifa que no aplica.
                        </p>
                    </div>
                </article>

                <article class="sm-card">
                    <div class="sm-card-h">Datos del propietario</div>
                    <div class="sm-card-b">
                        <dl class="sm-dl">
                            <div class="sm-dl-row"><dt>Nombres</dt><dd>{{ $cliente->nombre }}</dd></div>
                            <div class="sm-dl-row"><dt>Apellidos</dt><dd>{{ $cliente->apellidos ?: '—' }}</dd></div>
                            <div class="sm-dl-row"><dt>Número de Documento</dt><dd>{{ $cliente->numero_documento }}</dd></div>
                        </dl>
                        <label class="sm-input-label" for="sm-tel">Teléfono</label>
                        <input class="sm-input" type="tel" id="sm-tel" name="telefono" placeholder="Escribe tu teléfono celular" autocomplete="tel">
                        <label class="sm-input-label" for="sm-mail">Correo electrónico</label>
                        <input class="sm-input" type="email" id="sm-mail" name="correo" placeholder="Escribe tu correo electrónico" autocomplete="email">
                    </div>
                </article>

                <a href="{{ route('welcome') }}" class="sm-link-back">Regresar</a>
            </div>

            <div class="sm-col-right">
                <div style="margin-bottom:1rem;">
                    <div class="sm-protect-header">
                        <span>Seguro para daños a terceros</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0a6f9a" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </div>
                    <div class="sm-protect-card">
                        <p class="sm-protect-subtitle">Cubrimos los daños materiales causados a terceros en accidentes de tránsito (choque simple)</p>
                        <p class="sm-protect-highlight">No importa qué nave tengas!</p>
                        <label class="sm-option">
                            <div class="sm-option-head">
                                <input type="radio" name="terceros" value="58100" data-precio="{{ $tercerosOpc1 }}">
                                <span>
                                    Opción Motos 1 (<span class="sm-option-price">${{ number_format($tercerosOpc1, 0, ',', '.') }} cobertura anual</span>): Valor asegurado de hasta <span class="sm-option-price">$ 10.000.000</span>, amparo patrimonial y daños a bienes de terceros.
                                </span>
                            </div>
                        </label>
                        <label class="sm-option">
                            <div class="sm-option-head">
                                <input type="radio" name="terceros" value="68000" data-precio="{{ $tercerosOpc2 }}" checked>
                                <span>
                                    Opción Motos 2 (<span class="sm-option-price">${{ number_format($tercerosOpc2, 0, ',', '.') }} cobertura anual</span>): Valor asegurado de hasta <span class="sm-option-price">$ 25.000.000</span>, amparo patrimonial y daños a bienes de terceros.
                                </span>
                            </div>
                        </label>
                        <a href="{{ $whatsAppJoinerUrl }}" target="_blank" rel="noopener noreferrer" class="sm-mas-info">Quiero saber más de esta póliza</a>
                    </div>
                </div>

                <div class="sm-card" style="margin-bottom:1rem;">
                    <div class="sm-card-b">
                        <div class="sm-upsell-title">¿Quieres ampliar tu cobertura?</div>
                        <label class="sm-option">
                            <div class="sm-option-head">
                                <input type="radio" name="plata" value="19900" data-precio="{{ $planPlata }}" checked>
                                PLAN PLATA: ${{ number_format($planPlata, 0, ',', '.') }} (cobertura anual)
                            </div>
                        </label>
                        <a href="{{ $whatsAppJoinerUrl }}" target="_blank" rel="noopener noreferrer" class="sm-mas-info">Quiero saber más de esta póliza</a>
                    </div>
                </div>

                <div class="sm-resumen" id="sm-resumen">
                    <div class="sm-resumen-h">
                        <span>Resumen de tu compra</span>
                        <button type="button" class="sm-resumen-toggle" id="sm-toggle-resumen">ver menos</button>
                    </div>
                    <div class="sm-resumen-body" id="sm-resumen-body">
                        <div class="sm-res-line">
                            <span class="lbl">Valor Soat</span>
                            <span class="val" id="line-soat">${{ number_format($valorSoat, 0, ',', '.') }}</span>
                        </div>
                        <div class="sm-res-line sm-res-extra" id="row-terceros">
                            <span class="lbl">Seguro Tercero Voluntario</span>
                            <span class="sm-res-right">
                                <span class="val" id="line-terceros">${{ number_format($tercerosOpc2, 0, ',', '.') }}</span>
                                <button type="button" class="sm-btn-remove" id="btn-remove-terceros" aria-label="Quitar Seguro Tercero Voluntario" title="Quitar">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"></path>
                                        <path d="M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="sm-res-line sm-res-extra" id="row-plata">
                            <span class="lbl">Póliza de Accidente Personales complementaria</span>
                            <span class="sm-res-right">
                                <span class="val" id="line-plata">${{ number_format($planPlata, 0, ',', '.') }}</span>
                                <button type="button" class="sm-btn-remove" id="btn-remove-plata" aria-label="Quitar Póliza complementaria" title="Quitar">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"></path>
                                        <path d="M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                        <div class="sm-total-row">
                            <span class="lbl">Total a pagar</span>
                            <span class="val" id="line-total">${{ number_format($totalCompra, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="sm-footer-actions">
        <button type="button" class="sm-btn-siguiente" id="sm-btn-siguiente">Siguiente</button>
    </div>

    <script>
        (function () {
            var baseSoat = {{ (int) round($valorSoat) }};
            var removed = { terceros: false, plata: false };

            function parseMoney(el) {
                if (!el || !el.checked) return 0;
                var p = el.getAttribute('data-precio');
                return p ? parseInt(p, 10) : 0;
            }
            function fmt(n) {
                return '$' + n.toLocaleString('es-CO', { maximumFractionDigits: 0 });
            }
            function setRemovedRow(type, isRemoved) {
                var rowId = type === 'terceros' ? 'row-terceros' : 'row-plata';
                var row = document.getElementById(rowId);
                if (row) row.classList.toggle('removed', !!isRemoved);
            }
            function recalc() {
                var t = document.querySelector('input[name="terceros"]:checked');
                var p = document.querySelector('input[name="plata"]:checked');
                var pt = removed.terceros ? 0 : parseMoney(t);
                var pp = removed.plata ? 0 : parseMoney(p);
                var total = baseSoat + pt + pp;
                var lt = document.getElementById('line-terceros');
                var lp = document.getElementById('line-plata');
                var tot = document.getElementById('line-total');
                if (lt) lt.textContent = fmt(pt);
                if (lp) lp.textContent = fmt(pp);
                if (tot) tot.textContent = fmt(total);
                setRemovedRow('terceros', removed.terceros);
                setRemovedRow('plata', removed.plata);
            }
            document.querySelectorAll('input[name="terceros"]').forEach(function (el) {
                el.addEventListener('change', function () {
                    removed.terceros = false;
                    recalc();
                });
            });
            document.querySelectorAll('input[name="plata"]').forEach(function (el) {
                el.addEventListener('change', function () {
                    removed.plata = false;
                    recalc();
                });
            });

            var btnRemoveTerceros = document.getElementById('btn-remove-terceros');
            var btnRemovePlata = document.getElementById('btn-remove-plata');
            if (btnRemoveTerceros) {
                btnRemoveTerceros.addEventListener('click', function () {
                    removed.terceros = true;
                    recalc();
                });
            }
            if (btnRemovePlata) {
                btnRemovePlata.addEventListener('click', function () {
                    removed.plata = true;
                    recalc();
                });
            }
            recalc();
            var toggle = document.getElementById('sm-toggle-resumen');
            var body = document.getElementById('sm-resumen-body');
            if (toggle && body) {
                toggle.addEventListener('click', function () {
                    var open = body.style.display !== 'none';
                    body.style.display = open ? 'none' : 'block';
                    toggle.textContent = open ? 'ver más' : 'ver menos';
                });
            }
            document.getElementById('sm-btn-siguiente').addEventListener('click', function () {
                var t = document.querySelector('input[name="terceros"]:checked');
                var p = document.querySelector('input[name="plata"]:checked');
                var pt = removed.terceros ? 0 : parseMoney(t);
                var pp = removed.plata ? 0 : parseMoney(p);
                var params = new URLSearchParams({
                    terceros: String(pt),
                    plata: String(pp)
                });
                window.location.href = @json(route('soat.pago')) + '?' + params.toString();
            });
        })();
    </script>
</body>
</html>
