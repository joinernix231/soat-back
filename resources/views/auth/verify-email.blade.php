<x-guest-layout pageTitle="Verificar correo — SOAT Mundial">
    <div class="card">
        <h2 class="text-3xl font-bold text-center mb-2 text-gray-800">Verifica tu correo</h2>
        <p class="text-center text-gray-500 mb-6 text-sm leading-relaxed">
            Gracias por registrarte. Antes de continuar, confirma tu correo con el enlace que te enviamos. Si no lo recibiste, podemos enviarte otro.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm text-center">
                Te enviamos un nuevo enlace de verificación a tu correo.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">Reenviar correo de verificación</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
