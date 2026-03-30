<x-guest-layout pageTitle="Crear cuenta — SOAT Mundial">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Crear cuenta</h2>
        <p class="text-center text-gray-500 mb-8">Regístrate para gestionar registros SOAT</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Nombre</label>
                <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Tu nombre completo">
            </div>

            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="tu@email.com">
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
            </div>

            <div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña">
            </div>

            <button type="submit" class="btn-primary">Registrarse</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="link-soat hover:underline">
                Iniciar sesión
            </a>
        </p>
    </div>
</x-guest-layout>
