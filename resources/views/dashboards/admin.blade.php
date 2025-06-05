@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-4xl font-extrabold text-blue-800 mb-10 animate__animated animate__fadeInDown">📊 Panel de Admin</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Clientes</h2>
            <p class="text-4xl text-blue-700 font-bold">{{ $clientes }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Trabajadores</h2>
            <p class="text-4xl text-blue-700 font-bold">{{ $trabajadores }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Mascotas</h2>
            <p class="text-4xl text-blue-700 font-bold">{{ $mascotas }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Citas pendientes</h2>
            <p class="text-4xl text-blue-700 font-bold">{{ $citasPendientes }}</p>
        </div>
    </div>
</div>
@endsection
