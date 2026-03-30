<x-guest-layout pageTitle="Nueva contraseña — SOAT Mundial">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Nueva contraseña</h2>
        <p class="text-center text-gray-500 mb-8">Elige una contraseña segura para tu cuenta</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" class="input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="tu@email.com">
            </div>

            <div>
                <label for="password">Nueva contraseña</label>
                <input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
            </div>

            <div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite la contraseña">
            </div>

            <button type="submit" class="btn-primary">Guardar contraseña</button>
        </form>
    </div>
</x-guest-layout>
