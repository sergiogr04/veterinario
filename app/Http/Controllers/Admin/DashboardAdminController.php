<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin\Mascota;
use App\Models\Cita;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Contadores para el dashboard
        $clientes = User::where('rol', 'cliente')->count();
        $trabajadores = User::where('rol', 'trabajador')->count();
        $mascotas = Mascota::count();
        $citasPendientes = Cita::where('estado', 'pendiente')->count();

        // Enviar datos a la vista
        return view('dashboards.admin', compact('clientes', 'trabajadores', 'mascotas', 'citasPendientes'));
    }
}
