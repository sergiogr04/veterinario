<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Rutas principales del sistema (por defecto es dashboard).
     */
    public const HOME = '/dashboard';

    /**
     * Registra las rutas de la aplicación.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Redirección personalizada según el rol del usuario.
     */
    public static function redirectByRole($user)
    {
        return match ($user->rol) {
            'cliente' => '/dashboard_cliente',
            'trabajador' => '/dashboard_trabajador',
            'admin' => '/dashboard_admin',
            default => '/login',
        };
    }
}
