<header class="bg-white shadow sticky top-0 z-50" x-data="{ mobileMenu: false, userMenu: false }">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        {{-- Logo como Inicio --}}
        <a href="{{ route('dashboard_cliente') }}" class="shrink-0">
            <img src="{{ asset('images/logo-clinica.webp') }}" alt="Logo Clínica San Lorenzo" class="h-14 md:h-12 w-auto">
        </a>

        {{-- Navegación escritorio --}}
        <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
            <a href="{{ route('cliente.mascotas') }}" class="hover:text-blue-600">Mascotas</a>
            <a href="{{ route('cliente.citas') }}" class="hover:text-blue-600">Pedir Cita</a>
            <a href="{{ route('cliente.contacto') }}" class="hover:text-blue-600">Contacto</a>
        </nav>

        {{-- Usuario con menú desplegable --}}
        <div class="hidden md:block relative" @click.away="userMenu = false">
            <button @click="userMenu = !userMenu" class="flex items-center space-x-2 text-sm text-gray-600 hover:text-blue-600 focus:outline-none">
                <span>👤 {{ Auth::user()->nombre }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="userMenu" x-transition class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md py-2 z-50">
                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- Botón hamburguesa móvil --}}
        <button @click="mobileMenu = !mobileMenu" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Menú móvil --}}
    <div x-show="mobileMenu" x-transition class="md:hidden bg-white shadow-md px-6 py-4 space-y-2">
        <a href="{{ route('cliente.mascotas') }}" class="block hover:text-blue-600">Mascotas</a>
        <a href="{{ route('cliente.citas') }}" class="block hover:text-blue-600">Pedir Cita</a>
        <a href="{{ route('cliente.contacto') }}" class="block hover:text-blue-600">Contacto</a>
        <hr>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Cerrar sesión
            </button>
        </form>
    </div>
</header>

{{-- AlpineJS (por si no está cargado globalmente) --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
