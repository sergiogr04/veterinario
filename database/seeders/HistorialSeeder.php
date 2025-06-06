<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistorialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('historial')->insert([
            [
                'descripcion' => 'Revisión general. Todo correcto.',
                'fecha' => '2024-06-01',
                'peso' => '5',
                'id_mascota' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Control de peso. Ligero sobrepeso detectado.',
                'fecha' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'peso' => '30',
                'id_mascota' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
