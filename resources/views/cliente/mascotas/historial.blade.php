@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-blue-800 mb-4">📋 Historial de {{ $mascota->nombre }}</h1>

    <div class="bg-white shadow p-6 rounded-lg mb-6">
        <p><strong>Especie:</strong> {{ $mascota->especie }}</p>
        <p><strong>Raza:</strong> {{ $mascota->raza ?? '—' }}</p>
        <p><strong>Edad:</strong> {{ \Carbon\Carbon::parse($mascota->fecha_nacimiento)->age }} años</p>
    </div>

    @if ($mascota->historial->count())
        <div class="space-y-4">
            @foreach ($mascota->historial->sortByDesc('fecha') as $entrada)
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($entrada->fecha)->translatedFormat('d F Y') }}</p>
                    <p class="mt-1 text-gray-800">{{ $entrada->descripcion }}</p>
                    <p class="text-sm text-gray-600 mt-1">Peso registrado: {{ $entrada->peso ?? '—' }} kg</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No hay historial disponible para esta mascota.</p>
    @endif
</div>
@endsection
