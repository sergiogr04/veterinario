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
        'dni' => [
            'required',
            'regex:/^[0-9]{8}[A-Za-z]$/',
            'unique:usuarios,dni'
        ],
        'nombre' => [
            'required',
            'regex:/^[\pL\s\-]+$/u',
            'max:255'
        ],
        'apellidos' => [
            'required',
            'regex:/^[\pL\s\-]+$/u',
            'max:255'
        ],
        'telefono' => [
            'nullable',
            'regex:/^[0-9]{9}$/'
        ],
        'email' => [
            'required',
            'email',
            'unique:usuarios,email'
        ],
        'password' => [
            'required',
            'string',
            'min:6',
            'confirmed'
        ],
    ], [
        'dni.regex' => 'El DNI debe tener 8 dígitos seguidos de una letra.',
        'nombre.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
        'apellidos.regex' => 'Los apellidos solo pueden contener letras, espacios y guiones.',
        'telefono.regex' => 'El teléfono debe contener exactamente 9 dígitos.',
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
        'dni' => [
            'required',
            'regex:/^[0-9]{8}[A-Za-z]$/',
            'unique:usuarios,dni,' . $id . ',id_usuario'
        ],
        'nombre' => [
            'required',
            'regex:/^[\pL\s\-]+$/u',
            'max:255'
        ],
        'apellidos' => [
            'required',
            'regex:/^[\pL\s\-]+$/u',
            'max:255'
        ],
        'telefono' => [
            'nullable',
            'regex:/^[0-9]{9}$/'
        ],
        'email' => [
            'required',
            'email',
            'unique:usuarios,email,' . $id . ',id_usuario'
        ],
        'password' => [
            'nullable',
            'string',
            'min:6'
        ],
    ], [
        'dni.regex' => 'El DNI debe tener 8 dígitos seguidos de una letra.',
        'nombre.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
        'apellidos.regex' => 'Los apellidos solo pueden contener letras, espacios y guiones.',
        'telefono.regex' => 'El teléfono debe contener exactamente 9 dígitos.',
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
