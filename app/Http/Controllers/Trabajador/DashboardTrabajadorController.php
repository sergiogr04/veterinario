<?php

namespace App\Http\Controllers\Trabajador;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Trabajador\Historial;
use Illuminate\Support\Carbon;

class DashboardTrabajadorController extends Controller
{
    public function index()
{
    $hoy = Carbon::today();

    $citasHoy = Cita::whereDate('fecha', $hoy)->where('estado',"pendiente")->count();
    $citasAtendidas = Historial::count();
    $mascotasHoy = Cita::whereDate('fecha', $hoy)->distinct('id_mascota')->count('id_mascota');
    $proximaCita = Cita::whereDate('fecha', $hoy)->orderBy('hora')->with('mascota.cliente')->where('estado',"pendiente")->first();
    $historialReciente = Historial::orderByDesc('fecha')->limit(3)->with('mascota')->get();
    $totalMascotas = \App\Models\Trabajador\Mascota::count();
    $citasSemana = Cita::whereBetween('fecha', [$hoy, $hoy->copy()->addDays(7)])->count();
    $mascotaTop = Historial::select('id_mascota')
    ->groupBy('id_mascota')
    ->orderByRaw('COUNT(*) DESC')
    ->with('mascota')
    ->first();
    $totalClientes = \App\Models\User::where('rol', 'cliente')->count();

    return view('dashboards.trabajador', compact(
        'citasHoy',
        'citasAtendidas',
        'mascotasHoy',
        'proximaCita',
        'historialReciente',
        'totalMascotas',
        'citasSemana',
        'mascotaTop',
        'totalClientes'
    ));
    
}
}
