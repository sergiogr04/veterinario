<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';
    protected $primaryKey = 'id_mascota';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'id_cliente',
        'foto'
    ];

    // 🔗 Relación: cada mascota pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente', 'id_usuario');
    }

    // 🔗 Relación: una mascota tiene muchos historiales médicos
    public function historial()
{
    return $this->hasMany(Historial::class, 'id_mascota')->orderByDesc('fecha');
}
    
}
