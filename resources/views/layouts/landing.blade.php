<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clínica Veterinaria') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="flex flex-col min-h-screen font-sans antialiased bg-white text-gray-800">

    {{-- Header de la landing --}}
    @include('layouts.nav_landing')

    <main class="flex-grow">
        @yield('content')
    </main>
    
    {{-- Footer personalizado --}}
    @include('components.footer')

    {{-- Scroll suave para los botones --}}
    <script>
        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }
    </script>

    {{-- AlpineJS (si lo usas solo en landing) --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
