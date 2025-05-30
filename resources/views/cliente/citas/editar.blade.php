@extends('layouts.app')
@vite('resources/css/citas.css')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">✏️ Editar Cita</h1>

    <form action="{{ route('cliente.citas.actualizar', $cita->id_cita) }}" method="POST" class="bg-white shadow rounded p-6">
        @csrf
        @method('PUT')

        {{-- Fecha --}}
        <label class="block mb-2 text-sm font-medium">Fecha</label>
        <input type="date" name="fecha" value="{{ $cita->fecha }}" class="w-full border px-3 py-2 rounded mb-4" onchange="cargarHorasDisponibles(this.value)" required>

        {{-- Hora --}}
<label class="block mb-2 text-sm font-medium">Hora</label>
<select name="hora" id="horasDisponibles" class="w-full border px-3 py-2 rounded mb-4" required>
    <option value="">Cargando...</option>
</select>


        {{-- Tipo --}}
        <label class="block mb-2 text-sm font-medium">Tipo de cita</label>
        <select name="tipo" class="w-full border px-3 py-2 rounded mb-4" required>
            <option value="urgencia" {{ $cita->tipo === 'urgencia' ? 'selected' : '' }}>Urgencia</option>
            <option value="consulta" {{ $cita->tipo === 'consulta' ? 'selected' : '' }}>Consulta</option>
            <option value="revision" {{ $cita->tipo === 'revision' ? 'selected' : '' }}>Revisión</option>
            <option value="vacuna" {{ $cita->tipo === 'vacuna' ? 'selected' : '' }}>Vacuna</option>
        </select>

        {{-- Síntomas --}}
        <label class="block mb-2 text-sm font-medium">Síntomas</label>
        <textarea name="sintomas" rows="3" class="w-full border px-3 py-2 rounded mb-4" required>{{ $cita->sintomas }}</textarea>

        {{-- Mascota --}}
        <label class="block mb-2 text-sm font-medium">Mascota</label>
        <select name="id_mascota" class="w-full border px-3 py-2 rounded mb-4" required>
            @foreach (Auth::user()->mascotas as $m)
                <option value="{{ $m->id_mascota }}" {{ $cita->id_mascota == $m->id_mascota ? 'selected' : '' }}>
                    {{ $m->nombre }}
                </option>
            @endforeach
        </select>

        <div class="flex justify-between gap-4">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                💾 Guardar Cambios
            </button>
            <a href="{{ route('cliente.citas', ['misCitas' => 1]) }}" class="w-full bg-gray-300 text-gray-800 py-2 rounded hover:bg-gray-400 text-center">
                ❌ Cancelar
            </a>
        </div>

    </form>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fecha = document.querySelector('input[name="fecha"]').value;
    const selectHoras = document.getElementById('horasDisponibles');
    const horaSeleccionada = "{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}";

    fetch(`/cliente/citas/disponibles/${fecha}`)
        .then(res => res.json())
        .then(data => {
            selectHoras.innerHTML = '';

            if (data.length === 0) {
                selectHoras.innerHTML = '<option value="">No hay horas disponibles</option>';
                return;
            }

            data.forEach(hora => {
                const opt = document.createElement('option');
                opt.value = hora;
                opt.textContent = hora;
                if (hora === horaSeleccionada) {
                    opt.selected = true;
                }
                selectHoras.appendChild(opt);
            });
        });
});
function cargarHorasDisponibles(fecha) {
    const selectHoras = document.getElementById('horasDisponibles');

    fetch(`/cliente/citas/disponibles/${fecha}`)
        .then(res => res.json())
        .then(data => {
            selectHoras.innerHTML = '';

            if (data.length === 0) {
                selectHoras.innerHTML = '<option value="">No hay horas disponibles</option>';
                return;
            }

            data.forEach(hora => {
                const opt = document.createElement('option');
                opt.value = hora;
                opt.textContent = hora;
                selectHoras.appendChild(opt);
            });
        });
}

</script>
