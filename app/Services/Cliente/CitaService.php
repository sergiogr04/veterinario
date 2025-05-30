<?php

namespace App\Services\Cliente;

use Carbon\Carbon;

class CitaService
{
    /**
     * Devuelve todos los slots disponibles para un día (formato H:i)
     */
    public static function getSlots($fecha)
    {
        $dia = Carbon::parse($fecha)->locale('es')->dayOfWeekIso; // 1 = lunes, 7 = domingo

        if ($dia === 7) {
            // Domingo: no se permiten reservas online
            return [];
        }

        $horas = [];

        if ($dia >= 1 && $dia <= 5) {
            // Lunes a viernes: 9:00 - 20:00
            $inicio = 9;
            $fin = 20;
        } else {
            // Sábados: 10:00 - 14:00
            $inicio = 10;
            $fin = 14;
        }

        for ($h = $inicio; $h < $fin; $h++) {
            $horas[] = sprintf('%02d:00', $h);
            $horas[] = sprintf('%02d:30', $h);
        }

        return $horas;
    }
}
