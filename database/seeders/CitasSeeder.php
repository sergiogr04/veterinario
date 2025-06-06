<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('citas')->insert([
            ['id_cita' => 30, 'fecha' => '2025-06-05', 'hora' => '11:00:00', 'tipo' => 'urgencia', 'sintomas' => 'asdasd', 'estado' => 'no_asistio', 'id_mascota' => 1, 'id_cliente' => 1],
            ['id_cita' => 31, 'fecha' => '2025-06-05', 'hora' => '10:00:00', 'tipo' => 'urgencia', 'sintomas' => 'prueba', 'estado' => 'no_asistio', 'id_mascota' => 1, 'id_cliente' => 1],
            ['id_cita' => 32, 'fecha' => '2025-06-04', 'hora' => '09:00:00', 'tipo' => 'consulta', 'sintomas' => 'l', 'estado' => 'no_asistio', 'id_mascota' => 2, 'id_cliente' => 1],
            ['id_cita' => 33, 'fecha' => '2025-06-02', 'hora' => '09:00:00', 'tipo' => 'consulta', 'sintomas' => 'asdasd', 'estado' => 'no_asistio', 'id_mascota' => 1, 'id_cliente' => 1],
            ['id_cita' => 34, 'fecha' => '2025-06-06', 'hora' => '09:00:00', 'tipo' => 'urgencia', 'sintomas' => 'kjh', 'estado' => 'atendida', 'id_mascota' => 1, 'id_cliente' => 1],
            ['id_cita' => 35, 'fecha' => '2025-06-05', 'hora' => '17:00:00', 'tipo' => 'urgencia', 'sintomas' => 'asdksad', 'estado' => 'atendida', 'id_mascota' => 1, 'id_cliente' => 1],
            ['id_cita' => 38, 'fecha' => '2025-06-05', 'hora' => '18:30:00', 'tipo' => 'urgencia', 'sintomas' => 'knn', 'estado' => 'atendida', 'id_mascota' => 1, 'id_cliente' => 1],
            ['id_cita' => 39, 'fecha' => '2025-06-06', 'hora' => '09:30:00', 'tipo' => 'urgencia', 'sintomas' => 'lkl', 'estado' => 'pendiente', 'id_mascota' => 1, 'id_cliente' => 1],
        ]);
            }
}
