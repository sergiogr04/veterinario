{{-- ➕ MODAL CREAR MASCOTA --}}
<div id="modalCrear" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-xl w-full overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">➕ Crear Mascota</h2>
        <div id="erroresCrearMascota" class="mb-4 hidden bg-red-100 border border-red-300 text-red-700 text-sm rounded p-3"></div>
        <form id="formCrearMascota" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4 text-sm">
                <input type="text" name="nombre" placeholder="Nombre" class="border p-2 rounded" required>
                <input type="text" name="especie" placeholder="Especie" class="border p-2 rounded" required>
                <input type="text" name="raza" placeholder="Raza" class="border p-2 rounded" required>
                <input type="date" name="fecha_nacimiento" placeholder="Nacimiento" class="border p-2 rounded" required>

                <input type="text" id="dniClienteInput" placeholder="DNI del cliente" class="border p-2 rounded col-span-2" required>
                <input type="text" id="nombreClientePreview" disabled placeholder="Nombre del cliente" class="border p-2 rounded col-span-2 bg-gray-100">

                <input type="file" name="foto" accept="image/*" class="col-span-2 border p-2 rounded">
            </div>

            <input type="hidden" name="id_cliente" id="clienteIdInput">

            <div class="mt-4 text-right space-x-2">
                <button type="button" onclick="cerrarModal('modalCrear')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Crear</button>
            </div>
        </form>
    </div>
</div>

{{-- 📝 MODAL EDITAR MASCOTA --}}
<div id="modalEditar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-xl w-full">
        <h2 class="text-xl font-semibold mb-4">✏️ Editar Mascota</h2>
        <form id="formEditarMascota" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="editar_id" name="id">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <input type="text" id="editar_nombre" name="nombre" placeholder="Nombre" class="border p-2 rounded" required>
                <input type="text" id="editar_especie" name="especie" placeholder="Especie" class="border p-2 rounded" required>
                <input type="text" id="editar_raza" name="raza" placeholder="Raza" class="border p-2 rounded" required>
                <input type="date" id="editar_fecha" name="fecha_nacimiento" class="border p-2 rounded" required>
                <input type="file" name="foto" accept="image/*" class="col-span-2 border p-2 rounded">
            </div>

            <div class="mt-4 text-right space-x-2">
                <button type="button" onclick="cerrarModal('modalEditar')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- 👁 MODAL VER MASCOTA --}}
<div id="modalVer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">👁 Detalles de la Mascota</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><strong>Nombre:</strong> <span id="ver_nombre"></span></p>
            <p><strong>Edad:</strong> <span id="ver_edad"></span></p>
            <p><strong>Especie:</strong> <span id="ver_especie"></span></p>
            <p><strong>Raza:</strong> <span id="ver_raza"></span></p>
            <p><strong>Peso:</strong> <span id="ver_peso"></span></p>
            <p><strong>Dueño:</strong> <span id="ver_dueno"></span></p>
            <div class="col-span-2">
                <strong>📸 Foto:</strong><br>
                <img id="ver_foto" src="{{ asset('images/mascotas/default.webp') }}" class="w-32 h-32 object-cover rounded border mt-2" alt="Foto mascota">
            </div>
        </div>

        <h3 class="mt-6 font-semibold">📋 Historial médico:</h3>
        <table class="w-full text-sm mt-2">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-2 py-1">Fecha</th>
                    <th class="px-2 py-1">Peso</th>
                    <th class="px-2 py-1">Descripción</th>
                    <th class="px-2 py-1 text-center">Ver</th>
                </tr>
            </thead>
            <tbody id="tablaHistorial" class="divide-y divide-gray-200">
                {{-- JS insertará aquí las filas --}}
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <button onclick="cerrarModal('modalVer')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cerrar</button>
        </div>
    </div>
</div>

{{-- 🔍 MODAL VER HISTORIAL INDIVIDUAL --}}
<div id="modalHistorial" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4">📄 Detalle del Historial</h2>
        <p><strong>Fecha:</strong> <span id="detalle_fecha"></span></p>
        <p><strong>Peso:</strong> <span id="detalle_peso"></span></p>
        <p><strong>Descripción:</strong></p>
        <p class="border p-2 rounded mt-1" id="detalle_descripcion"></p>

        <div class="mt-4 text-right">
            <button onclick="cerrarModal('modalHistorial')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cerrar</button>
        </div>
    </div>
</div>