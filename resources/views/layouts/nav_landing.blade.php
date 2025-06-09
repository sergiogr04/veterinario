<header class="bg-white shadow sticky top-0 z-50" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        {{-- Logo a la izquierda (pero grande solo en móvil) --}}
        <a href="#" onclick="scrollToSection('hero')" class="shrink-0">
            <img src="{{ asset('images/logo-clinica.webp') }}" alt="Logo Clínica San Lorenzo"
                class="h-[100px] md:h-[80px] w-auto">
        </a>

        {{-- Navegación (escritorio) --}}
        <nav class="space-x-6 hidden md:flex">
            <a onclick="scrollToSection('hero')" class="text-gray-700 hover:text-blue-700">Inicio</a>
            <a onclick="scrollToSection('presentacion')" class="text-gray-700 hover:text-blue-700">Nosotros</a>
            <a onclick="scrollToSection('servicios')" class="text-gray-700 hover:text-blue-700">Servicios</a>
            <a onclick="scrollToSection('testimonios')" class="text-gray-700 hover:text-blue-700">Opiniones</a>
            <a onclick="scrollToSection('cta')" class="text-gray-700 hover:text-blue-700">Cita</a>
        </nav>

        @auth
        @php
        $user = auth()->user();
        $dashboard = match($user->rol) {
        'admin' => route('dashboard_admin'),
        'trabajador' => route('dashboard_trabajador'),
        default => route('dashboard_cliente'),
        };
        @endphp
        <a href="{{ $dashboard }}" class="hidden md:inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Iniciar sesión
        </a>
        @else
        <a href="{{ route('login') }}" class="hidden md:inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Iniciar sesión
        </a>
        @endauth


        {{-- Menú hamburguesa (móvil) --}}
        <button @click="mobileMenu = !mobileMenu" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Menú móvil desplegable --}}
    <div x-show="mobileMenu" x-transition class="md:hidden bg-white shadow-md">
        <nav class="flex flex-col space-y-2 px-6 py-4 text-gray-700">
            <a href="#" onclick="scrollToSection('hero')" class="hover:text-blue-700">Inicio</a>
            <a href="#" onclick="scrollToSection('presentacion')" class="hover:text-blue-700">Nosotros</a>
            <a href="#" onclick="scrollToSection('servicios')" class="hover:text-blue-700">Servicios</a>
            <a href="#" onclick="scrollToSection('testimonios')" class="hover:text-blue-700">Opiniones</a>
            <a href="#" onclick="scrollToSection('cta')" class="hover:text-blue-700">Cita</a>
            <hr class="my-2">

            @auth
            @php
            $user = auth()->user();
            $dashboard = match($user->rol) {
            'admin' => route('dashboard_admin'),
            'trabajador' => route('dashboard_trabajador'),
            default => route('dashboard_cliente'),
            };
            @endphp
            <a href="{{ $dashboard }}" class="text-white bg-blue-600 px-4 py-2 rounded text-center hover:bg-blue-700 transition">
                Ir al panel
            </a>
            @else
            <a href="{{ route('login') }}" class="text-white bg-blue-600 px-4 py-2 rounded text-center hover:bg-blue-700 transition">
                Iniciar sesión
            </a>
            @endauth
        </nav>
    </div>

</header>

{{-- AlpineJS (por si aún no está incluido) --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>