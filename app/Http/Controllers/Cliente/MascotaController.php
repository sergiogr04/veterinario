<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use App\Models\Mascota;

class MascotaController extends Controller
{
    public function index()
    {
        $mascotas = Auth::user()
            ->mascotas()
            ->with('ultimoHistorial')
            ->get();

        return view('cliente.mascotas', compact('mascotas'));
    }
}
