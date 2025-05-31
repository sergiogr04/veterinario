@extends('layouts.app')
@vite('resources/css/citas.css')
@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">
        {{ request('misCitas') ? '📋 Tus Citas Programadas' : '📅 Pedir Cita' }}
    </h1>
    <div class="mb-6 text-right">
        <form method="POST" action="{{ route('cliente.citas') }}" class="inline">
            @csrf
            @if(request('misCitas'))
            {{-- Volver a pedir cita --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                📅 Volver a Pedir Cita
            </button>
            @else
            {{-- Ver mis citas --}}
            <input type="hidden" name="misCitas" value="1">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                📋 Ver mis citas
            </button>
            @endif
        </form>

    </div>
    <div>
        @php
        use Carbon\Carbon;

        $primerDiaMes = Carbon::parse($dias[0]['fecha']);
        $ultimoDiaMes = Carbon::parse(end($dias)['fecha']);

        $inicioCalendario = $primerDiaMes->copy()->startOfWeek(Carbon::MONDAY);
        $finCalendario = $ultimoDiaMes->copy()->endOfWeek(Carbon::SUNDAY);
        $periodo = \Carbon\CarbonPeriod::create($inicioCalendario, $finCalendario);

        $diasPorFecha = collect($dias)->keyBy('fecha');
        @endphp
        <div class="flex justify-between items-center mb-4">
            @if ($mes->format('Y-m') > now()->format('Y-m'))
            <form method="POST" action="{{ route('cliente.citas') }}" class="inline">
                @csrf
                <input type="hidden" name="mes" value="{{ $mesAnterior }}">
                @if(request('misCitas'))
                <input type="hidden" name="misCitas" value="1">
                @endif
                <button type="submit" class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">← Mes anterior</button>
            </form>
            @else
            <span class="text-gray-400">← Mes anterior</span>
            @endif

            <h2 class="text-xl font-semibold text-gray-700">{{ $mes->translatedFormat('F Y') }}</h2>

            @if ($mes->format('Y-m') < now()->addMonth()->format('Y-m'))
                <form method="POST" action="{{ route('cliente.citas') }}" class="inline">
                    @csrf
                    <input type="hidden" name="mes" value="{{ $siguienteMes }}">
                    @if(request('misCitas'))
                    <input type="hidden" name="misCitas" value="1">
                    @endif
                    <button type="submit" class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Mes siguiente →</button>
                </form>
                @else
                <span class="text-gray-400">Mes siguiente →</span>
                @endif
        </div>

        <div class="text-center grid grid-cols-7 text-sm text-gray-500 mb-2 font-semibold">
            <div>Lun</div>
            <div>Mar</div>
            <div>Mié</div>
            <div>Jue</div>
            <div>Vie</div>
            <div>Sáb</div>
            <div>Dom</div>
        </div>

        <div class="grid grid-cols-7 gap-2 border border-gray-300 rounded overflow-hidden text-center text-sm auto-rows-fr min-h-[100px]">
            @foreach ($periodo as $fecha)
            @php
            $esPasado = $fecha->lt(\Carbon\Carbon::today());
            $fechaStr = $fecha->format('Y-m-d');
            $esDelMes = $fecha->month === $mes->month;
            $citasDelDia = request('misCitas') ? ($citasUsuario->get($fechaStr) ?? null) : null;
            $diaData = $diasPorFecha->get($fechaStr);
            $color = $diaData['color'] ?? 'gris';
            @endphp

            @if (!$esDelMes)
            <div class="bg-gray-100 text-gray-300 celda-calendario">{{ $fecha->day }}</div>
            @elseif (request('misCitas'))
            <div class="{{ $citasDelDia 
        ? 'celda-calendario bg-blue-200 hover:bg-blue-300 font-semibold rounded transition cursor-pointer' 
        : 'celda-calendario bg-white border border-gray-300 text-gray-700 rounded' }}"
                @if($citasDelDia)
                onclick='verCitasDelDia(@json($citasDelDia))'
                @endif>
                {{ $fecha->day }}
            </div>


            @else
            @if (!$diaData)
            <div class="bg-gray-100 celda-calendario"></div>
            @else
            @if ($esPasado)
            <button
                title="No disponible"
                class="celda-calendario bg-gray-100 text-gray-400 cursor-not-allowed">
                {{ $fecha->day }}
            </button>
            @else
            <button onclick="abrirFormulario('{{ $fechaStr }}')"
                class="celda-calendario
                {{ $color === 'verde' ? 'bg-verde' : '' }}
                {{ $color === 'naranja' ? 'bg-naranja' : '' }}
                {{ $color === 'rojo' ? 'bg-rojo' : '' }}">
                {{ $fecha->day }}
            </button>
            @endif
            @endif
            @endif
            @endforeach
        </div>


    </div>



</div>

{{-- Modal de reserva --}}
<div id="formularioCita" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative mx-4">

        <button onclick="cerrarFormulario()" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-lg">✖</button>

        <h2 class="text-xl font-bold mb-4 text-blue-800">📋 Solicitar cita para <span id="fechaSeleccionada" class="font-mono"></span></h2>

        <form action="{{ route('cliente.citas.reservar') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha" id="fechaInput">

            {{-- Mascotas --}}
            <label class="block mb-2 text-sm font-medium">Mascota</label>
            <select name="id_mascota" class="w-full border px-3 py-2 rounded mb-4" required>
                @foreach (Auth::user()->mascotas as $m)
                <option value="{{ $m->id_mascota }}">{{ $m->nombre }}</option>
                @endforeach
            </select>

            {{-- Tipo --}}
            <label class="block mb-2 text-sm font-medium">Tipo de cita</label>
            <select name="tipo" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="urgencia">Urgencia</option>
                <option value="consulta">Consulta</option>
                <option value="revision">Revisión</option>
                <option value="vacuna">Vacuna</option>
            </select>

            {{-- Síntomas --}}
            <label class="block mb-2 text-sm font-medium">Síntomas</label>
            <textarea name="sintomas" class="w-full border px-3 py-2 rounded mb-4" rows="3" required></textarea>

            {{-- Hora --}}
            <label class="block mb-2 text-sm font-medium">Hora</label>
            <select name="hora" id="horasDisponibles" class="w-full border px-3 py-2 rounded mb-4" required>
                <option value="">Cargando...</option>
            </select>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Reservar cita</button>
        </form>
    </div>
</div>

{{-- Script para formulario --}}
<script>
    function abrirFormulario(fecha) {

        document.getElementById('fechaSeleccionada').innerText = fecha;
        document.getElementById('fechaInput').value = fecha;
        document.getElementById('formularioCita').classList.remove('hidden');
        // Cargar horas disponibles
        fetch(`/cliente/citas/disponibles/${fecha}`)
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('horasDisponibles');
                select.innerHTML = '';

                if (data.length === 0) {
                    select.innerHTML = '<option value="">No hay horas disponibles</option>';
                    return;
                }

                data.forEach(hora => {
                    const opt = document.createElement('option');
                    opt.value = hora;
                    opt.textContent = hora;
                    select.appendChild(opt);
                });
            });
    }

    function cerrarFormulario() {
        document.getElementById('formularioCita').classList.add('hidden');
    }
</script>
<script>
    function mostrarCalendarioCitas() {
        const calendarioCitas = document.getElementById('calendarioCitas');
        const calendarioReserva = document.querySelector('.grid-cols-7.border-gray-300');

        calendarioCitas.classList.toggle('hidden');

        // Oculta el calendario de reserva cuando se muestran las citas
        if (!calendarioCitas.classList.contains('hidden')) {
            calendarioReserva.classList.add('hidden');
        } else {
            calendarioReserva.classList.remove('hidden');
        }
    }


    function verCitasDelDia(citas) {
        const modal = document.createElement('div');
        modal.className = "fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50";

        const ahora = new Date();

        const contenido = citas.map(cita => {
            const citaDateTime = new Date(`${cita.fecha}T${cita.hora}`);

            const botones = citaDateTime > ahora ? `
        <form action="{{ route('cliente.citas.editar') }}" method="POST" class="inline-block">
            @csrf
            <input type="hidden" name="id_cita" value="${cita.id_cita}">
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">✏️ Editar</button>
        </form>
        <button onclick="eliminarCita(${cita.id_cita})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">🗑️ Eliminar</button>
    ` : `<span class="text-gray-400 italic">No editable</span>`;

            return `
        <div class="mb-4 border-b pb-2">
            <p><strong>Hora:</strong> ${cita.hora}</p>
            <p><strong>Tipo:</strong> ${cita.tipo}</p>
            <p><strong>Mascota:</strong> ${cita.mascota_nombre}</p>
            <p><strong>Síntomas:</strong> ${cita.sintomas}</p>
            <div class="mt-2 text-right space-x-2">
                ${botones}
            </div>
        </div>
    `;
        }).join('');



        modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg max-h-[90vh] p-6 relative overflow-y-auto">
            <button onclick="this.parentElement.parentElement.remove()" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-lg">✖</button>
            <h2 class="text-xl font-bold mb-4 text-blue-800">📅 Citas del día</h2>
            ${contenido}
        </div>
    `;

        document.body.appendChild(modal);
    }

    function eliminarCita(id) {
        if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
            fetch(`/cliente/citas/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(res => {
                    if (res.ok) {
                        location.reload();
                    } else {
                        alert('Ocurrió un error al eliminar la cita');
                    }
                });
        }
    }
</script>

@endsection