<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// CLIENTE
Route::middleware(['auth', 'isCliente'])->group(function () {
    Route::get('/dashboard_cliente', function () {
        return view('dashboards.cliente');
    })->name('dashboard_cliente');
});

// ADMIN
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard_admin', function () {
        return view('dashboards.admin');
    })->name('dashboard_admin');
});

// TRABAJADOR
Route::middleware(['auth', 'isTrabajador'])->group(function () {
    Route::get('/dashboard_trabajador', function () {
        return view('dashboards.trabajador');
    })->name('dashboard_trabajador');
});

// PERFIL (disponible para todos los autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', [LandingController::class, 'index'])->name('landing');

require __DIR__.'/auth.php';
