@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 pb-5">📅 Gestión de Citas</h1>
    {{-- Encabezado con buscador y botón --}}
    <div class="flex justify-between items-center mb-4">
        <input type="text" id="filtroMascotas" placeholder="🔍 Buscar mascota o cliente..." class="border p-2 rounded w-1/2" onkeyup="filtrarTabla()">
        <button onclick="reservarCita()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">📋 Reservar cita</button>
    </div>
    <h2 class="text-xl font-semibold text-gray-700 mb-2">🔴 Citas para hoy</h2>
    <div class="overflow-x-auto mb-6">
    <table class="w-full text-sm bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-blue-50 text-blue-900 font-semibold">
        <tr>
            <th class="px-4 py-3 text-left">Mascota</th>
            <th class="px-4 py-3 text-left">Dueño</th>
            <th class="px-4 py-3 text-left">DNI</th>
            <th class="px-4 py-3 text-left">Hora</th>
            <th class="px-4 py-3 text-left">Tipo</th>
            <th class="px-4 py-3 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse ($citasHoy as $cita)
        <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-3">{{ $cita->mascota->nombre }}</td>
            <td class="px-4 py-3">{{ $cita->mascota->cliente->nombre }} {{ $cita->mascota->cliente->apellidos }}</td>
            <td class="px-4 py-3">{{ $cita->mascota->cliente->dni }}</td>
            <td class="px-4 py-3">{{ $cita->hora }}</td>
            <td class="px-4 py-3">{{ ucfirst($cita->tipo) }}</td>
            <td class="px-4 py-3 space-x-2 text-center">
                <button onclick="verCita({{ $cita->id_cita }})" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs">👁 Ver</button>
                <button onclick="atenderCita({{ $cita->id_cita }})" class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded text-xs">✅ Atender</button>
                <button onclick="eliminarCita({{ $cita->id_cita }})" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs">🗑 Eliminar</button>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-4 text-gray-500">Sin citas hoy</td></tr>
        @endforelse
    </tbody>
</table>

    </div>

    <h2 class="text-xl font-semibold text-gray-700 mb-2">🟢 Próximas citas</h2>
    <div class="w-full overflow-x-auto">
    <table id="tablaCitas" class="min-w-full text-sm text-left bg-white rounded shadow">
    <thead class="bg-gray-100 text-gray-600 uppercase">
    <tr>
        <th class="px-4 py-2">Fecha</th>
        <th class="px-4 py-2">Hora</th>
        <th class="px-4 py-2">Mascota</th>
        <th class="px-4 py-2">Dueño</th>
        <th class="px-4 py-2">DNI</th>
        <th class="px-4 py-2">Tipo</th>
        <th class="px-4 py-2 text-center">Acciones</th>
    </tr>
</thead>
<tbody>
    @forelse ($citasFuturas as $cita)
    <tr class="border-b">
        <td class="px-4 py-2">{{ $cita->fecha }}</td>
        <td class="px-4 py-2">{{ $cita->hora }}</td>
        <td class="px-4 py-2">{{ $cita->mascota->nombre }}</td>
        <td class="px-4 py-2">{{ $cita->mascota->cliente->nombre }} {{ $cita->mascota->cliente->apellidos }}</td>
        <td class="px-4 py-2">{{ $cita->mascota->cliente->dni }}</td>
        <td class="px-4 py-2">{{ ucfirst($cita->tipo) }}</td>
        <td class="px-4 py-2 text-center space-x-2">
            <button onclick="verCita({{ $cita->id_cita }})" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs">👁 Ver</button>
            <button onclick="eliminarCita({{ $cita->id_cita }})" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs">🗑 Eliminar</button>
        </td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center py-3 text-gray-500">Sin próximas citas</td></tr>
    @endforelse
</tbody>

    </table>
</div>

</div>

@include('trabajador.citas.partials.modal')
<script>
function filtrarTabla() {
    const input = document.getElementById('filtroMascotas').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaCitas tbody tr');

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(input) ? '' : 'none';
    });
}
function reservarCita() {
    document.getElementById('formularioCita').classList.remove('hidden');

    const fechaInput = document.querySelector('input[name="fecha"]');
    if (fechaInput && fechaInput.value) {
        cargarHorasDisponibles(fechaInput.value);
    }
}


function buscarMascotasPorDni(dni) {
    const select = document.getElementById('select_mascotas');

    if (dni.length !== 9) {
        select.innerHTML = '<option value="">Selecciona una mascota</option>';
        return;
    }

    fetch('/trabajador/citas/mascotas-por-dni?dni=' + dni)
        .then(res => res.json())
        .then(mascotas => {
            select.innerHTML = '<option value="">Selecciona una mascota</option>';
            mascotas.forEach(m => {
                const option = document.createElement('option');
                option.value = m.id_mascota;
                option.textContent = m.nombre;
                select.appendChild(option);
            });
        });
}

function cargarHorasDisponibles(fecha) {
    const select = document.getElementById('horasDisponibles');
    select.innerHTML = '<option value="">Cargando...</option>';

    fetch(`/trabajador/citas/horas-disponibles?fecha=${fecha}`)
    .then(res => res.json())
        .then(horas => {
            select.innerHTML = '<option value="">Selecciona una hora</option>';
            if (horas.length === 0) {
                select.innerHTML = '<option value="">Sin horas disponibles</option>';
            } else {
                horas.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora + ':00';
                    option.textContent = hora;
                    select.appendChild(option);
                });
            }
        });
}


document.getElementById('formCrearCita').addEventListener('submit', function (e) {
    e.preventDefault();

    const erroresDiv = document.getElementById('erroresCrear');
    erroresDiv.classList.add('hidden');
    erroresDiv.innerHTML = '';

    const formData = new FormData(this);

    fetch('/trabajador/citas/crear', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Cita creada correctamente", "success");
            location.reload();
        } else if (data.errors) {
            erroresDiv.classList.remove('hidden');
            data.errors.forEach(err => {
                erroresDiv.innerHTML += `<div>• ${err}</div>`;
            });
        }
    })
    .catch(() => {
        erroresDiv.classList.remove('hidden');
        erroresDiv.innerHTML = 'Error inesperado. Inténtalo de nuevo.';
    });
});


function cerrarModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');

    if (id === 'formularioCita') {
        const form = document.getElementById('formCrearCita');
        form.reset();

        // Reset select de mascotas manualmente
        const selectMascotas = document.getElementById('select_mascotas');
        selectMascotas.innerHTML = '<option value="">Selecciona una mascota</option>';

        // Limpiar el select de horas
        const selectHoras = document.getElementById('horasDisponibles');
        selectHoras.innerHTML = '<option value="">Cargando...</option>';

        // Ocultar errores si quedaron visibles
        const errores = document.getElementById('erroresCrear');
        errores.classList.add('hidden');
        errores.innerHTML = '';
    }
}


// Ver Cita
function verCita(id) {
    fetch(`/trabajador/citas/${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('ver_mascota').textContent = data.mascota.nombre;
            document.getElementById('ver_dueno').textContent = data.mascota.cliente.nombre + ' ' + data.mascota.cliente.apellidos;
            document.getElementById('ver_hora').textContent = data.hora;
            document.getElementById('ver_tipo').textContent = data.tipo;
            document.getElementById('ver_sintomas').textContent = data.sintomas;

            const historial = document.getElementById('ver_historial');
            historial.innerHTML = '';
            if (data.mascota.historial.length > 0) {
                data.mascota.historial.forEach(item => {
                    historial.innerHTML += `<li>${item.fecha} - ${item.peso ?? 'Sin peso'}kg - ${item.descripcion.slice(0, 40)}...</li>`;
                });
            } else {
                historial.innerHTML = '<li>Sin historial</li>';
            }

            document.getElementById('modalVer').classList.remove('hidden');
        });
}

//  Atender Cita
function atenderCita(id) {
    fetch(`/trabajador/citas/${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('atender_id').value = data.id_cita;
            document.getElementById('atender_mascota').textContent = data.mascota.nombre;
            document.getElementById('atender_dueno').textContent = data.mascota.cliente.nombre + ' ' + data.mascota.cliente.apellidos;
            document.getElementById('atender_hora').textContent = data.hora;
            document.getElementById('atender_tipo').textContent = data.tipo;
            document.getElementById('atender_sintomas').textContent = data.sintomas;

            document.getElementById('modalAtender').classList.remove('hidden');
        });
}

// Guardar formulario de atención
document.getElementById('formAtender').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('atender_id').value;
    const formData = new FormData(this);

    fetch(`/trabajador/citas/${id}/atender`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Cita atendida correctamente", "success");
            location.reload();
        } else {
            setTimeout(() => location.reload(), 2000);
        }
    });
});

//  Eliminar Cita
function eliminarCita(id) {
    if (!confirm("¿Seguro que quieres eliminar esta cita?")) return;

    fetch(`/trabajador/citas/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Cita eliminada", "success");
            setTimeout(() => location.reload(), 2000);
        } else {
            showToast("Error al eliminar cita", "error");
        }
    });
}

</script>

@endsection

