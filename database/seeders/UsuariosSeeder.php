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
                'remember_token' => null,
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
                'remember_token' => null,
            ],
            [
                'dni' => '12345678R',
                'nombre' => 'Rocio',
                'apellidos' => 'Cardoso Huerta',
                'direccion' => null,
                'telefono' => '+34 911 592 123',
                'email' => 'roco@gmail.com',
                'password' => '$2y$12$PGyZRPeWmsXfNrzC6IYkaOoj2Rp1qEeGLETJ4TuOMNENtmNvULr/a',
                'rol' => 'cliente',
                'remember_token' => null,
            ],
            [
                'dni' => '20094973B',
                'nombre' => 'Sergio',
                'apellidos' => 'Gómez Rosa',
                'direccion' => null,
                'telefono' => '622 71 44 57',
                'email' => 'sgr.s3209@gmail.com',
                'password' => '$2y$12$odzUtcNkC/RPl/TKihpZUu.CpUIHBofv/OAThrS2B9pM8uNsyRIom',
                'rol' => 'trabajador',
                'remember_token' => null,
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
                'remember_token' => null,
            ],
            [
                'dni' => '20094973H',
                'nombre' => 'manu',
                'apellidos' => 'garcia',
                'direccion' => null,
                'telefono' => '644898776',
                'email' => 'garcia@gmail.com',
                'password' => '$2y$12$SAMdhdyd9AOUnyYrO34bUu7RuDasNoaxxuo7omyC9aMLCWIxHlAuG',
                'rol' => 'cliente',
                'remember_token' => null,
            ],
        ]);
    }
}
