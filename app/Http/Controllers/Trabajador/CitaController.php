<?php

namespace App\Http\Controllers\Trabajador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Trabajador\Historial;
use Carbon\Carbon;
use App\Models\Trabajador\Mascota;
use App\Models\User;
use App\Services\Cliente\CitaService; 
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now()->toDateString();

        $citasHoy = Cita::with(['mascota.cliente'])
            ->where('fecha', $hoy)
            ->where('estado',"pendiente")
            ->orderBy('hora')
            ->get();

        $citasFuturas = Cita::with(['mascota.cliente'])
            ->where('fecha', '>', $hoy)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        $citas = Cita::where('estado', 'pendiente')->get();
        foreach ($citas as $cita) {
            $fechaHora = Carbon::createFromFormat('Y-m-d H:i:s', $cita->fecha . ' ' . $cita->hora);
            
            if ($fechaHora->addHours(3)->isPast()) {
                $cita->estado = 'no_asistio';
                $cita->save();
            }
        }
        return view('trabajador.citas.index', compact('citasHoy', 'citasFuturas'));
    }

    public function ver($id)
    {
        $cita = Cita::with(['mascota.cliente', 'mascota.historial'])->findOrFail($id);
        return response()->json($cita);
    }

    public function atender(Request $request, $id)
{
    $cita = Cita::findOrFail($id);

    $validated = $request->validate([
        'peso' => 'required|numeric|min:0',
        'descripcion' => 'required|string|max:1000',
    ]);

    // Verifica que tenga una mascota asociada
    if (!$cita->id_mascota) {
        return response()->json(['success' => false, 'message' => 'Cita sin mascota.'], 400);
    }

    // Crea entrada en el historial
    Historial::create([
        'id_mascota' => $cita->id_mascota,
        'fecha' => $cita->fecha,
        'peso' => $validated['peso'],
        'descripcion' => $validated['descripcion'],
    ]);

    $cita->estado = 'atendida';
    $cita->save();

   

    return response()->json(['success' => true]);
}


    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json(['success' => true]);
    }

public function buscarMascotasPorDni(Request $request)
{
    $dni = $request->dni;
    $cliente = User::where('dni', $dni)->first();

    if (!$cliente) {
        return response()->json([]);
    }

    $mascotas = Mascota::where('id_cliente', $cliente->id_usuario)
        ->select('id_mascota', 'nombre')
        ->get();

    return response()->json($mascotas);
}

public function horasDisponibles(Request $request)
{
    $fecha = $request->query('fecha'); // también puedes usar $request->input('fecha')
    
    if (!$fecha) {
        return response()->json(['error' => 'Fecha requerida'], 400);
    }

    $slots = CitaService::getSlots($fecha);

    $ocupadas = Cita::whereDate('fecha', $fecha)
        ->pluck('hora')
        ->map(function ($hora) {
            return \Carbon\Carbon::parse($hora)->format('H:i');
        })
        ->toArray();

    $disponibles = array_filter($slots, function ($hora) use ($ocupadas) {
        return !in_array($hora, $ocupadas);
    });

    if (Carbon::parse($fecha)->isToday()) {
        $ahora = Carbon::now();
        $disponibles = array_filter($disponibles, function ($hora) use ($fecha, $ahora) {
            $slotDateTime = Carbon::createFromFormat('Y-m-d H:i', "$fecha $hora");
            return $slotDateTime->greaterThan($ahora);
        });
    }

    return response()->json(array_values($disponibles));
}


public function crear(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fecha' => 'required|date',
        'hora' => 'required',
        'tipo' => 'required|string',
        'sintomas' => 'required|string',
        'dni' => 'required|string|size:9',
        'id_mascota' => 'required|exists:mascotas,id_mascota',
    ], [
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha debe ser válida.',
        'hora.required' => 'Selecciona una hora disponible.',
        'tipo.required' => 'El tipo de cita es obligatorio.',
        'tipo.string' => 'Tipo de cita inválido.',
        'sintomas.required' => 'Por favor, describe los síntomas.',
        'dni.required' => 'El DNI es obligatorio.',
        'dni.string' => 'El DNI debe ser un texto.',
        'dni.size' => 'El DNI debe tener 9 caracteres.',
        'id_mascota.required' => 'Selecciona una mascota.',
        'id_mascota.exists' => 'La mascota seleccionada no existe.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()->all()
        ], 422);
    }

    $validated = $validator->validated();

    $cliente = User::where('dni', $validated['dni'])->first();
    if (!$cliente) {
        return response()->json([
            'success' => false,
            'errors' => ['No se encontró un cliente con ese DNI.']
        ], 422);
    }

    Cita::create([
        'fecha' => $validated['fecha'],
        'hora' => $validated['hora'],
        'tipo' => $validated['tipo'],
        'sintomas' => $validated['sintomas'],
        'id_mascota' => $validated['id_mascota'],
        'id_cliente' => $cliente->id_usuario,
        'estado' => 'pendiente',
    ]);

    return response()->json(['success' => true]);
}




}
