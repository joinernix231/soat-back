<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pago con Código QR - Seguros Mundial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @php
        $monto = '$' . number_format($total, 0, ',', '.');
        $payloadQr = 'PAGO SOAT|' . $cliente->nombre . '|' . $monto;
        $qrImgGenerado = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($payloadQr);
        $qrImg = $qrConfig && $qrConfig->qr_image_path ? asset($qrConfig->qr_image_path) : $qrImgGenerado;
        $mensajePago = $qrConfig && $qrConfig->mensaje_pago
            ? $qrConfig->mensaje_pago
            : 'Escanea el código con tu app bancaria o billetera digital para completar el pago de tu SOAT.';
        $nombreComercio = $qrConfig && $qrConfig->nombre_comercio ? $qrConfig->nombre_comercio : 'Seguros Mundial';
        $placaFmt = $vehiculo->placa ? strtoupper($vehiculo->placa) : '';
        $whatsConfirmUrl = 'https://api.whatsapp.com/send?phone=573219127738&text='
            . rawurlencode(
                'Hola, ya realicé el pago de mi SOAT por ' . $monto
                . ' a nombre de ' . strtoupper($cliente->nombre) . '.'
                . ($placaFmt ? ' Placa: ' . $placaFmt . '.' : '')
                . ' Por favor confirmen el pago. Gracias.'
            );
    @endphp
    <style>
        :root {
            --sm-blue: #0d5f84;
            --sm-bg: #e9eff5;
            --sm-card: #ffffff;
            --sm-border: #d9e2e9;
            --sm-accent: #2bd2c1;
            --sm-text: #22333f;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--sm-bg);
            color: var(--sm-text);
        }
        .top {
            background: #fff;
            border-top: 2px solid var(--sm-blue);
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
            padding: 0.7rem 1rem;
        }
        .top-inner {
            max-width: 980px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo-image {
            display: block;
            width: auto;
            height: 40px;
            max-width: 250px;
            object-fit: contain;
        }
        .btn-contact {
            border: 1px solid #0f7aa6;
            border-radius: 999px;
            background: transparent;
            color: #0f7aa6;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.72rem;
        }
        .wrap {
            min-height: calc(100vh - 64px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.35rem;
        }
        .card {
            width: 100%;
            max-width: 470px;
            background: var(--sm-card);
            border: 1px solid var(--sm-border);
            border-radius: 10px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.08);
            padding: 1.2rem 1.1rem 1rem;
        }
        .title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--sm-blue);
            text-align: center;
            margin-bottom: 0.9rem;
        }
        .panel {
            border: 1px solid #edf2f5;
            border-radius: 8px;
            padding: 0.8rem;
            background: #fbfdff;
        }
        .qr-box {
            display: flex;
            justify-content: center;
            margin-bottom: 0.55rem;
        }
        .qr-box img {
            width: 240px;
            height: 240px;
            border: 1px solid #dde5ea;
            border-radius: 8px;
            background: #fff;
            padding: 8px;
        }
        .amount {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: var(--sm-blue);
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0.3rem 0 0.35rem;
        }
        .hint {
            text-align: center;
            font-size: 0.78rem;
            color: #4b6574;
            margin-bottom: 0.7rem;
            line-height: 1.35;
        }
        .steps {
            font-size: 0.78rem;
            color: #4b6574;
            text-align: center;
            line-height: 1.45;
            margin-bottom: 0.85rem;
        }
        .steps strong { color: var(--sm-blue); }
        .btn-whats {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            border-radius: 999px;
            background: #25d366;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.72rem 0.9rem;
            margin-top: 0.35rem;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.35);
        }
        .btn-whats:hover { filter: brightness(1.05); }
        .other {
            margin-top: 0.75rem;
            font-size: 0.72rem;
            color: #617785;
            font-weight: 700;
        }
        .method {
            border-top: 1px solid #e8eef3;
            padding: 0.62rem 0.1rem;
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            color: #324e60;
        }
        a.method {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            border-radius: 6px;
        }
        a.method:hover {
            background: #f3f8fb;
        }
        .apps-pago {
            margin-top: 0.55rem;
            border-top: 1px solid #e8eef3;
            padding-top: 0.65rem;
        }
        .apps-pago img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #dde5ea;
            background: #fff;
        }
        .notice {
            margin-top: 0.85rem;
            background: #fff3dc;
            border: 1px solid #ffe3a8;
            color: #7a5b19;
            font-size: 0.66rem;
            padding: 0.5rem 0.6rem;
            border-radius: 6px;
            line-height: 1.45;
        }
        .brands {
            margin-top: 0.75rem;
            display: flex;
            justify-content: center;
            gap: 0.6rem;
            font-size: 0.72rem;
            color: #698091;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <header class="top">
        <div class="top-inner">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/logos/seguros-mundial-logo.webp') }}" alt="Seguros Mundial" class="logo-image" width="304" height="68">
            </a>
            <button type="button" class="btn-contact">Contacto</button>
        </div>
    </header>
    <main class="wrap">
        <section class="card">
            <h1 class="title">Pago con Código QR</h1>
            <p class="steps">
                <strong>1.</strong> Escanea el código y paga desde tu app.<br>
                <strong>2.</strong> Luego usa el botón verde para <strong>confirmar el pago</strong> por WhatsApp.
            </p>
            <div class="panel">
                <div class="qr-box">
                    <img src="{{ $qrImg }}" alt="Código QR de pago">
                </div>
                <p class="hint" style="margin-bottom:0.35rem;font-weight:700;color:#0d5f84;">{{ $nombreComercio }}</p>
                <div class="amount">{{ $monto }}</div>
                <p class="hint">{{ $mensajePago }}</p>
                <a href="{{ $whatsConfirmUrl }}" class="btn-whats" target="_blank" rel="noopener noreferrer">Confirmar pago por WhatsApp</a>
                <p class="other">Otros medios de pago:</p>
                <a href="{{ route('soat.pago.tarjeta', ['total' => $total]) }}" class="method"><span>Tarjeta Crédito / Débito</span><span>›</span></a>
                <div class="method"><span>Nequi</span><span>›</span></div>
                <div class="apps-pago">
                    <img src="{{ asset('PAGOS.jpeg') }}" alt="Apps habilitadas para pagar">
                </div>
            </div>
            <div class="notice"><strong>Importante:</strong> Verifica los datos de tu compra antes de pagar. Después de pagar, envía el mensaje por WhatsApp para agilizar la confirmación.</div>
            <div class="brands">
                <span>Mastercard</span><span>VISA</span><span>PayZen</span>
            </div>
        </section>
    </main>
</body>
</html>
