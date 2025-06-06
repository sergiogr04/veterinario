<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MascotasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mascotas')->insert([
            [
                'id_mascota' => 1,
                'nombre' => 'Loby',
                'especie' => 'Perro',
                'raza' => 'Labrador',
                'fecha_nacimiento' => '2018-05-20',
                'id_cliente' => 1,
                'foto' => '4e4d491e-e005-4c04-9fe8-c9fc3b61fd38.webp'
            ],
            [
                'id_mascota' => 2,
                'nombre' => 'Meso',
                'especie' => 'Gato',
                'raza' => 'Polaco',
                'fecha_nacimiento' => '2018-09-10',
                'id_cliente' => 1,
                'foto' => 'misu.jpg'
            ],
            [
                'id_mascota' => 3,
                'nombre' => 'Bunny',
                'especie' => 'Conejo',
                'raza' => 'Cabeza de León',
                'fecha_nacimiento' => '2021-02-20',
                'id_cliente' => 4,
                'foto' => 'bunny.jpg'
            ],
        ]);
    }
}
