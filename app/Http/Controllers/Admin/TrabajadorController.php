<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TrabajadorController extends Controller
{
    public function index()
    {
        $trabajadores = User::where('rol', 'trabajador')->get();
        return view('admin.trabajadores.index', compact('trabajadores'));
    }

    public function show($id)
    {
        $trabajador = User::where('rol', 'trabajador')->findOrFail($id);
        return response()->json($trabajador);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|unique:usuarios,dni',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['rol'] = 'trabajador';

        User::create($validated);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $trabajador = User::where('rol', 'trabajador')->findOrFail($id);

        $validated = $request->validate([
            'dni' => 'required|string|unique:usuarios,dni,' . $id . ',id_usuario',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:usuarios,email,' . $id . ',id_usuario',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $trabajador->update($validated);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $trabajador = User::where('rol', 'trabajador')->findOrFail($id);
        $trabajador->delete();
        return response()->json(['success' => true]);
    }
}
