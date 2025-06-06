<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Cliente\ContactoController;
use App\Http\Controllers\Cliente\HistorialController;
use App\Http\Controllers\Cliente\DashboardClienteController;
use App\Http\Controllers\Trabajador\DashboardTrabajadorController;
use App\Http\Controllers\Trabajador\ClienteController as ClienteTrabajadorController;;
use App\Http\Controllers\Admin\ClienteController as ClienteAdminController;;
use App\Http\Controllers\Cliente\MascotaController as MascotaClienteController;
use App\Http\Controllers\Trabajador\MascotaController as MascotaTrabajadorController;
use App\Http\Controllers\Admin\MascotaController as MascotaAdminController;
use App\Http\Controllers\Cliente\CitaController as CitaClienteController;
use App\Http\Controllers\Trabajador\CitaController as CitaTrabajadorController;
use App\Http\Controllers\Admin\TrabajadorController;
use App\Http\Controllers\Admin\DashboardAdminController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rutas de Perfil (Usuarios autenticados)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboards por Rol
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isCliente'])->get('/dashboard_cliente', [DashboardClienteController::class, 'index'])->name('dashboard_cliente');
Route::middleware(['auth', 'isAdmin'])->get('/dashboard_admin', [DashboardAdminController::class, 'index'])->name('dashboard_admin');
Route::middleware(['auth', 'isTrabajador'])->get('/dashboard_trabajador', [DashboardTrabajadorController::class, 'index'])->name('dashboard_trabajador');

/*
|--------------------------------------------------------------------------
| Rutas Cliente
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isCliente'])->prefix('cliente')->group(function () {
    // Mascotas
    Route::get('/mascotas', [MascotaClienteController::class, 'index'])->name('cliente.mascotas');
    Route::get('/mascotas/{id}/historial', [HistorialController::class, 'mostrar'])->name('cliente.mascota.historial');

    // Contacto
    Route::get('/contacto', fn () => view('cliente.contacto'))->name('cliente.contacto');
    Route::post('/contacto', [ContactoController::class, 'enviar'])->name('cliente.contacto.enviar');

    // Citas
    Route::get('/citas', [CitaClienteController::class, 'index'])->name('cliente.citas');
    Route::post('/citas', [CitaClienteController::class, 'index']); // navegación sin mostrar en URL
    Route::post('/citas/reservar', [CitaClienteController::class, 'reservar'])->name('cliente.citas.reservar');
    Route::get('/citas/disponibles/{fecha}', [CitaClienteController::class, 'horasDisponibles'])->name('cliente.citas.horas');

    // Editar cita con token
    Route::post('/citas/editar', [CitaClienteController::class, 'redirigirEditar'])->name('cliente.citas.editar');
    Route::get('/citas/editar/{token}', function ($token) {
        $id = decrypt($token);
        $cita = \App\Models\Cita::findOrFail($id);

        if ($cita->id_cliente !== auth()->id()) {
            abort(403);
        }

        return view('cliente.citas.editar', compact('cita'));
    })->name('cliente.citas.editar.formulario');

    Route::put('/citas/{cita}', [CitaClienteController::class, 'actualizar'])->name('cliente.citas.actualizar');
    Route::delete('/citas/{id}', [CitaClienteController::class, 'eliminar'])->name('cliente.citas.eliminar');
});

/*
|--------------------------------------------------------------------------
| Rutas Trabajador - Clientes
|--------------------------------------------------------------------------
*/

// CRUD Clientes
Route::prefix('trabajador/clientes')->name('trabajador.clientes.')->group(function () {
    Route::get('/', [ClienteTrabajadorController::class, 'index'])->name('index');
    Route::get('/{id}', [ClienteTrabajadorController::class, 'show'])->name('show');
    Route::post('/', [ClienteTrabajadorController::class, 'store'])->name('store');
    Route::put('/{id}', [ClienteTrabajadorController::class, 'update'])->name('update');
    Route::delete('/{id}', [ClienteTrabajadorController::class, 'destroy'])->name('destroy');

    // Buscar por DNI
    Route::get('/dni/{dni}', function ($dni) {
        $cliente = \App\Models\User::where('dni', $dni)->where('rol', 'cliente')->first();

        if (!$cliente) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'id' => $cliente->id_usuario,
            'nombre' => $cliente->nombre,
            'apellidos' => $cliente->apellidos
        ]);
    });
});

// Ruta directa para el menú
Route::middleware(['auth', 'isTrabajador'])->prefix('trabajador')->group(function () {
    Route::get('/clientes', [ClienteTrabajadorController::class, 'index'])->name('trabajador.clientes');
});

/*
|--------------------------------------------------------------------------
| Rutas Trabajador - Mascotas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isTrabajador'])->prefix('trabajador/mascotas')->name('trabajador.mascotas.')->group(function () {
    Route::get('/', [MascotaTrabajadorController::class, 'index'])->name('index');
    Route::get('/{id}', [MascotaTrabajadorController::class, 'show'])->name('show');
    Route::post('/', [MascotaTrabajadorController::class, 'store'])->name('store');
    Route::put('/{id}', [MascotaTrabajadorController::class, 'update'])->name('update');
    Route::delete('/{id}', [MascotaTrabajadorController::class, 'destroy'])->name('destroy');
    Route::get('/historial/{id}', [MascotaTrabajadorController::class, 'verHistorial'])->name('historial');
});

/*
|--------------------------------------------------------------------------
| Rutas Trabajador - Citas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isTrabajador'])->prefix('trabajador/citas')->name('trabajador.citas.')->group(function () {
    Route::get('/', [CitaTrabajadorController::class, 'index'])->name('index');
    Route::get('/{id}', [CitaTrabajadorController::class, 'ver'])->name('ver');
    Route::post('/{id}/atender', [CitaTrabajadorController::class, 'atender'])->name('atender');
    Route::delete('/{id}', [CitaTrabajadorController::class, 'destroy'])->name('eliminar');
});



/*
|--------------------------------------------------------------------------
| Rutas ADMIN - Clientes
|--------------------------------------------------------------------------
*/

// CRUD Clientes
Route::prefix('admin/clientes')->name('admin.clientes.')->group(function () {
    Route::get('/', [ClienteAdminController::class, 'index'])->name('index');
    Route::get('/{id}', [ClienteAdminController::class, 'show'])->name('show');
    Route::post('/', [ClienteAdminController::class, 'store'])->name('store');
    Route::put('/{id}', [ClienteAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [ClienteAdminController::class, 'destroy'])->name('destroy');

    // Buscar por DNI
    Route::get('/dni/{dni}', function ($dni) {
        $cliente = \App\Models\User::where('dni', $dni)->where('rol', 'cliente')->first();

        if (!$cliente) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'id' => $cliente->id_usuario,
            'nombre' => $cliente->nombre,
            'apellidos' => $cliente->apellidos
        ]);
    });
});

// Ruta directa para el menú
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/clientes', [ClienteAdminController::class, 'index'])->name('admin.clientes');
});

/*
|--------------------------------------------------------------------------
| Rutas ADMIN - Mascotas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isAdmin'])->prefix('admin/mascotas')->name('admin.mascotas.')->group(function () {
    Route::get('/', [MascotaAdminController::class, 'index'])->name('index');
    Route::get('/{id}', [MascotaAdminController::class, 'show'])->name('show');
    Route::post('/', [MascotaAdminController::class, 'store'])->name('store');
    Route::put('/{id}', [MascotaAdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [MascotaAdminController::class, 'destroy'])->name('destroy');
    Route::get('/historial/{id}', [MascotaAdminController::class, 'verHistorial'])->name('historial');
});


Route::middleware(['auth', 'isAdmin'])->prefix('admin/trabajadores')->name('admin.trabajadores.')->group(function () {
    Route::get('/', [TrabajadorController::class, 'index'])->name('index');
    Route::get('/{id}', [TrabajadorController::class, 'show'])->name('show');
    Route::post('/', [TrabajadorController::class, 'store'])->name('store');
    Route::put('/{id}', [TrabajadorController::class, 'update'])->name('update');
    Route::delete('/{id}', [TrabajadorController::class, 'destroy'])->name('destroy');
});
