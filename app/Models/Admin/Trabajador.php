<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'dni', 'nombre', 'apellidos', 'telefono',
        'direccion', 'email', 'password', 'rol'
    ];
}
