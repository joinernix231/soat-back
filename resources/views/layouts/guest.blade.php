<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?: (config('app.name', 'SOAT Mundial') . ' — Acceso') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>

    <style>
        body.guest-soat {
            background: linear-gradient(135deg, #003087 0%, #0d4a9c 42%, #00a651 100%);
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
        }

        .guest-soat .card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.28);
        }

        .guest-soat .input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            margin-top: 8px;
            margin-bottom: 20px;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 15px;
        }

        .guest-soat .input:focus {
            border-color: #00a651;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 166, 81, 0.15);
        }

        .guest-soat .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #003087 0%, #00a651 100%);
            color: #fff;
            padding: 14px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            font-weight: 600;
            font-size: 16px;
            margin-top: 10px;
        }

        .guest-soat .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 48, 135, 0.35);
        }

        .guest-soat label {
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        .guest-soat .link-soat {
            color: #003087;
            font-weight: 600;
        }

        .guest-soat .link-soat:hover {
            color: #00a651;
            text-decoration: underline;
        }
    </style>
</head>
<body class="guest-soat font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 px-4 pb-10">
        <div class="mb-8 text-center">
            <p class="text-white/90 text-sm font-semibold tracking-wide uppercase mb-1">Seguros Mundial</p>
            <h1 class="text-4xl sm:text-5xl font-bold text-white drop-shadow-sm">SOAT</h1>
            <p class="text-white/85 text-center mt-2 max-w-sm mx-auto text-sm sm:text-base">
                Panel administrativo · Gestión de registros y pólizas
            </p>
        </div>

        <div class="w-full sm:max-w-md">
            {{ $slot }}
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('welcome') }}" class="text-white/85 text-sm hover:text-white underline underline-offset-2">
                ← Volver al sitio público
            </a>
        </div>
    </div>
</body>
</html>
