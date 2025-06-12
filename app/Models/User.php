<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use App\Models\Cliente\Mascota;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'dni',
        'nombre',
        'apellidos',
        'telefono',
        'email',
        'password',
        'rol',
    ];    
    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'id_cliente', 'id_usuario');
    }
    public function getNombreAttribute($value)
    {
        return ucfirst($value); 
    }
    public function getApellidosAttribute($value)
    {
        return ucwords($value); 
    }
    
    
}
