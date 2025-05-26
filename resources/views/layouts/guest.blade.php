<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clínica San Lorenzo') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">

        {{-- Logo centrado arriba --}}
        <div class="mb-6">
            <a href="/">
                <img src="{{ asset('images/logo-clinica.png') }}" alt="Logo Clínica San Lorenzo" class="h-28 mx-auto">
            </a>
        </div>

        {{-- Contenedor del formulario --}}
        <div class="w-full max-w-xl bg-white p-8 rounded-xl shadow-lg">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
