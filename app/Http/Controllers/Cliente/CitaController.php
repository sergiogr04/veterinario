<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\Cliente\CitaService;

class CitaController extends Controller
{
    public function index()
    {
        $mes = request('mes') ? Carbon::parse(request('mes')) : Carbon::now();
        $dias = [];

        $inicioMes = $mes->copy()->startOfMonth();
        $finMes = $mes->copy()->endOfMonth();

        for ($dia = $inicioMes; $dia->lte($finMes); $dia->addDay()) {
            $slots = CitaService::getSlots($dia->format('Y-m-d'));
            $ocupadas = Cita::whereDate('fecha', $dia->format('Y-m-d'))->count();

            $porcentaje = count($slots) ? ($ocupadas / count($slots)) * 100 : 100;

            if ($porcentaje === 100 || $dia->isSunday()) {
                $color = 'rojo';
            } elseif ($porcentaje >= 50) {
                $color = 'naranja';
            } else {
                $color = 'verde';
            }

            $dias[] = [
                'fecha' => $dia->format('Y-m-d'),
                'color' => $color,
                'ocupadas' => $ocupadas,
                'total' => count($slots),
            ];
        }
        $citasUsuario = Cita::where('id_cliente', auth()->id())
        ->with('mascota')
        ->get()
        ->map(function ($cita) {
            return [
                'id_cita' => $cita->id_cita,
                'fecha' => $cita->fecha,
                'hora' => $cita->hora,
                'tipo' => $cita->tipo,
                'sintomas' => $cita->sintomas,
                'mascota_nombre' => $cita->mascota->nombre ?? 'Mascota',
            ];
        })
        ->groupBy(function ($cita) {
            return \Carbon\Carbon::parse($cita['fecha'])->format('Y-m-d');
        });
    

    
        $siguienteMes = $mes->copy()->addMonth()->format('Y-m');
        $mesAnterior = $mes->copy()->subMonth()->format('Y-m');
        
        return view('cliente.citas.index', compact('dias', 'mes', 'mesAnterior', 'siguienteMes', 'citasUsuario'));
            
        return view('cliente.citas.index', [
            'mes' => $mes,
            'dias' => $dias,
            'siguienteMes' => $mes->copy()->addMonth()->format('Y-m'),
            'mesAnterior' => $mes->copy()->subMonth()->format('Y-m'),
        ]);
    }

    public function horasDisponibles($fecha)
    {
        $slots = CitaService::getSlots($fecha);
    
        // Trae solo las horas ocupadas por otras citas ese día
        $ocupadas = Cita::whereDate('fecha', $fecha)
            ->pluck('hora')
            ->map(function ($hora) {
                return \Carbon\Carbon::parse($hora)->format('H:i');
            })
            ->toArray();

    
        // Filtra los horarios libres
        $disponibles = array_filter($slots, function ($hora) use ($ocupadas) {
            return !in_array($hora, $ocupadas);
        });
    
        return response()->json(array_values($disponibles));
    }
    
    public function reservar(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo' => 'required',
            'sintomas' => 'required|string',
            'id_mascota' => 'required|exists:mascotas,id_mascota',
        ]);

        Cita::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'tipo' => $request->tipo,
            'sintomas' => $request->sintomas,
            'id_mascota' => $request->id_mascota,
            'id_trabajador' => null, 
            'id_cliente' => auth()->id(), 
        ]);
        

        return redirect()->route('cliente.citas')->with('ok', 'Cita reservada correctamente');
    }
    public function editar($id)
{
    $cita = Cita::findOrFail($id);

    // Solo puede editar su propia cita
    if ($cita->id_cliente !== auth()->id()) {
        abort(403, 'No autorizado');
    }

    return view('cliente.citas.editar', compact('cita'));
}

public function actualizar(Request $request, $id)
{
    $cita = Cita::findOrFail($id);

    if ($cita->id_cliente !== auth()->id()) {
        abort(403, 'No autorizado');
    }

    $request->validate([
        'fecha' => 'required|date',
        'hora' => 'required',
        'tipo' => 'required|string',
        'sintomas' => 'required|string',
        'id_mascota' => 'required|exists:mascotas,id_mascota',
    ]);

    $cita->update([
        'fecha' => $request->fecha,
        'hora' => $request->hora,
        'tipo' => $request->tipo,
        'sintomas' => $request->sintomas,
        'id_mascota' => $request->id_mascota,
    ]);

    return redirect()->route('cliente.citas', ['misCitas' => 1])
        ->with('ok', 'Cita actualizada correctamente.');
}
public function eliminar($id)
{
    $cita = Cita::findOrFail($id);

    if ($cita->id_cliente !== auth()->id()) {
        abort(403, 'No autorizado');
    }

    $cita->delete();

    return response()->json(['ok' => true]);
}
public function redirigirEditar(Request $request)
{
    $cita = Cita::findOrFail($request->id_cita);

    if ($cita->id_cliente !== auth()->id()) {
        abort(403);
    }

    return redirect()->route('cliente.citas.editar.formulario', ['token' => encrypt($cita->id_cita)]);
}

}

