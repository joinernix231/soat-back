<x-guest-layout pageTitle="Recuperar contraseña — SOAT Mundial">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Recuperar contraseña</h2>
        <p class="text-center text-gray-500 mb-6 text-sm leading-relaxed">
            Indica tu correo y te enviaremos un enlace para elegir una nueva contraseña.
        </p>

        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@email.com">
            </div>

            <button type="submit" class="btn-primary">Enviar enlace</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="link-soat hover:underline">← Volver al inicio de sesión</a>
        </p>
    </div>
</x-guest-layout>
