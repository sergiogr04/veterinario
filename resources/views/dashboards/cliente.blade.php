@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">Panel del Cliente</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <p class="text-gray-700">Bienvenido, {{ Auth::user()->nombre }}. Este es tu panel como cliente.</p>
    </div>
</div>
@endsection
