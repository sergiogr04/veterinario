{{-- ➕ MODAL CREAR TRABAJADOR --}}
<div id="modalCrear" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-xl w-full overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">➕ Crear Trabajador</h2>
        <form id="formCrearTrabajador">
            @csrf
            <div class="grid grid-cols-2 gap-4 text-sm">
                <input type="text" name="dni" placeholder="DNI" class="border p-2 rounded" required>
                <input type="text" name="nombre" placeholder="Nombre" class="border p-2 rounded" required>
                <input type="text" name="apellidos" placeholder="Apellidos" class="border p-2 rounded" required>
                <input type="text" name="telefono" placeholder="Teléfono" class="border p-2 rounded">
                <input type="email" name="email" placeholder="Email" class="border p-2 rounded" required>
                <input type="password" name="password" placeholder="Contraseña" class="border p-2 rounded" required>
                <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" class="border p-2 rounded" required>
            </div>

            <div class="mt-4 text-right space-x-2">
                <button type="button" onclick="cerrarModal('modalCrear')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Crear</button>
            </div>
        </form>
    </div>
</div>

{{-- 📝 MODAL EDITAR TRABAJADOR --}}
<div id="modalEditar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-xl w-full">
        <h2 class="text-xl font-semibold mb-4">✏️ Editar Trabajador</h2>
        <form id="formEditarTrabajador">
            @csrf
            <input type="hidden" id="editar_id" name="id">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <input type="text" id="editar_dni" name="dni" placeholder="DNI" class="border p-2 rounded" required>
                <input type="text" id="editar_nombre" name="nombre" placeholder="Nombre" class="border p-2 rounded" required>
                <input type="text" id="editar_apellidos" name="apellidos" placeholder="Apellidos" class="border p-2 rounded" required>
                <input type="text" id="editar_telefono" name="telefono" placeholder="Teléfono" class="border p-2 rounded">
                <input type="email" id="editar_email" name="email" placeholder="Email" class="border p-2 rounded" required>
                <input type="password" id="editar_password" name="password" placeholder="Nueva Contraseña (opcional)" class="border p-2 rounded">
            </div>

            <div class="mt-4 text-right space-x-2">
                <button type="button" onclick="cerrarModal('modalEditar')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- 👁 MODAL VER TRABAJADOR --}}
<div id="modalVer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full">
        <h2 class="text-xl font-semibold mb-4">👁 Detalles del Trabajador</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><strong>DNI:</strong> <span id="ver_dni"></span></p>
            <p><strong>Nombre:</strong> <span id="ver_nombre"></span></p>
            <p><strong>Apellidos:</strong> <span id="ver_apellidos"></span></p>
            <p><strong>Email:</strong> <span id="ver_email"></span></p>
            <p><strong>Teléfono:</strong> <span id="ver_telefono"></span></p>
            <p><strong>Dirección:</strong> <span id="ver_direccion"></span></p>
        </div>

        <div class="mt-6 text-right">
            <button onclick="cerrarModal('modalVer')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cerrar</button>
        </div>
    </div>
</div>
