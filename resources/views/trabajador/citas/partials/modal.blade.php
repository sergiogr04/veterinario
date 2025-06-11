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

{{-- Modal de reserva --}}
<div id="formularioCita" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded p-6 max-w-xl w-full">
        
        <h1 class="text-3xl font-bold text-blue-800 mb-6">✏️ Reservar Cita</h1>
        @php
            $citaPasada = isset($cita) && $cita->fecha && $cita->hora
                ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cita->fecha . ' ' . $cita->hora)->isPast()
                : false;
        @endphp

        <div id="erroresCrear" class="mb-4 hidden bg-red-100 border border-red-300 text-red-700 text-sm rounded p-3"></div>
        <form id="formCrearCita" method="POST">
            @csrf
            {{-- Fecha --}}
            <label class="block mb-2 text-sm font-medium">Fecha</label>
            @php
            $hoy = \Carbon\Carbon::now()->format('Y-m-d');
            @endphp

            <input type="date" name="fecha" value="{{ $hoy }}" class="w-full border px-3 py-2 rounded mb-4" onchange="cargarHorasDisponibles(this.value)" min="{{ $hoy }}" required>

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
            <textarea name="sintomas" rows="3" class="w-full border px-3 py-2 rounded mb-4" required></textarea>
            {{-- DNI --}}
            <label class="block mb-2 text-sm font-medium">DNI del cliente</label>
            <input type="text" name="dni" id="dni_cliente" class="w-full border px-3 py-2 rounded mb-4" placeholder="Introduce el DNI" oninput="buscarMascotasPorDni(this.value)">

            {{-- Mascota --}}
            <label class="block mb-2 text-sm font-medium">Mascota</label>
            <select name="id_mascota" id="select_mascotas" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">Selecciona una mascota</option>
            </select>


            <div class="flex justify-between gap-4">
                @if (!$citaPasada)
                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-blue-700 transition whitespace-nowrap">
                        💾 Guardar Cambios
                    </button>
                    <button type="button" onclick="cerrarModal('formularioCita')"
                        class="flex-1 bg-gray-300 text-gray-800 py-3 px-6 rounded-lg text-lg font-semibold hover:bg-gray-400 text-center transition whitespace-nowrap">
                        ❌ Cancelar
                    </button>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>