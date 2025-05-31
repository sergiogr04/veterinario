@extends('layouts.app')
@vite('resources/css/citas.css')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-4xl font-extrabold text-blue-800 mb-10 animate__animated animate__fadeInDown">🐾 Panel de Cliente</h1>

    {{-- Bloques de acceso rápido --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 animate__animated animate__fadeInUp">
        {{-- Ver Mascotas --}}
        <a href="{{ route('cliente.mascotas') }}" class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition group">
            <div class="text-blue-700 text-3xl mb-2 group-hover:scale-105 transition">🐶</div>
            <h2 class="text-xl font-semibold text-blue-800 group-hover:underline">Mis Mascotas</h2>
            <p class="text-gray-600">Consulta el historial, edad, peso y foto de tus mascotas registradas.</p>
        </a>

        {{-- Pedir Cita --}}
        <a href="{{ route('cliente.citas') }}" class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition group">
            <div class="text-green-700 text-3xl mb-2 group-hover:scale-105 transition">📅</div>
            <h2 class="text-xl font-semibold text-blue-800 group-hover:underline">Pedir Cita</h2>
            <p class="text-gray-600">Consulta los días disponibles y reserva una cita para tu mascota.</p>
        </a>

        {{-- Contactar --}}
        <a href="{{ route('cliente.contacto') }}" class="bg-white p-6 shadow rounded-lg hover:shadow-lg transition group">
            <div class="text-purple-700 text-3xl mb-2 group-hover:scale-105 transition">📨</div>
            <h2 class="text-xl font-semibold text-blue-800 group-hover:underline">Contacto</h2>
            <p class="text-gray-600">¿Dudas o urgencias? Envíanos un mensaje desde aquí.</p>
        </a>
    </div>

    {{-- Tarjetas resumen --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 animate__animated animate__fadeInUp">
    <div class="bg-white p-6 shadow rounded-lg text-center">
        <p class="text-5xl font-bold text-blue-700 mb-2">{{ $totalMascotas }}</p>
        <h2 class="text-lg font-semibold text-gray-700">Mascotas Registradas</h2>
    </div>
    <div class="bg-white p-6 shadow rounded-lg text-center">
        <p class="text-5xl font-bold text-green-600 mb-2">{{ $citasFuturas }}</p>
        <h2 class="text-lg font-semibold text-gray-700">Citas Pendientes</h2>
    </div>
    <div class="bg-white p-6 shadow rounded-lg text-center">
        <canvas id="graficaTiposCita" height="80"></canvas>
    </div>
</div>


    {{-- Últimas citas --}}
    <div class="bg-white shadow rounded-lg p-6 animate__animated animate__fadeInUp">
        <h3 class="text-2xl font-bold text-blue-800 mb-4">📋 Tus Últimas Citas</h3>

        @if($ultimasCitas->isEmpty())
            <p class="text-gray-600">Aún no has reservado ninguna cita.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($ultimasCitas as $cita)
                    <li class="py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-lg text-gray-800 font-semibold">{{ $cita->tipo }} con {{ $cita->mascota->nombre }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}h
                                </p>
                                <p class="text-sm text-gray-600">Síntomas: {{ $cita->sintomas }}</p>
                            </div>
                            <div>
                                @php
                                    $pasada = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cita->fecha . ' ' . $cita->hora)->isPast();
                                @endphp

                                @if(!$pasada)
                                    <form action="{{ route('cliente.citas.editar') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="id_cita" value="{{ $cita->id_cita }}">
                                        <button class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Editar</button>
                                    </form>
                                    <button onclick="eliminarCita({{ $cita->id_cita }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                                @else
                                    <span class="text-gray-400 italic">Finalizada</span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script>
    function eliminarCita(id) {
        if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
            fetch(`/cliente/citas/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ _method: 'DELETE' })
            })
            .then(res => {
                if (res.ok) location.reload();
                else alert('No se pudo eliminar la cita');
            });
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficaTiposCita').getContext('2d');
    const tipos = @json($tiposCitas->keys());
    const cantidades = @json($tiposCitas->values());

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: tipos,
            datasets: [{
                label: 'Tipos de cita',
                data: cantidades,
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

@endsection
