@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">👋 Bienvenido, {{ Auth::user()->nombre }}</h1>

        {{-- 🟢 Estadísticas del día --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            {{-- Citas del día --}}
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500 mb-1">📅 Citas de hoy</p>
                <p class="text-4xl font-bold text-blue-600">{{ $citasHoy }}</p>
                @if ($proximaCita)
                    <p class="text-sm mt-2 text-gray-400">Próxima: {{ $proximaCita->hora }} - <strong>{{ $proximaCita->mascota->nombre }}</strong> ({{ $proximaCita->mascota->cliente->nombre }})</p>
                @endif
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500">📆 Citas esta semana</p>
                <p class="text-3xl font-bold text-cyan-600">{{ $citasSemana }}</p>
            </div>
            

            {{-- Mascotas distintas hoy --}}
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500 mb-1">🐶 Mascotas distintas hoy</p>
                <p class="text-4xl font-bold text-purple-600">{{ $mascotasHoy }}</p>
            </div>
        </div>

        {{-- 📋 Historial reciente --}}
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">🩺 Últimos historiales médicos</h2>
            <ul class="divide-y divide-gray-100 text-sm">
                @forelse ($historialReciente as $item)
                    <li class="py-2">
                        <strong>{{ $item->mascota->nombre }}</strong> — {{ $item->descripcion }}
                        <span class="text-gray-400">({{ $item->fecha }})</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">No hay historial reciente.</li>
                @endforelse
            </ul>
        </div>

        {{-- 📊 Estadísticas globales --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500">📊 Total de mascotas</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalMascotas }}</p>
            </div>

            {{-- Citas atendidas --}}
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500 mb-1">✅ Citas atendidas</p>
                <p class="text-4xl font-bold text-green-600">{{ $citasAtendidas }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500">👤 Clientes registrados</p>
                <p class="text-3xl font-bold text-amber-600">{{ $totalClientes }}</p>
            </div>

            @if ($mascotaTop && $mascotaTop->mascota)
                <div class="bg-white p-6 rounded-lg shadow text-center col-span-full sm:col-span-2 lg:col-span-1">
                    <p class="text-gray-500">🏅 Mascota más atendida</p>
                    <p class="text-xl font-bold text-pink-600">{{ $mascotaTop->mascota->nombre }}</p>
                    <p class="text-sm text-gray-400">({{ $mascotaTop->mascota->especie }})</p>
                </div>
            @endif
        </div>

        {{-- 💬 Frase motivacional --}}
        @php
        $frases = [
            "Gracias por cuidar de nuestros mejores amigos 🐾",
            "¡Sigue así! Cada día es una oportunidad de ayudar 🩺",
            "Hoy es un buen día para marcar la diferencia ❤️",
            "Tu trabajo transforma vidas, una mascota a la vez 🐶",
            "Detrás de cada cola moviéndose hay un corazón agradecido 🐾",
            "Las mascotas no hablan, pero tú entiendes su lenguaje 💬",
            "Eres la calma en su momento de miedo 💙",
            "Cada vacuna, cada revisión, cada caricia... cuenta ✨",
            "Gracias por dar salud, amor y confianza día tras día 🏥",
            "Tu vocación se nota en cada sonrisa peluda 😺",
            "Ser veterinario no es un trabajo, es una misión 💪",
            "Ellos no pueden elegir, pero tienen la suerte de tenerte 🐾",
            "Hoy hiciste el mundo un poco mejor para alguien con patas 🐕‍🦺"
        ];

        @endphp
        <p class="text-center mt-10 italic text-gray-500 text-sm">
            "{{ $frases[array_rand($frases)] }}"
        </p>
    </div>
</div>
@endsection
