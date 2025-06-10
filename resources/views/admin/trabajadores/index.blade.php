@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 pb-5">🧑‍💼 Gestión de Trabajadores</h1>

        <div class="flex justify-between items-center mb-6">
            <input type="text" id="filtroTrabajadores" placeholder="🔍 Buscar trabajador..." class="border p-2 rounded w-1/2" onkeyup="filtrarTabla()">
            <button onclick="abrirModalCrear()" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow transition">
                ➕ Crear Trabajador
            </button>
        </div>

        {{-- Tabla de trabajadores responsiva --}}
<div class="overflow-x-auto">
    <div class="min-w-full inline-block align-middle">
        <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5">
            <table class="min-w-full divide-y divide-gray-200" id="tablaTrabajadores">
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
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @foreach ($trabajadores as $t)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $t->dni }}</td>
                            <td class="px-6 py-4">{{ $t->nombre }}</td>
                            <td class="px-6 py-4">{{ $t->apellidos }}</td>
                            <td class="py-4">{{ $t->telefono ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $t->email }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="verTrabajador({{ $t->id_usuario }})" class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs">👁 Ver</button>
                                <button onclick="editarTrabajador({{ $t->id_usuario }})" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs">✏️ Editar</button>
                                <button onclick="eliminarTrabajador({{ $t->id_usuario }})" class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs">🗑 Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


        {{-- Toast --}}
        <div id="toast" class="hidden fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg"></div>
    </div>
</div>

{{-- Modales --}}
@include('admin.trabajadores.partials.modales')

<script>
function filtrarTabla() {
    const input = document.getElementById('filtroTrabajadores').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaTrabajadores tbody tr');

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(input) ? '' : 'none';
    });
}
</script>
<script>
function filtrarTabla() {
    const input = document.getElementById('filtroTrabajadores').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaTrabajadores tbody tr');

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(input) ? '' : 'none';
    });
}

function abrirModalCrear() {
    document.getElementById('modalCrear').classList.remove('hidden');
}

function cerrarModal(id) {
    document.getElementById(id).classList.add('hidden');
}

// Ver trabajador
function verTrabajador(id) {
    fetch(`/admin/trabajadores/${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('ver_dni').textContent = data.dni;
        document.getElementById('ver_nombre').textContent = data.nombre;
        document.getElementById('ver_apellidos').textContent = data.apellidos;
        document.getElementById('ver_email').textContent = data.email;
        document.getElementById('ver_telefono').textContent = data.telefono || '—';
        document.getElementById('ver_direccion').textContent = data.direccion || '—';
        document.getElementById('modalVer').classList.remove('hidden');
    });
}

// Editar trabajador
function editarTrabajador(id) {
    fetch(`/admin/trabajadores/${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('editar_id').value = id;
        document.getElementById('editar_dni').value = data.dni;
        document.getElementById('editar_nombre').value = data.nombre;
        document.getElementById('editar_apellidos').value = data.apellidos;
        document.getElementById('editar_telefono').value = data.telefono || '';
        document.getElementById('editar_email').value = data.email;
        document.getElementById('editar_password').value = ''; // vacío por seguridad
        document.getElementById('modalEditar').classList.remove('hidden');
    });
}

// Formulario CREAR trabajador
document.getElementById('formCrearTrabajador').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = new FormData(this);
    const erroresDiv = document.getElementById('erroresCrearTrabajador');
    erroresDiv.classList.add('hidden');
    erroresDiv.innerHTML = '';

    fetch(`/admin/trabajadores`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                mostrarToast("Error inesperado al crear trabajador", "error");
            }
            return;
        }

        const data = await res.json();

        if (data.success) {
            mostrarToast('Trabajador creado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarToast('Error al crear trabajador', 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        mostrarToast('Error de conexión con el servidor', 'error');
    });
});


document.getElementById('formEditarTrabajador').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('editar_id').value;
    const form = new FormData(this);
    form.append('_method', 'PUT');

    const erroresDiv = document.getElementById('erroresEditarTrabajador');
    erroresDiv.classList.add('hidden');
    erroresDiv.innerHTML = '';

    fetch(`/admin/trabajadores/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                mostrarToast('Error inesperado al actualizar trabajador', 'error');
            }
            return;
        }

        const data = await res.json();
        if (data.success) {
            mostrarToast('Trabajador actualizado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarToast('Error al actualizar trabajador', 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        mostrarToast('Error de conexión con el servidor', 'error');
    });
});


// Eliminar trabajador
function eliminarTrabajador(id) {
    if (!confirm('¿Eliminar este trabajador?')) return;

    fetch(`/admin/trabajadores/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            mostrarToast('Trabajador eliminado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarToast('Error al eliminar trabajador', 'error');
        }
    });
}

// Toast
function mostrarToast(mensaje, tipo = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = mensaje;
    toast.className = `fixed bottom-5 right-5 z-50 px-4 py-2 rounded shadow-lg text-white transition-opacity duration-300 ${
        tipo === 'success' ? 'bg-green-600' :
        tipo === 'error'   ? 'bg-red-600'   :
        'bg-gray-600'
    }`;

    toast.classList.remove('hidden');

    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('opacity-0');
        }, 500);
    }, 3000);
}
</script>

@endsection
