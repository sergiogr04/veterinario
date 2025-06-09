@extends('layouts.landing')
@section('content')
@vite('resources/css/landing.css')

<link rel="stylesheet" href="{{ asset('css/landing.css') }}">

{{-- HERO --}}
<section id="hero" class="min-h-screen bg-gradient-to-r from-blue-100 to-white flex items-center justify-center text-center px-4">
    <div class="max-w-3xl">
        <h1 class="text-5xl md:text-6xl font-extrabold text-blue-900 mb-6 animate-fade">Clínica Veterinaria San Lorenzo</h1>
        <p class="text-lg md:text-xl text-gray-700 mb-8 animate-slide">
            Cuidamos de tus mascotas como si fueran parte de nuestra familia. Atención 100% personalizada, cercana y profesional.
        </p>
        @auth
        @php
        $user = auth()->user();
        $dashboard = match($user->rol) {
        'admin' => route('dashboard_admin'),
        'trabajador' => route('dashboard_trabajador'),
        default => route('dashboard_cliente'),
        };
        @endphp
        <a href="{{ $dashboard }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 animate-fade-delay">
            ¡Pide ya tu cita!
        </a>
        @else
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 animate-fade-delay">
            ¡Pide ya tu cita!
        </a>
        @endauth

    </div>
</section>

{{-- PRESENTACIÓN DEL VETERINARIO --}}
<section id="presentacion" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6 md:flex md:items-center md:gap-12">
        <div class="md:w-1/2 animate-fade">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Conócenos</h2>
            <p class="text-gray-700 mb-4">
                Somos un equipo de profesionales liderado por el Dr. Alejandro Ruiz, veterinario con más de 12 años de experiencia en medicina animal. Nuestro objetivo es ofrecer un trato humano tanto a los animales como a sus familias.
            </p>
            <p class="text-gray-700">
                El Dr. Ruiz se graduó en la Universidad de Córdoba, especializándose en cirugía veterinaria y medicina preventiva. Ha trabajado en clínicas de toda España y colabora con asociaciones de rescate animal. Además, es amante de los gatos, ciclista y defensor de la adopción responsable.
            </p>
        </div>
        <div class="md:w-1/2 mt-10 md:mt-0 animate-slide">
            <img src="{{ asset('images/veterinario.webp') }}" alt="Veterinario principal" class="rounded-xl shadow-lg w-full max-w-md mx-auto">
        </div>
    </div>
</section>

{{-- SERVICIOS DESTACADOS --}}
<section id="servicios" class="py-20 bg-white text-center">
    <h2 class="text-3xl font-bold text-blue-900 mb-12 animate-fade">Nuestros Servicios</h2>
    <div class="grid gap-8 px-6 md:grid-cols-2 lg:grid-cols-4 max-w-6xl mx-auto">
        @foreach ([
        ['icon' => 'consulta.webp', 'title' => 'Consulta General', 'desc' => 'Revisiones completas y diagnósticos precisos.'],
        ['icon' => 'vacuna.webp', 'title' => 'Vacunación', 'desc' => 'Planes personalizados para cada mascota.'],
        ['icon' => 'cirugia.webp', 'title' => 'Cirugías', 'desc' => 'Tecnología de última generación.'],
        ['icon' => 'urgencias.webp', 'title' => 'Urgencias 24h', 'desc' => 'Atención rápida y eficaz.'],
        ] as $servicio)
        <div class="bg-blue-50 p-6 rounded-lg shadow-md transform hover:-translate-y-1 transition duration-300 animate-slide">
            <img src="{{ asset('images/' . $servicio['icon']) }}" alt="{{ $servicio['title'] }}" class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 mx-auto mb-4">
            <h3 class="text-xl font-semibold text-blue-800">{{ $servicio['title'] }}</h3>
            <p class="text-gray-700">{{ $servicio['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- TESTIMONIOS --}}
<section id="testimonios" class="py-20 bg-gray-100 text-center">
    <h2 class="text-3xl font-bold text-blue-900 mb-12 animate-fade">Lo que dicen nuestros clientes</h2>
    <div class="max-w-4xl mx-auto grid gap-6 px-6 md:grid-cols-3">
        @foreach ([
        '"Un trato espectacular. Mi gato odia a todo el mundo, pero aquí se siente en casa."',
        '"Gracias por salvar a mi perrita. Eternamente agradecida con el equipo."',
        '"Siempre puntuales, atentos y con explicaciones claras. Muy recomendados."'
        ] as $testimonio)
        <blockquote class="bg-white p-6 rounded-xl border-l-4 border-blue-600 text-gray-700 italic animate-slide">{{ $testimonio }}</blockquote>
        @endforeach
    </div>
</section>

{{-- CTA FINAL --}}
<section id="cta" class="py-16 bg-blue-800 text-white text-center">
    <div class="max-w-2xl mx-auto px-6 animate-fade-delay">
        <h2 class="text-3xl font-bold mb-4">¿Listo para cuidar de tu mascota con los mejores?</h2>
        <p class="mb-6">No esperes más. Te mereces tranquilidad. Tu mascota también.</p>
        @auth
        @php
        $user = auth()->user();
        $dashboard = match($user->rol) {
        'admin' => route('dashboard_admin'),
        'trabajador' => route('dashboard_trabajador'),
        default => route('dashboard_cliente'),
        };
        @endphp
        <a href="{{ $dashboard }}" class="bg-white text-blue-800 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition">
            Reserva tu cita ahora
        </a>
        @else
        <a href="{{ route('login') }}" class="bg-white text-blue-800 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition">
            Reserva tu cita ahora
        </a>
        @endauth
        
    </div>
</section>
@endsection