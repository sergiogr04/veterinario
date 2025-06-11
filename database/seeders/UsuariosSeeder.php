<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'dni' => '12345678A',
                'nombre' => 'laura',
                'apellidos' => 'Gómez Pérez',
                'direccion' => 'Calle Falsa 123',
                'telefono' => '600123456',
                'email' => 'laura@gmail.com',
                'password' => '$2y$12$WLGeoRUg525yXO80fDjkN.hIo9lvcnJuujDr2OZ7bhOMvHEWJTeY.',
                'rol' => 'cliente',
            ],
            [
                'dni' => '99999999Z',
                'nombre' => 'Admin',
                'apellidos' => 'Principal',
                'direccion' => null,
                'telefono' => null,
                'email' => 'admin@vet.com',
                'password' => '$2y$12$WLGeoRUg525yXO80fDjkN.hIo9lvcnJuujDr2OZ7bhOMvHEWJTeY.',
                'rol' => 'admin',
            ],
            [
                'dni' => '20094973J',
                'nombre' => 'manuel',
                'apellidos' => 'garcia',
                'direccion' => null,
                'telefono' => '+34 911 592 005',
                'email' => 'manugarcia@gmail.com',
                'password' => '$2y$12$rdkBqbHgd/N5oKeOeg4HqO9nSUgZw8FXGV5kwiPOVyBhSJjSXCD3e',
                'rol' => 'trabajador',
            ],
        ]);
    }
}
