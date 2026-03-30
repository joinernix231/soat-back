<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones - SOAT Mundial</title>
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
            <h1>Términos y Condiciones</h1>
            
            <p><strong>Última actualización:</strong> {{ date('d/m/Y') }}</p>

            <h2>1. Aceptación de los Términos</h2>
            <p>Al acceder y utilizar el sitio web de SOAT Mundial, usted acepta estar sujeto a estos términos y condiciones de uso.</p>

            <h2>2. Uso del Servicio</h2>
            <p>El servicio de consulta de SOAT está disponible para uso personal y no comercial. Usted se compromete a:</p>
            <ul>
                <li>Proporcionar información veraz y precisa</li>
                <li>No utilizar el servicio para fines ilegales o no autorizados</li>
                <li>No intentar acceder a áreas restringidas del sistema</li>
                <li>Respetar los derechos de propiedad intelectual</li>
            </ul>

            <h2>3. Información Proporcionada</h2>
            <p>Usted es responsable de la exactitud de la información que proporciona. Seguros Mundial no se hace responsable por errores derivados de información incorrecta proporcionada por el usuario.</p>

            <h2>4. Disponibilidad del Servicio</h2>
            <p>Nos esforzamos por mantener el servicio disponible, pero no garantizamos disponibilidad continua. Podemos interrumpir el servicio para mantenimiento o actualizaciones.</p>

            <h2>5. Limitación de Responsabilidad</h2>
            <p>Seguros Mundial no será responsable por daños indirectos, incidentales o consecuentes derivados del uso o la imposibilidad de usar el servicio.</p>

            <h2>6. Modificaciones</h2>
            <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en vigor al ser publicadas en el sitio web.</p>

            <h2>7. Ley Aplicable</h2>
            <p>Estos términos se rigen por las leyes de la República de Colombia. Cualquier disputa será resuelta en los tribunales competentes de Colombia.</p>

            <h2>8. Contacto</h2>
            <p>Para consultas sobre estos términos y condiciones, puede contactarnos a través de nuestros canales de atención.</p>

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




