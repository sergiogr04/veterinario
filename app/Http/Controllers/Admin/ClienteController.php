<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ClienteController extends Controller
{
    // Mostrar tabla de clientes
    public function index()
    {
        $clientes = User::where('rol', 'cliente')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    // Mostrar datos individuales del cliente (para modal)
    public function show($id)
    {
        $cliente = User::with('mascotas')->where('rol', 'cliente')->findOrFail($id);
        return response()->json($cliente);
    }

    // Actualizar datos del cliente
    public function update(Request $request, $id)
    {
        $cliente = User::where('rol', 'cliente')->findOrFail($id);
    
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
            'direccion' => [
                'nullable',
                'string',
                'max:255'
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
    
        $cliente->update($validated);
    
        return response()->json(['success' => true]);
    }
    

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = User::where('rol', 'cliente')->findOrFail($id);
        $cliente->delete();

        return response()->json(['success' => true]);
    }

    // Crear cliente nuevo
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
        $validated['rol'] = 'cliente';

        $cliente = User::create($validated);

        return response()->json(['success' => true, 'cliente' => $cliente]);
    }
}
