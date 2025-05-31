<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Nombre -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required autocomplete="name"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Apellidos -->
        <div>
            <x-input-label for="apellidos" :value="__('Apellidos')" />
            <input id="apellidos" name="apellidos" type="text" value="{{ old('apellidos') }}" required autocomplete="apellidos"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Teléfono -->
        <div>
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <input id="telefono" name="telefono" type="text" value="{{ old('telefono') }}" required autocomplete="tel"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- DNI -->
        <div>
            <x-input-label for="dni" :value="__('DNI')" />
            <input id="dni" name="dni" type="text" value="{{ old('dni') }}" required autocomplete="dni"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <input id="password" name="password" type="password" required autocomplete="new-password"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Acciones -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-6">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                ¿Ya tienes una cuenta?
            </a>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition font-semibold">
                Registrarse
            </button>
        </div>
    </form>
</x-guest-layout>
