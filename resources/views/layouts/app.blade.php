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
    {{-- Header personalizado --}}
    @include('layouts.nav_roles')

    {{-- Contenido principal --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer personalizado --}}
    @include('components.footer')

    {{-- Scroll suave a secciones --}}
    <script>
        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-[9999]"></div>
    <script>
function showToast(mensaje, tipo = 'success') {
    const toast = document.createElement('div');
    toast.className = `px-4 py-3 rounded shadow text-white animate-slide-in-right ${
        tipo === 'success' ? 'bg-green-600' :
        tipo === 'error'   ? 'bg-red-600'   :
        tipo === 'info'    ? 'bg-blue-600'  : 'bg-gray-600'
    }`;
    toast.textContent = mensaje;

    document.getElementById('toast-container').appendChild(toast);

    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}
</script>

<style>
@keyframes slide-in-right {
  0%   { transform: translateX(100%); opacity: 0; }
  100% { transform: translateX(0); opacity: 1; }
}
.animate-slide-in-right {
  animation: slide-in-right 0.4s ease-out;
  transition: opacity 0.5s ease;
}
</style>

</body>
</html>
