<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente\Mascota;

class HistorialController extends Controller
{
    public function mostrar($id)
    {
        $mascota = Mascota::with('historial')
            ->where('id_cliente', auth()->user()->id_usuario)
            ->findOrFail($id);

        return view('cliente.mascotas.historial', compact('mascota'));
    }
}
