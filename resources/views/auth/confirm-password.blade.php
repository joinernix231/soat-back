<x-guest-layout pageTitle="Confirmar acceso — SOAT Mundial">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Confirmar contraseña</h2>
        <p class="text-center text-gray-500 mb-8 text-sm leading-relaxed">
            Esta es un área segura. Por favor confirma tu contraseña antes de continuar.
        </p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <label for="password">Contraseña</label>
                <input id="password" class="input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary">Confirmar</button>
        </form>
    </div>
</x-guest-layout>
