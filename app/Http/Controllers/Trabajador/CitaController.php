<?php

namespace App\Http\Controllers\Trabajador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Trabajador\Historial;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now()->toDateString();
        $horaActual = Carbon::now()->format('H:i:s');

        $citasHoy = Cita::with(['mascota.cliente'])
            ->where('fecha', $hoy)
            ->where('hora', '>=', $horaActual)
            ->orderBy('hora')
            ->get();

        $citasFuturas = Cita::with(['mascota.cliente'])
            ->where('fecha', '>', $hoy)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

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

    // Elimina la cita
    $cita->delete();

    return response()->json(['success' => true]);
}


    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json(['success' => true]);
    }
    
}
