<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Cliente\Mascota;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardClienteController extends Controller
{

public function index()
{
    $clienteId = auth()->id();

    $ultimasCitas = Cita::where('id_cliente', $clienteId)
        ->with('mascota')
        ->orderByDesc('fecha')
        ->orderByDesc('hora')
        ->take(5)
        ->get();

    $totalMascotas = Mascota::where('id_cliente', $clienteId)->count();

    $citasFuturas = Cita::where('id_cliente', $clienteId)
        ->whereRaw("CONCAT(fecha, ' ', hora) > ?", [now()])
        ->count();

    $tiposCitas = Cita::where('id_cliente', $clienteId)
        ->select('tipo', DB::raw('count(*) as total'))
        ->groupBy('tipo')
        ->pluck('total', 'tipo');
    
    $citas = Cita::where('estado', 'pendiente')->get();    
    foreach ($citas as $cita) {
        $fechaHora = Carbon::createFromFormat('Y-m-d H:i:s', $cita->fecha . ' ' . $cita->hora);
        
        if ($fechaHora->addHours(3)->isPast()) {
            $cita->estado = 'no_asistio';
            $cita->save();
        }
    }
    return view('dashboards.cliente', compact('ultimasCitas', 'totalMascotas', 'citasFuturas', 'tiposCitas'));
}

}
