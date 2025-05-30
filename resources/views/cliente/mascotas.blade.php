@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">🐾 Mis Mascotas</h1>

    @if($mascotas->count())
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($mascotas as $mascota)
                <a href="{{ route('cliente.mascota.historial', $mascota->id_mascota) }}" class="bg-white shadow hover:shadow-lg rounded-lg overflow-hidden transition">
                    <img src="{{ asset('images/mascotas/' . ($mascota->foto ?? 'default.png')) }}" alt="{{ $mascota->nombre }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-blue-800">{{ $mascota->nombre }}</h2>
                        <p class="text-sm text-gray-600">Edad: {{ \Carbon\Carbon::parse($mascota->fecha_nacimiento)->age ?? '—' }} años</p>
                        <p class="text-sm text-gray-600">Peso: {{ $mascota->ultimoHistorial->peso ?? '—' }} kg</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Aún no tienes mascotas registradas.</p>
    @endif
</div>
@endsection
