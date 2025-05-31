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

    if ($dia === 7) return []; // Domingo

    $horas = [];

    if ($dia >= 1 && $dia <= 5) {
        $inicio = 9;
        $fin = 20;
    } else {
        $inicio = 10;
        $fin = 14;
    }

    $ahora = Carbon::now();
    $esHoy = Carbon::parse($fecha)->isSameDay($ahora);

    for ($h = $inicio; $h < $fin; $h++) {
        foreach (['00', '30'] as $min) {
            $slot = sprintf('%02d:%s', $h, $min);
            if ($esHoy && Carbon::createFromFormat('Y-m-d H:i', "$fecha $slot")->lt($ahora)) {
                continue; // Saltar horas pasadas
            }
            $horas[] = $slot;
        }
    }

    return $horas;
}

}
