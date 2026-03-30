<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pago SOAT - Seguros Mundial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @php
        $fechaInicio = $poliza && $poliza->fecha_inicio ? $poliza->fecha_inicio->format('d/m/Y') : now()->subYear()->format('d/m/Y');
        $fechaFin = $poliza && $poliza->fecha_fin ? $poliza->fecha_fin->format('d/m/Y') : now()->format('d/m/Y');
        $whatsPago = 'https://api.whatsapp.com/send?phone=573219127738&text='
            . rawurlencode('Hola, quiero continuar con el pago de mi SOAT.');
    @endphp
    <style>
        :root {
            --sm-text: #1f2b34;
            --sm-primary: #0f5f86;
            --sm-accent: #65e4b2;
            --sm-line: #dce3e7;
            --sm-bg: #f7f9fb;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--sm-text);
            background: var(--sm-bg);
        }
        .topbar {
            background: #2c3e50;
            padding: 0.45rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.6rem;
        }
        .topbar button {
            border: 1px solid rgba(255,255,255,0.35);
            background: transparent;
            color: #fff;
            border-radius: 12px;
            padding: 0.2rem 0.7rem;
            font-size: 0.78rem;
            font-weight: 700;
        }
        .header {
            background: #fff;
            border-top: 2px solid var(--sm-primary);
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 0.85rem 1.4rem;
        }
        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }
        .logo-image {
            display: block;
            width: auto;
            height: 44px;
            max-width: min(304px, 56vw);
            object-fit: contain;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .soat-menu {
            color: var(--sm-primary);
            font-size: 0.76rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .btn-renovar {
            background: var(--sm-accent);
            color: #0a3f36;
            border: none;
            border-radius: 999px;
            padding: 0.55rem 0.95rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.64rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
        }
        .container {
            max-width: 980px;
            margin: 1.4rem auto 2rem;
            padding: 0 1rem;
        }
        .card {
            background: #fff;
            border: 1px solid #ebeff2;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            padding: 1.25rem 1.35rem 1.4rem;
        }
        .title {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: var(--sm-primary);
            font-size: 1.02rem;
            font-weight: 700;
            margin-bottom: 0.95rem;
            line-height: 1.25;
        }
        .stepper {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            align-items: center;
            margin: 0 auto 1rem;
            max-width: 690px;
            column-gap: 0.6rem;
        }
        .step {
            text-align: center;
            position: relative;
        }
        .step::before {
            content: "";
            position: absolute;
            top: 12px;
            left: -48%;
            width: 96%;
            height: 1px;
            background: #cfd8dd;
        }
        .step:first-child::before { display: none; }
        .dot {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #2dd8a4;
            color: #0a4a3f;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.25rem;
        }
        .step-label {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.76rem;
            font-weight: 700;
            color: #234b63;
        }
        .grid-summary {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.2rem 1rem;
            font-size: 0.86rem;
            margin: 0.7rem 0 0.95rem;
        }
        .grid-summary .key { color: #2d4e60; font-weight: 700; }
        .grid-summary .value { color: #0c607f; font-weight: 700; text-align: right; }
        .total-row {
            margin-top: 0.45rem;
            border-top: 1px solid var(--sm-line);
            padding-top: 0.65rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-row .label {
            color: #0c607f;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.03rem;
        }
        .total-row .amount {
            color: #0c607f;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.65rem;
        }
        .pay-title {
            margin-top: 0.55rem;
            color: #0c607f;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
        }
        .pay-sub {
            font-size: 0.81rem;
            color: #266886;
            margin-bottom: 0.35rem;
            font-weight: 700;
        }
        .pay-option {
            border-top: 1px solid #e6ecef;
            padding: 0.62rem 0.15rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.86rem;
        }
        .pay-option strong { color: #23556f; }
        .pay-option input { accent-color: #1d9bcc; width: 15px; height: 15px; }
        .disclaimer {
            margin-top: 0.65rem;
            color: #4f6f7b;
            font-size: 0.67rem;
            line-height: 1.45;
        }
        .actions {
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-link {
            background: none;
            border: none;
            color: #1f4f69;
            text-decoration: underline;
            font-size: 0.86rem;
            cursor: pointer;
        }
        .btn-pagar {
            border: none;
            border-radius: 999px;
            background: var(--sm-accent);
            color: #0a3f36;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.7rem 1.45rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <button type="button">Ayuda</button>
        <button type="button">Contacto</button>
    </div>
    <header class="header">
        <div class="header-inner">
            <a href="{{ route('welcome') }}">
                <img
                    src="{{ asset('images/logos/seguros-mundial-logo.webp') }}"
                    alt="Seguros Mundial"
                    class="logo-image"
                    width="304"
                    height="68"
                >
            </a>
            <div class="header-right">
                <span class="soat-menu">SOAT</span>
                <button type="button" class="btn-renovar">Quiero renovar mi SOAT</button>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <h1 class="title">¡{{ strtoupper($cliente->nombre) }}!<br>ya puedes pagar tu SOAT</h1>

            <div class="stepper">
                <div class="step">
                    <span class="dot">1</span>
                    <div class="step-label">Cotiza</div>
                </div>
                <div class="step">
                    <span class="dot">2</span>
                    <div class="step-label">Resumen</div>
                </div>
                <div class="step">
                    <span class="dot">3</span>
                    <div class="step-label">Pago</div>
                </div>
            </div>

            <div class="grid-summary">
                <span class="key">Inicio de vigencia</span>
                <span class="value">{{ $fechaInicio }}</span>
                <span class="key">Final de vigencia</span>
                <span class="value">{{ $fechaFin }}</span>
                <span class="key">Tipo de vehículo</span>
                <span class="value">{{ str_replace('_', ' ', $vehiculo->tipo_vehiculo) }}</span>
                <span class="key">SOAT</span>
                <span class="value">${{ number_format($valorSoat, 0, ',', '.') }}</span>
                <span class="key">Seguro Ter-Cero (Opción Motos {{ $terceros === 58100 ? '1' : ($terceros === 68000 ? '2' : '-') }})</span>
                <span class="value">${{ number_format($terceros, 0, ',', '.') }}</span>
                <span class="key">Accidentes Personales (PLAN PLATA)</span>
                <span class="value">${{ number_format($plata, 0, ',', '.') }}</span>
            </div>

            <div class="total-row">
                <span class="label">Valor Total</span>
                <span class="amount">${{ number_format($totalPagar, 0, ',', '.') }}</span>
            </div>

            <div class="pay-title">Elige el medio de pago</div>
            <div class="pay-sub">Código QR</div>
            <label class="pay-option">
                <span><strong>Código QR</strong> (paga desde Nequi, Daviplata, app bancaria o billetera compatible)</span>
                <input type="radio" name="medio_pago" value="qr" checked>
            </label>
            <label class="pay-option">
                <span><strong>Tarjeta Crédito / Débito</strong> (Visa, MasterCard), Nequi y Bancolombia: tú eliges.</span>
                <input type="radio" name="medio_pago" value="tarjeta">
            </label>

            <p class="disclaimer">¡Pilas antes de pagar verifica que la vigencia de tu póliza este correcta!</p>
            <p class="disclaimer">*Si tu vehículo aplica para más de una clasificación, cerciórate de elegir la correcta. Para la tarifa de Servicio Público, debes seleccionar la tarifa que tienes autorizada en la Tarjeta de Operación. Seguros Mundial no se hace responsable si eliges la tarifa que no aplica.</p>

            <div class="actions">
                <button type="button" class="btn-link" id="btn-regresar">Regresar</button>
                <button type="button" class="btn-pagar" id="btn-ir-pagar">Ir a pagar</button>
            </div>
        </section>
    </main>

    <script>
        (function () {
            var regresar = document.getElementById('btn-regresar');
            var irPagar = document.getElementById('btn-ir-pagar');
            var totalPagar = {{ (int) $totalPagar }};
            if (regresar) {
                regresar.addEventListener('click', function () {
                    window.history.back();
                });
            }
            if (irPagar) {
                irPagar.addEventListener('click', function () {
                    var medio = document.querySelector('input[name="medio_pago"]:checked');
                    var seleccionado = medio ? medio.value : 'qr';
                    if (seleccionado === 'qr') {
                        var params = new URLSearchParams({ total: String(totalPagar) });
                        window.location.href = @json(route('soat.pago.qr')) + '?' + params.toString();
                        return;
                    }
                    if (seleccionado === 'tarjeta') {
                        var p = new URLSearchParams({ total: String(totalPagar) });
                        window.location.href = @json(route('soat.pago.tarjeta')) + '?' + p.toString();
                        return;
                    }
                    window.location.href = @json($whatsPago);
                });
            }
        })();
    </script>
</body>
</html>
