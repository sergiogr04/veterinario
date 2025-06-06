<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email',
            'mensaje' => 'required|string',
        ]);

        // Enviar correo al cliente
        Mail::raw("Gracias por ponerte en contacto con Clínica San Lorenzo. Hemos recibido tu mensaje y te responderemos lo antes posible.", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Gracias por tu mensaje');
        });

        // Enviar correo a la clínica con los datos
        Mail::raw("Nuevo mensaje de contacto:\n\nNombre: {$request->nombre}\nCorreo: {$request->email}\n\nMensaje:\n{$request->mensaje}", function ($message) {
            $message->to('sgr.s3209@gmail.com')
                ->subject('Nuevo mensaje desde el formulario de contacto');
        });

        return back()->with('mensaje', 'Gracias por tu mensaje. Te hemos enviado un correo de confirmación.');
    }
}
