<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trabajador\Mascota;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';
    public $timestamps = false;

    protected $fillable = ['fecha', 'hora', 'tipo', 'sintomas', 'id_mascota', 'id_trabajador', 'id_cliente'];
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota');
    }
    
}
