@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 animate-fade-in">
    <h1 class="text-4xl font-bold text-blue-800 mb-8 flex items-center gap-2">
        🐾 Historial de {{ $mascota->nombre }}
    </h1>

    {{-- Ficha de la mascota --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-10 transition transform hover:scale-[1.01] duration-200">
        <img src="{{ asset('images/mascotas/' . ($mascota->foto ?? 'default.png')) }}"
             alt="{{ $mascota->nombre }}"
             class="w-full h-64 object-cover">
        
        <div class="p-6 space-y-2">
            <p class="text-lg"><strong>📘 Especie:</strong> {{ $mascota->especie }}</p>
            <p class="text-lg"><strong>📖 Raza:</strong> {{ $mascota->raza ?? '—' }}</p>
            <p class="text-lg"><strong>🎂 Edad:</strong> {{ \Carbon\Carbon::parse($mascota->fecha_nacimiento)->age }} años</p>
            <p class="text-lg"><strong>🧪 Último peso registrado:</strong> 
                {{ $mascota->ultimoHistorial->peso ?? '—' }} kg
            </p>
        </div>
    </div>

    {{-- Historial --}}
    <h2 class="text-2xl font-semibold text-blue-700 mb-4">📅 Registros</h2>

    @if ($mascota->historial->count())
        <div class="space-y-4">
            @foreach ($mascota->historial->sortByDesc('fecha') as $entrada)
                <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg shadow hover:shadow-lg transition duration-200">
                    <p class="text-sm text-gray-500 font-medium">
                        {{ \Carbon\Carbon::parse($entrada->fecha)->translatedFormat('l d F Y') }}
                    </p>
                    <p class="mt-2 text-gray-800 text-base">📝 {{ $entrada->descripcion }}</p>
                    <p class="text-sm text-blue-800 mt-1">⚖️ Peso: {{ $entrada->peso ?? '—' }} kg</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600 italic">No hay historial disponible para esta mascota.</p>
    @endif
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out both;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
