{{-- 🔍 MODAL VER CLIENTE --}}
<div id="modalVer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto transition">
        <h2 class="text-2xl font-bold text-blue-800 mb-4 flex items-center gap-2">👁 Detalles del Cliente</h2>

        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
            <p><span class="font-semibold">DNI:</span> <span id="ver_dni"></span></p>
            <p><span class="font-semibold">Nombre:</span> <span id="ver_nombre"></span></p>
            <p><span class="font-semibold">Apellidos:</span> <span id="ver_apellidos"></span></p>
            <p><span class="font-semibold">Email:</span> <span id="ver_email"></span></p>
            <p><span class="font-semibold">Teléfono:</span> <span id="ver_telefono"></span></p>
            <p><span class="font-semibold">Dirección:</span> <span id="ver_direccion"></span></p>
        </div>

        <h3 class="mt-6 mb-2 text-lg font-semibold text-blue-700">🐾 Mascotas</h3>
        <table class="w-full text-sm border rounded shadow-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-3 py-2">Nombre</th>
                    <th class="px-3 py-2">Especie</th>
                    <th class="px-3 py-2">Raza</th>
                    <th class="px-3 py-2">Nacimiento</th>
                    <th class="px-3 py-2">Historial</th>
                </tr>
            </thead>
            <tbody id="tablaMascotas" class="divide-y divide-gray-200">
                {{-- JS insertará aquí las filas --}}
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <button onclick="cerrarModal('modalVer')" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow">Cerrar</button>
        </div>
    </div>
</div>

{{-- 📝 MODAL EDITAR CLIENTE --}}
<div id="modalEditar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-xl">
        <h2 class="text-2xl font-bold text-yellow-700 mb-4 flex items-center gap-2">✏️ Editar Cliente</h2>
        <form id="formEditar">
            <input type="hidden" name="id" id="editar_id">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <input type="text" name="dni" id="editar_dni" placeholder="DNI" class="input-field" required>
                <input type="text" name="nombre" id="editar_nombre" placeholder="Nombre" class="input-field" required>
                <input type="text" name="apellidos" id="editar_apellidos" placeholder="Apellidos" class="input-field" required>
                <input type="email" name="email" id="editar_email" placeholder="Email" class="input-field" required>
                <input type="text" name="telefono" id="editar_telefono" placeholder="Teléfono" class="input-field">
                <input type="text" name="direccion" id="editar_direccion" placeholder="Dirección (opcional)" class="input-field">
                <input type="password" name="password" id="editar_password" placeholder="Nueva contraseña (opcional)" class="input-field">
            </div>
            <div class="mt-6 text-right space-x-2">
                <button type="button" onclick="cerrarModal('modalEditar')" class="btn-gray">Cancelar</button>
                <button type="submit" class="btn-yellow">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- ➕ MODAL CREAR CLIENTE --}}
<div id="modalCrear" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-xl">
        <h2 class="text-2xl font-bold text-green-700 mb-4 flex items-center gap-2">➕ Crear Cliente</h2>
        <form id="formCrear">
            @csrf
            <div class="grid grid-cols-2 gap-4 text-sm">
                <input type="text" name="dni" placeholder="DNI" class="input-field" required>
                <input type="text" name="nombre" placeholder="Nombre" class="input-field" required>
                <input type="text" name="apellidos" placeholder="Apellidos" class="input-field" required>
                <input type="text" name="telefono" placeholder="Teléfono" class="input-field">
                <input type="email" name="email" placeholder="Email" class="input-field" required>
                <input type="password" name="password" placeholder="Contraseña" class="input-field" required>
                <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" class="input-field" required>
            </div>
            <div class="mt-6 text-right space-x-2">
                <button type="button" onclick="cerrarModal('modalCrear')" class="btn-gray">Cancelar</button>
                <button type="submit" class="btn-green">Crear</button>
            </div>
        </form>
    </div>
</div>

{{-- 📋 MODAL VER HISTORIAL --}}
<div id="modalHistorial" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow">
        <h2 id="historial_titulo" class="text-xl font-semibold text-blue-800 mb-4">📋 Historial Médico</h2>
        <table class="w-full text-sm border rounded shadow-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-3 py-2">Fecha</th>
                    <th class="px-3 py-2">Peso</th>
                    <th class="px-3 py-2">Descripción</th>
                    <th class="px-3 py-2 text-center">Acción</th>
                </tr>
            </thead>
            <tbody id="tablaHistorial" class="divide-y divide-gray-200"></tbody>
        </table>
        <div class="mt-4 text-right">
            <button onclick="cerrarModal('modalHistorial')" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded shadow">Cerrar</button>
        </div>
    </div>
</div>

{{-- 🔍 MODAL DETALLE HISTORIAL --}}
<div id="modalDetalleHistorial" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h2 class="text-lg font-semibold text-blue-800 mb-4">🔍 Detalle del Historial</h2>
        <p><strong>Fecha:</strong> <span id="detalle_fecha"></span></p>
        <p><strong>Peso:</strong> <span id="detalle_peso"></span></p>
        <p class="mb-4"><strong>Descripción:</strong> <span id="detalle_descripcion"></span></p>
        <div class="text-right">
            <button onclick="cerrarModal('modalDetalleHistorial')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cerrar</button>
        </div>
    </div>
</div>

