<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = ['descripcion', 'fecha', 'id_mascota', 'peso'];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota', 'id_mascota');
    }
}
