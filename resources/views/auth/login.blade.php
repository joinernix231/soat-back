<x-guest-layout pageTitle="Iniciar sesión — SOAT Mundial">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Iniciar sesión</h2>
        <p class="text-center text-gray-500 mb-8">Accede al panel administrativo</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@email.com">
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input id="password" class="input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#00a651] shadow-sm focus:ring-[#00a651]">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm link-soat" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-primary">Iniciar sesión</button>
        </form>

        @if (Route::has('register'))
            <p class="mt-6 text-center text-sm text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="link-soat hover:underline">
                    Crear cuenta
                </a>
            </p>
        @endif
    </div>
</x-guest-layout>
