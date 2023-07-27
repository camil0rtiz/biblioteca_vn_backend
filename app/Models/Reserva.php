<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Libro;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'id_libro',
        'fecha_reserva',
        'estado_reserva'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }

    //Relacion uno a muchos inversa con ejemplar

    public function libro(){
        return $this->belongsTo(Libro::class);
    }
}
