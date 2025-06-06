<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MascotasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mascotas')->insert([{'id_mascota': '1', 'nombre': 'Loby', 'especie': 'Perro', 'raza': 'Labrador', 'sexo': '2018-05-20', 'fecha_nacimiento': '1', 'peso': '4e4d491e-e005-4c04-9fe8-c9fc3b61fd38.webp'}, {'id_mascota': '2', 'nombre': 'Meso', 'especie': 'Gato', 'raza': 'Polaco', 'sexo': '2018-09-10', 'fecha_nacimiento': '1', 'peso': 'misu.jpg'}, {'id_mascota': '3', 'nombre': 'Bunny', 'especie': 'Conejo', 'raza': 'Cabeza de León', 'sexo': '2021-02-20', 'fecha_nacimiento': '4', 'peso': 'bunny.jpg'}]);
    }
}
