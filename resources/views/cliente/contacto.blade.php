@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">📞 Contacto</h1>

    <div class="bg-white p-6 rounded-lg shadow space-y-4">
        <p class="text-gray-700">
            📍 Dirección:
            <a href="https://www.google.com/maps?q=Av.+de+Andalucía,+45,+Sevilla,+España" target="_blank" class="text-blue-600 hover:underline">
                Av. de Andalucía, 45, Sevilla, España
            </a>
        </p>

        <p class="text-gray-700">
            📞 Teléfono:
            <a href="tel:+34954123456" class="text-blue-600 hover:underline">
                +34 954 123 456
            </a>
        </p>

        <p class="text-gray-700">
            📧 Correo electrónico:
            <a href="mailto:soporteveterinariasanlorenzo@gmail.com" class="text-blue-600 hover:underline">
                soporteveterinariasanlorenzo@gmail.com
            </a>
        </p>
    </div>

    {{-- Opcional: formulario de contacto (solo visual, sin backend) --}}
    <div class="mt-10">
        <h2 class="text-2xl font-semibold text-blue-800 mb-4">¿Tienes alguna consulta?</h2>
        @if (session('mensaje'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('mensaje') }}
        </div>
        @endif

        <form action="{{ route('cliente.contacto.enviar') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="nombre" value="{{ old('nombre', Auth::user()->nombre) }}" placeholder="Tu nombre" class="w-full border border-gray-300 rounded px-4 py-2" required>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Tu correo" class="w-full border border-gray-300 rounded px-4 py-2" required>
            <textarea name="mensaje" placeholder="Escribe tu mensaje..." rows="4" class="w-full border border-gray-300 rounded px-4 py-2" required>{{ old('mensaje') }}</textarea>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Enviar
            </button>
        </form>

    </div>
</div>
@endsection