<x-guest-layout>
    <div class="mb-6 text-gray-700 text-sm leading-relaxed">
        ¿Olvidaste tu contraseña? No te preocupes. Introduce tu correo electrónico y te enviaremos un enlace para restablecerla.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Botón -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition font-semibold">
                Enviar enlace de restablecimiento
            </button>
        </div>
    </form>
</x-guest-layout>
