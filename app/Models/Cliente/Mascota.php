<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente\Historial;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $primaryKey = 'id_mascota';
    public $timestamps = false;

    protected $fillable = ['nombre', 'especie', 'raza', 'fecha_nacimiento', 'id_cliente', 'foto'];

    public function historial()
    {
        return $this->hasMany(Historial::class, 'id_mascota', 'id_mascota')->orderByDesc('fecha');
    }    

    public function ultimoHistorial()
    {
        return $this->hasOne(Historial::class, 'id_mascota', 'id_mascota')->latestOfMany('fecha');
    }

/*     public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente', 'id_usuario');
    } */
}
