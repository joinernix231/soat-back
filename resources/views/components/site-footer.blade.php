@props(['class' => ''])

<footer class="sm-site-footer {{ $class }}" role="contentinfo">
    <style>
        .sm-site-footer {
            --sm-footer-bg: #103144;
            --sm-footer-muted: rgba(255, 255, 255, 0.72);
            --sm-footer-line: rgba(255, 255, 255, 0.12);
            background: var(--sm-footer-bg);
            color: #fff;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 3.25rem 1.5rem 0;
            margin-top: 0;
        }

        .sm-site-footer a {
            color: inherit;
            text-decoration: none;
            transition: opacity 0.2s ease, color 0.2s ease;
        }

        .sm-site-footer a:hover {
            opacity: 0.85;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .sm-site-footer__inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.1fr 1fr 1.35fr 0.85fr;
            gap: 2.5rem 2rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid var(--sm-footer-line);
        }

        .sm-site-footer__brand {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sm-site-footer__logo-link {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none !important;
        }

        .sm-site-footer__logo-link:hover {
            opacity: 0.92;
        }

        .sm-site-footer__logo-mark {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sm-site-footer__logo-mark svg {
            width: 22px;
            height: 22px;
            fill: #fff;
        }

        .sm-site-footer__logo-word {
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: -0.02em;
            line-height: 1.15;
            color: #fff;
        }

        .sm-site-footer__logo-word small {
            display: block;
            font-weight: 500;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.85;
            margin-top: 0.15rem;
        }

        .sm-site-footer__nav {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .sm-site-footer__nav a {
            font-size: 0.9375rem;
            color: var(--sm-footer-muted);
        }

        .sm-site-footer__nav a:hover {
            color: #fff;
        }

        .sm-site-footer__heading {
            font-size: 0.8125rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0 0 1.1rem;
            color: #fff;
        }

        .sm-site-footer__payments {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sm-site-footer__payment-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem 1rem;
        }

        .sm-site-footer__payment-row img {
            height: 28px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            filter: brightness(1.05);
        }

        .sm-site-footer__payment-row--wide img.sm-kushki {
            height: 32px;
        }

        .sm-site-footer__contact-intro {
            font-size: 0.8125rem;
            color: var(--sm-footer-muted);
            line-height: 1.5;
            margin: 0.5rem 0 0.65rem;
        }

        .sm-site-footer__contact-list {
            margin: 0;
            padding-left: 1.1rem;
            font-size: 0.8125rem;
            color: var(--sm-footer-muted);
            line-height: 1.65;
        }

        .sm-site-footer__contact-list a {
            color: #fff;
            font-weight: 500;
        }

        .sm-site-footer__social {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-top: 0.25rem;
        }

        .sm-site-footer__social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            color: var(--sm-footer-bg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .sm-site-footer__social a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            opacity: 1;
        }

        .sm-site-footer__social svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .sm-site-footer__bar {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.25rem 1.5rem 1.75rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .sm-site-footer__copy {
            font-size: 0.75rem;
            color: var(--sm-footer-muted);
            margin: 0;
        }

        .sm-site-footer__vigilado {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-align: right;
            line-height: 1.35;
            color: var(--sm-footer-muted);
            max-width: 220px;
        }

        .sm-site-footer__vigilado-badge {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 4px;
            border: 1px solid var(--sm-footer-line);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.5rem;
            font-weight: 800;
            text-align: center;
            line-height: 1.2;
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        @media (max-width: 1024px) {
            .sm-site-footer__inner {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .sm-site-footer {
                padding-top: 2.5rem;
            }

            .sm-site-footer__inner {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .sm-site-footer__bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .sm-site-footer__vigilado {
                text-align: left;
                max-width: none;
            }
        }
    </style>

    <div class="sm-site-footer__inner">
        <div class="sm-site-footer__brand">
            <a href="https://www.segurosmundial.com.co/" class="sm-site-footer__logo-link" target="_blank" rel="noopener noreferrer">
                <span class="sm-site-footer__logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2L3 7v5c0 4.5 3.1 8.7 9 10 5.9-1.3 9-5.5 9-10V7l-9-5zm0 2.2l6.5 3.6v4.4c0 3.4-2.3 6.6-6.5 7.8-4.2-1.2-6.5-4.4-6.5-7.8V7.8L12 4.2z"/>
                        <path d="M11 8.5v5.2l4.2 2.4.8-1.4-3-1.7V8.5H11z"/>
                    </svg>
                </span>
                <span class="sm-site-footer__logo-word">
                    seguros mundial
                    <small>un amigo de verdad</small>
                </span>
            </a>
            <ul class="sm-site-footer__nav">
                <li><a href="https://soatmundial.com.co/renovacionsoat/" target="_blank" rel="noopener noreferrer">Renovar</a></li>
                <li><a href="https://soatmundial.com.co/tarifas-soat/" target="_blank" rel="noopener noreferrer">Requisitos</a></li>
            </ul>
        </div>

        <div>
            <h2 class="sm-site-footer__heading">Ayuda</h2>
            <ul class="sm-site-footer__nav">
                <li><a href="{{ route('terminos.condiciones') }}">Términos y condiciones</a></li>
                <li><a href="{{ route('politica.privacidad') }}">Políticas de privacidad</a></li>
                <li><a href="https://www.segurosmundial.com.co/contactanos/" target="_blank" rel="noopener noreferrer">Contáctanos</a></li>
                <li><a href="https://www.segurosmundial.com.co/sucursales/" target="_blank" rel="noopener noreferrer">Sucursales</a></li>
                <li><a href="https://www.segurosmundial.com.co/" target="_blank" rel="noopener noreferrer">Reclamaciones SOAT</a></li>
            </ul>
        </div>

        <div>
            <h2 class="sm-site-footer__heading">Medios de pagos</h2>
            <div class="sm-site-footer__payments">
                <div class="sm-site-footer__payment-row">
                    <img src="{{ asset('images/footer/payment-mastercard.webp') }}" alt="Mastercard" width="95" height="74" loading="lazy">
                    <img src="{{ asset('images/footer/payment-visa.webp') }}" alt="Visa" width="133" height="43" loading="lazy">
                </div>
                <div class="sm-site-footer__payment-row sm-site-footer__payment-row--wide">
                    <img src="{{ asset('images/footer/payment-pse.webp') }}" alt="PSE" width="104" height="81" loading="lazy">
                    <img class="sm-kushki" src="{{ asset('images/footer/payment-kushki.webp') }}" alt="Powered by Kushki" width="216" height="91" loading="lazy">
                </div>
            </div>
            <p class="sm-site-footer__contact-intro">Si tienes alguna inquietud, comunícate con nosotros a:</p>
            <ul class="sm-site-footer__contact-list">
                <li>Línea gratuita nacional: <a href="tel:018000111935">01 8000 111 935</a></li>
                <li>Desde tu celular: <strong>#935</strong> (Tigo, Claro, Movistar)</li>
                <li>Bogotá: <a href="tel:+576013274712">(601) 327 4712</a></li>
                <li><a href="https://www.segurosmundial.com.co/contacto/" target="_blank" rel="noopener noreferrer">Página web — Servicio al cliente</a></li>
            </ul>
        </div>

        <div>
            <h2 class="sm-site-footer__heading">Síguenos en</h2>
            <div class="sm-site-footer__social">
                <a href="https://www.linkedin.com/company/seguros-mundial-s-a-" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Seguros Mundial">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M6.94 6.5a1.44 1.44 0 11-.001 2.881A1.44 1.44 0 016.94 6.5zm.12 4.14h2.67v8.36H7.06v-8.36zm4.32 0h2.56v1.14h.04c.36-.68 1.23-1.4 2.53-1.4 2.7 0 3.2 1.77 3.2 4.08v4.54h-2.67v-4.02c0-1.02-.02-2.33-1.42-2.33-1.42 0-1.64 1.11-1.64 2.26v4.09h-2.67v-8.36z"/></svg>
                </a>
                <a href="https://www.facebook.com/SegurosMundialSA" target="_blank" rel="noopener noreferrer" aria-label="Facebook Seguros Mundial">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M14 13.5h2.5l1-3H14v-1.9c0-.9.3-1.9 1.9-1.9H17V3.5h-2.5c-3 0-4.5 1.8-4.5 4.3v2.2H7v3h3V21h4v-7.5z"/></svg>
                </a>
                <a href="https://www.instagram.com/segurosmundial/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Seguros Mundial">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 01-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8C2 4.6 4.6 2 7.8 2zm-.2 2A3.6 3.6 0 004 7.6v8.8A3.6 3.6 0 007.6 20h8.8a3.6 3.6 0 003.6-3.6V7.6A3.6 3.6 0 0016.4 4H7.6zm9.65 1.5a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"/></svg>
                </a>
                <a href="https://twitter.com/SegurosMundial" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter) Seguros Mundial">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M18.244 3H21l-6.5 7.4L22 21h-6.9l-5.4-6.9L5.5 21H2l7-8L2 3h6.9l4.9 6.3L18.244 3zm-1.2 16h2.1L7.05 5H4.9l12.144 14z"/></svg>
                </a>
                <a href="https://www.youtube.com/user/segurosmundial" target="_blank" rel="noopener noreferrer" aria-label="YouTube Seguros Mundial">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M21.8 8.001a2.75 2.75 0 00-1.94-1.955C18.2 5.5 12 5.5 12 5.5s-6.2 0-7.86.546A2.75 2.75 0 002.2 8.001 28.3 28.3 0 002 12a28.3 28.3 0 00.2 3.999 2.75 2.75 0 001.94 1.955C5.8 18.5 12 18.5 12 18.5s6.2 0 7.86-.546a2.75 2.75 0 001.94-1.955A28.3 28.3 0 0022 12a28.3 28.3 0 00-.2-3.999zM10 15.5v-7l6 3.5-6 3.5z"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="sm-site-footer__bar">
        <p class="sm-site-footer__copy">Todos los derechos reservados Seguros Mundial {{ date('Y') }}</p>
        <div class="sm-site-footer__vigilado">
            <span class="sm-site-footer__vigilado-badge" aria-hidden="true">VIGILADO<br>SFC</span>
            <span>Superintendencia Financiera de Colombia</span>
        </div>
    </div>
</footer>
