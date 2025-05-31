<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Cliente\MascotaController;
use App\Http\Controllers\Cliente\ContactoController;
use App\Http\Controllers\Cliente\CitaController;
use App\Http\Controllers\Cliente\HistorialController;
use App\Http\Controllers\Cliente\DashboardClienteController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Laravel Breeze o Fortify)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rutas de Perfil (usuarios autenticados)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboards según el rol
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isCliente'])->get('/dashboard_cliente', [DashboardClienteController::class, 'index'])->name('dashboard_cliente');
Route::middleware(['auth', 'isAdmin'])->get('/dashboard_admin', fn () => view('dashboards.admin'))->name('dashboard_admin');
Route::middleware(['auth', 'isTrabajador'])->get('/dashboard_trabajador', fn () => view('dashboards.trabajador'))->name('dashboard_trabajador');

/*
|--------------------------------------------------------------------------
| Rutas Cliente - Mascotas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isCliente'])->group(function () {
    Route::get('/cliente/mascotas', [MascotaController::class, 'index'])->name('cliente.mascotas');
    Route::get('/cliente/mascotas/{id}/historial', [HistorialController::class, 'mostrar'])->name('cliente.mascota.historial');
});

/*
|--------------------------------------------------------------------------
| Rutas Cliente - Contacto
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isCliente'])->group(function () {
    Route::get('/cliente/contacto', fn () => view('cliente.contacto'))->name('cliente.contacto');
    Route::post('/cliente/contacto', [ContactoController::class, 'enviar'])->name('cliente.contacto.enviar');
});

/*
|--------------------------------------------------------------------------
| Rutas Cliente - Citas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isCliente'])->prefix('cliente')->group(function () {
    Route::get('/citas', [CitaController::class, 'index'])->name('cliente.citas');
    Route::post('/citas', [CitaController::class, 'index'])->name('cliente.citas'); // Para navegación sin mostrar en la URL

    Route::post('/citas/reservar', [CitaController::class, 'reservar'])->name('cliente.citas.reservar');
    Route::get('/citas/disponibles/{fecha}', [CitaController::class, 'horasDisponibles'])->name('cliente.citas.horas');

    // Editar con token cifrado
    Route::post('/citas/editar', [CitaController::class, 'redirigirEditar'])->name('cliente.citas.editar');
    Route::get('/citas/editar/{token}', function ($token) {
        $id = decrypt($token);
        $cita = \App\Models\Cita::findOrFail($id);

        if ($cita->id_cliente !== auth()->id()) {
            abort(403);
        }

        return view('cliente.citas.editar', compact('cita'));
    })->name('cliente.citas.editar.formulario')->middleware(['auth', 'isCliente']);

    Route::put('/citas/{cita}', [CitaController::class, 'actualizar'])->name('cliente.citas.actualizar');
    Route::delete('/citas/{id}', [CitaController::class, 'eliminar'])->name('cliente.citas.eliminar');
});
