<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Cliente\Mascota;
use Illuminate\Support\Facades\DB;

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

    return view('dashboards.cliente', compact('ultimasCitas', 'totalMascotas', 'citasFuturas', 'tiposCitas'));
}

}
