<div id="modalAtender" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded p-6 max-w-xl w-full">
        <h2 class="text-xl font-semibold mb-4">🩺 Atender Cita</h2>
        <div class="mb-4">
            <p><strong>Mascota:</strong> <span id="atender_mascota"></span></p>
            <p><strong>Dueño:</strong> <span id="atender_dueno"></span></p>
            <p><strong>Hora:</strong> <span id="atender_hora"></span></p>
            <p><strong>Tipo:</strong> <span id="atender_tipo"></span></p>
            <p><strong>Síntomas:</strong> <span id="atender_sintomas"></span></p>
        </div>
        <form id="formAtender">
            @csrf
            <input type="hidden" id="atender_id" name="id">
            <textarea name="descripcion" class="border w-full p-2 rounded mb-2" placeholder="Descripción..." required></textarea>
            <input type="number" step="0.1" name="peso" placeholder="Peso (kg)" class="border p-2 rounded w-full mb-4" required>
            <div class="text-right">
                <button type="button" onclick="cerrarModal('modalAtender')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>
{{-- 👁 MODAL VER CITA --}}
<div id="modalVer" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded p-6 max-w-xl w-full">
        <h2 class="text-xl font-semibold mb-4">👁 Detalles de la Cita</h2>
        <p><strong>Mascota:</strong> <span id="ver_mascota"></span></p>
        <p><strong>Dueño:</strong> <span id="ver_dueno"></span></p>
        <p><strong>Hora:</strong> <span id="ver_hora"></span></p>
        <p><strong>Tipo:</strong> <span id="ver_tipo"></span></p>
        <p><strong>Síntomas:</strong> <span id="ver_sintomas"></span></p>
        <p><strong>Historial:</strong></p>
        <ul id="ver_historial" class="list-disc list-inside text-sm text-gray-700 mt-1">
            {{-- Se rellena desde JS --}}
        </ul>
        <div class="text-right mt-4">
            <button onclick="cerrarModal('modalVer')" class="bg-gray-500 text-white px-4 py-2 rounded">Cerrar</button>
        </div>
    </div>
</div>
