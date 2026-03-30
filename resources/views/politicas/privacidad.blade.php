<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - SOAT Mundial</title>
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
        }
        .logo-section h1 {
            color: white;
            margin: 0;
            font-size: 1.5em;
        }
        .header-contacts a {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }
        .container {
            max-width: 900px;
            margin: 2em auto;
            padding: 0 1em;
        }
        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 3em;
        }
        .content-card h1 {
            color: #003087;
            margin-top: 0;
            margin-bottom: 1em;
        }
        .content-card h2 {
            color: #003087;
            margin-top: 2em;
            margin-bottom: 1em;
        }
        .content-card p {
            line-height: 1.8;
            color: #555;
            margin-bottom: 1em;
        }
        .content-card ul {
            margin-bottom: 1em;
            padding-left: 2em;
        }
        .content-card li {
            margin-bottom: 0.5em;
            line-height: 1.8;
            color: #555;
        }
        .btn-back {
            display: inline-block;
            padding: 0.75em 2em;
            background: #003087;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 2em;
        }
        .btn-back:hover {
            background: #0046a8;
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
    </style>
</head>
<body>
    <header class="header-soat">
        <div class="header-content">
            <div class="logo-section">
                <h1>SOAT Mundial</h1>
            </div>
            <div class="header-contacts">
                <a href="{{ route('welcome') }}">Volver al Inicio</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="content-card">
            <h1>Política de Privacidad</h1>
            
            <p><strong>Última actualización:</strong> {{ date('d/m/Y') }}</p>

            <h2>1. Información que Recopilamos</h2>
            <p>Seguros Mundial recopila información personal que usted nos proporciona directamente cuando utiliza nuestros servicios, incluyendo:</p>
            <ul>
                <li>Información de identificación personal (nombre, tipo y número de documento)</li>
                <li>Información de contacto (correo electrónico, teléfono)</li>
                <li>Información del vehículo (placa, marca, modelo, año)</li>
                <li>Información de la póliza SOAT</li>
            </ul>

            <h2>2. Uso de la Información</h2>
            <p>Utilizamos la información recopilada para:</p>
            <ul>
                <li>Procesar y gestionar consultas de SOAT</li>
                <li>Proporcionar información sobre nuestros servicios</li>
                <li>Mejorar nuestros servicios y experiencia del usuario</li>
                <li>Cumplir con obligaciones legales y regulatorias</li>
            </ul>

            <h2>3. Protección de Datos</h2>
            <p>Implementamos medidas de seguridad técnicas y organizativas para proteger su información personal contra acceso no autorizado, alteración, divulgación o destrucción.</p>

            <h2>4. Compartir Información</h2>
            <p>No vendemos, alquilamos ni compartimos su información personal con terceros, excepto cuando sea necesario para proporcionar nuestros servicios o cuando la ley lo requiera.</p>

            <h2>5. Sus Derechos</h2>
            <p>Usted tiene derecho a:</p>
            <ul>
                <li>Acceder a su información personal</li>
                <li>Rectificar información incorrecta</li>
                <li>Solicitar la eliminación de sus datos</li>
                <li>Oponerse al procesamiento de sus datos</li>
            </ul>

            <h2>6. Contacto</h2>
            <p>Para ejercer sus derechos o realizar consultas sobre esta política, puede contactarnos a través de nuestros canales de atención.</p>

            <a href="{{ route('welcome') }}" class="btn-back">Volver al Inicio</a>
        </div>
    </div>

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




