<?php

namespace App\Http\Controllers\Trabajador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trabajador\Mascota;
use Illuminate\Support\Str;

class MascotaController extends Controller
{
    // Mostrar listado de mascotas
    public function index()
    {
        $mascotas = Mascota::with('cliente')->get(); // Todas las mascotas
        return view('trabajador.mascotas.index', compact('mascotas'));
    }


    // Mostrar detalles de una mascota y su historial
    public function show($id)
    {
        $mascota = Mascota::with(['cliente', 'historial'])->findOrFail($id);

        // Obtener el último peso registrado si existe
        $ultimoHistorialConPeso = $mascota->historial->whereNotNull('peso')->sortByDesc('fecha')->first();
        $mascota->peso = $ultimoHistorialConPeso->peso ?? null;

        return response()->json($mascota);
    }

    // Crear una nueva mascota
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'id_cliente' => 'required|exists:usuarios,id_usuario',
            'foto' => 'nullable|image|max:2048'
        ]);
    
        if ($request->hasFile('foto')) {
            $nombreArchivo = Str::uuid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images/mascotas'), $nombreArchivo);
            $validated['foto'] = $nombreArchivo;
        }
    
        $mascota = Mascota::create($validated);
    
        return response()->json(['success' => true, 'mascota' => $mascota]);
    }
    

    // Actualizar datos de una mascota
    public function update(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);
    
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'foto' => 'nullable|image|max:2048'
        ]);
    
        if ($request->hasFile('foto')) {
            $nombreArchivo = Str::uuid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images/mascotas'), $nombreArchivo);
            $validated['foto'] = $nombreArchivo;
        }
    
        $mascota->update($validated);
    
        return response()->json(['success' => true]);
    }
    

    // Eliminar una mascota
    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();

        return response()->json(['success' => true]);
    }

    // Ver historial concreto
    public function verHistorial($id)
    {
        $historial = Historial::findOrFail($id);
        return response()->json($historial);
    }
}
