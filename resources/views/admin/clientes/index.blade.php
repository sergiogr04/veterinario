@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 pb-5">👥 Gestión de Clientes</h1>

        {{-- Título y botón --}}
        <div class="flex items-center justify-between mb-6">
            <input type="text" id="filtroMascotas" placeholder="🔍 Buscar mascota o cliente..." class="border p-2 rounded w-1/2" onkeyup="filtrarTabla()">
            <button onclick="abrirModalCrear()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow transition">
                ➕ Crear Cliente
            </button>
        </div>

        {{-- Tabla de clientes responsiva --}}
<div class="overflow-x-auto">
    <div class="min-w-full inline-block align-middle">
        <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">DNI</th>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Apellidos</th>
                        <th class="px-6 py-3 text-left">Teléfono</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                    @forelse ($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->dni }}</td>
                            <td class="px-6 py-4">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4">{{ $cliente->apellidos }}</td>
                            <td class="px-6 py-4">{{ $cliente->telefono ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $cliente->email }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="verCliente({{ $cliente->id_usuario }})" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs">👁 Ver</button>
                                <button onclick="editarCliente({{ $cliente->id_usuario }})" class="bg-yellow-100 hover:text-yellow-800 text-yellow-600 px-3 py-1 rounded text-xs">✏️ Editar</button>
                                <button onclick="eliminarCliente({{ $cliente->id_usuario }})" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs">🗑 Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay clientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    </div>
</div>

{{-- Modales --}}
@include('admin.clientes.partials.modales')
{{-- Script buscador --}}
<script>
function filtrarTabla() {
    const input = document.getElementById('filtroMascotas').value.toLowerCase();
    const filas = document.querySelectorAll('table tbody tr');


    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(input) ? '' : 'none';
    });
}
</script>
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

function abrirModalCrear() {
    document.getElementById('modalCrear').classList.remove('hidden');
}
function cerrarModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function verCliente(id) {
    fetch(`/admin/clientes/${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('ver_dni').textContent = data.dni;
        document.getElementById('ver_nombre').textContent = data.nombre;
        document.getElementById('ver_apellidos').textContent = data.apellidos;
        document.getElementById('ver_email').textContent = data.email;
        document.getElementById('ver_telefono').textContent = data.telefono || '-';
        document.getElementById('ver_direccion').textContent = data.direccion || '-';

        const tabla = document.getElementById('tablaMascotas');
        tabla.innerHTML = '';
        if (data.mascotas.length > 0) {
            data.mascotas.forEach(m => {
                tabla.innerHTML += `
                    <tr>
                        <td class="px-2 py-1">${m.nombre}</td>
                        <td class="px-2 py-1">${m.especie}</td>
                        <td class="px-2 py-1">${m.raza}</td>
                        <td class="px-2 py-1">${m.fecha_nacimiento}</td>
                        <td class="px-2 py-1 text-center">
                        <button onclick="verHistorialMascota(${m.id_mascota}, '${m.nombre}')" class="text-blue-600 hover:underline">Ver Historial</button>
                        </td>
                    </tr>`;
            });
        } else {
            tabla.innerHTML = '<tr><td colspan="5" class="text-center py-2">Sin mascotas registradas</td></tr>';
        }

        document.getElementById('modalVer').classList.remove('hidden');
    });
}
function verHistorialMascota(idMascota, nombre) {
    fetch(`/admin/mascotas/historial/${idMascota}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('historial_titulo').textContent = `📋 Historial médico de ${nombre}`;
            const cuerpo = document.getElementById('tablaHistorial');
            cuerpo.innerHTML = '';

            if (data.length > 0) {
                data.forEach(item => {
                    cuerpo.innerHTML += `
                        <tr>
                            <td class="px-3 py-2">${item.fecha}</td>
                            <td class="px-3 py-2">${item.peso ?? '—'} kg</td>
                            <td class="px-3 py-2">${item.descripcion.slice(0, 40)}...</td>
                            <td class="px-3 py-2 text-center">
                                <button onclick="detalleHistorial('${item.fecha}', '${item.peso ?? '—'}', \`${item.descripcion.replace(/`/g, '\\`')}\`)" class="text-blue-600 hover:underline">Ver</button>
                            </td>
                        </tr>`;
                });
            } else {
                cuerpo.innerHTML = '<tr><td colspan="4" class="text-center py-2 text-gray-500">Sin historial</td></tr>';
            }

            document.getElementById('modalHistorial').classList.remove('hidden');
        });
}

function detalleHistorial(fecha, peso, descripcion) {
    document.getElementById('detalle_fecha').textContent = fecha;
    document.getElementById('detalle_peso').textContent = peso + ' kg';
    document.getElementById('detalle_descripcion').textContent = descripcion;
    document.getElementById('modalDetalleHistorial').classList.remove('hidden');
}

function editarCliente(id) {
    fetch(`/admin/clientes/${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('editar_id').value = id;
        document.getElementById('editar_nombre').value = data.nombre;
        document.getElementById('editar_apellidos').value = data.apellidos;
        document.getElementById('editar_telefono').value = data.telefono || '';
        document.getElementById('editar_direccion').value = data.direccion || '';
        document.getElementById('editar_dni').value = data.dni;
        document.getElementById('editar_email').value = data.email;

        document.getElementById('modalEditar').classList.remove('hidden');
    });
}

document.getElementById('formEditar').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('editar_id').value;
    const form = new FormData(this);
    form.append('_method', 'PUT');

    const erroresDiv = document.getElementById('erroresEditar');
    erroresDiv.classList.add('hidden');
    erroresDiv.innerHTML = '';

    fetch(`/admin/clientes/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: form
    })
    .then(async res => {
        if (!res.ok) {
            const data = await res.json();
            if (res.status === 422 && data.errors) {
                erroresDiv.classList.remove('hidden');
                Object.values(data.errors).forEach(mensajes => {
                    mensajes.forEach(mensaje => {
                        erroresDiv.innerHTML += `<div>• ${mensaje}</div>`;
                    });
                });
                erroresDiv.scrollIntoView({ behavior: 'smooth' });
            } else {
                showToast('Error inesperado al actualizar cliente', 'error');
            }
            return;
        }

        const data = await res.json();

        if (data.success) {
            showToast('Cliente actualizado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Error al actualizar cliente', 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        showToast('Error de conexión con el servidor', 'error');
    });
});


document.getElementById('formCrear').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = new FormData(this);
    const erroresDiv = document.getElementById('erroresCrear');
    erroresDiv.classList.add('hidden');
    erroresDiv.innerHTML = '';

    fetch(`/admin/clientes`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: form
    })
    .then(async res => {
        if (!res.ok) {
            const data = await res.json();
            if (res.status === 422 && data.errors) {
                erroresDiv.classList.remove('hidden');
                Object.values(data.errors).forEach(mensajes => {
                    mensajes.forEach(mensaje => {
                        erroresDiv.innerHTML += `<div>• ${mensaje}</div>`;
                    });
                });
                erroresDiv.scrollIntoView({ behavior: 'smooth' });
            } else {
                showToast('Error inesperado al crear cliente', 'error');
            }
            return;
        }

        const data = await res.json();

        if (data.success) {
            showToast('Cliente creado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Error al crear cliente', 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        showToast('Error de conexión con el servidor', 'error');
    });
});


function eliminarCliente(id) {
    if (!confirm('¿Eliminar este cliente?')) return;

    fetch(`/admin/clientes/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('Cliente eliminado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Error al eliminar cliente', 'error');
        }
    });
}
</script>

@endsection

