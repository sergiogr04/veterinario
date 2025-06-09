@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 pb-5">🐾 Gestión de Animales</h1>

        {{-- Encabezado con buscador y botón --}}
        <div class="flex justify-between items-center mb-4">
            <input type="text" id="filtroMascotas" placeholder="🔍 Buscar mascota o cliente..." class="border p-2 rounded w-1/2" onkeyup="filtrarTabla()">
            <button onclick="abrirModalCrear()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                ➕ Crear Mascota
            </button>
        </div>

        {{-- Tabla de mascotas --}}
        <div class="bg-white shadow-xl sm:rounded-lg overflow-x-auto">
            <table id="tablaMascotas" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-xs font-medium text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Especie</th>
                        <th class="px-6 py-3">Raza</th>
                        <th class="px-6 py-3">Dueño</th>
                        <th class="px-6 py-3">DNI Cliente</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @foreach ($mascotas as $mascota)
                    <tr>
                        <td class="px-6 py-4">{{ $mascota->nombre }}</td>
                        <td class="px-6 py-4">{{ $mascota->especie }}</td>
                        <td class="px-6 py-4">{{ $mascota->raza }}</td>
                        <td class="px-6 py-4">{{ $mascota->cliente->nombre }} {{ $mascota->cliente->apellidos }}</td>
                        <td class="px-6 py-4">{{ $mascota->cliente->dni }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <button onclick="verMascota({{ $mascota->id_mascota }})" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs">👁 Ver</button>
                            <button onclick="editarMascota({{ $mascota->id_mascota }})" class="bg-yellow-100 hover:text-yellow-800 text-yellow-600 px-3 py-1 rounded text-xs">✏️ Editar</button>
                            <button onclick="eliminarMascota({{ $mascota->id_mascota }})" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs">🗑 Eliminar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- TOAST (para mensajes) --}}
<div id="toast" class="fixed bottom-5 right-5 z-50 hidden bg-green-600 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300"></div>

{{-- Modales --}}
@include('trabajador.mascotas.partials.modales')

{{-- Script buscador --}}
<script>
function filtrarTabla() {
    const input = document.getElementById('filtroMascotas').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaMascotas tbody tr');

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(input) ? '' : 'none';
    });
}
</script>
<script>
function cerrarModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function abrirModalCrear() {
    document.getElementById('modalCrear').classList.remove('hidden');
}

// Buscar cliente por DNI
document.getElementById('dniClienteInput').addEventListener('input', function () {
    const dni = this.value;
    if (dni.length >= 5) {
        fetch(`/trabajador/clientes/dni/${dni}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('nombreClientePreview').value = data.nombre + ' ' + data.apellidos;
                document.getElementById('clienteIdInput').value = data.id;
            } else {
                document.getElementById('nombreClientePreview').value = 'No encontrado';
                document.getElementById('clienteIdInput').value = '';
            }
        });
    }
});

// Ver mascota
function verMascota(id) {
    fetch(`/trabajador/mascotas/${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('ver_nombre').textContent = data.nombre;
        document.getElementById('ver_edad').textContent = calcularEdad(data.fecha_nacimiento) + ' años';
        document.getElementById('ver_especie').textContent = data.especie;
        document.getElementById('ver_raza').textContent = data.raza;
        document.getElementById('ver_peso').textContent = data.peso !== null ? data.peso + ' kg': 'Debe pesarse en la siguiente consulta';
        document.getElementById('ver_dueno').textContent = data.cliente.nombre + ' ' + data.cliente.apellidos + ' (' + data.cliente.dni + ')';
        document.getElementById('ver_foto').src = `/images/mascotas/${data.foto ?? 'default.webp'}`;

        const tabla = document.getElementById('tablaHistorial');
        tabla.innerHTML = '';

        if (data.historial.length > 0) {
            data.historial.forEach(h => {
                tabla.innerHTML += `
                    <tr>
                        <td class="px-2 py-1">${h.fecha}</td>
                        <td class="px-2 py-1">${h.peso} kg</td>
                        <td class="px-2 py-1">${h.descripcion.slice(0, 30)}...</td>
                        <td class="px-2 py-1 text-center">
                            <button class="text-blue-600 hover:underline" onclick="verHistorial('${h.fecha}', '${h.peso}', \`${h.descripcion.replace(/`/g, '\\`')}\`)">Ver</button>
                        </td>
                    </tr>`;
            });
        } else {
            tabla.innerHTML = `<tr><td colspan="4" class="text-center py-2">Sin historial médico</td></tr>`;
        }

        document.getElementById('modalVer').classList.remove('hidden');
    });
}

// Ver historial individual
function verHistorial(fecha, peso, descripcion) {
    document.getElementById('detalle_fecha').textContent = fecha;
    document.getElementById('detalle_peso').textContent = peso + ' kg';
    document.getElementById('detalle_descripcion').textContent = descripcion;
    document.getElementById('modalHistorial').classList.remove('hidden');
}

// Editar mascota
function editarMascota(id) {
    fetch(`/trabajador/mascotas/${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('editar_id').value = data.id_mascota;
        document.getElementById('editar_nombre').value = data.nombre;
        document.getElementById('editar_especie').value = data.especie;
        document.getElementById('editar_raza').value = data.raza;
        document.getElementById('editar_fecha').value = data.fecha_nacimiento;

        document.getElementById('modalEditar').classList.remove('hidden');
    });
}

// Envío formulario crear
document.getElementById('formCrearMascota').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('/trabajador/mascotas', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Mascota creada correctamente", "success");
            location.reload();
        } else {
            showToast("Error al crear mascota", "error");
        }
    });
});

// Envío formulario editar
document.getElementById('formEditarMascota').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('editar_id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/trabajador/mascotas/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Mascota actualizada", "success");
            location.reload();
        } else {
            showToast("Error al actualizar", "error");
        }
    });
});

// Eliminar
function eliminarMascota(id) {
    if (!confirm("¿Seguro que quieres eliminar esta mascota?")) return;

    fetch(`/trabajador/mascotas/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Mascota eliminada", "success");
            location.reload();
        } else {
            showToast("Error al eliminar", "error");
        }
    });
}

function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mes = hoy.getMonth() - nacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
}
</script>

@endsection
