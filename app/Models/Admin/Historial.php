<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table = 'historial';
    protected $primaryKey = 'id_historia';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'fecha',
        'peso',
        'id_mascota'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'id_mascota');
    }
}
