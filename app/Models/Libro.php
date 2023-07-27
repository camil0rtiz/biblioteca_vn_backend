<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Autore;
use App\Models\Ejemplare;
use App\Models\Reserva;
use App\Models\Archivo;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo_libro',
        'dewey_libro',
        'resena_libro',
        'categoria_libro',
        'anio_publi_libro',
        'estado_libro',
    ];

     //Relacion muchos a muchos con autores

    public function autores(){
        return $this->belongsToMany(Autore::class, 'autor_libro', 'id_libro','id_autor' ); 
    }

    //relacion uno a muchos con ejemplares

    public function ejemplares(){
        return $this->hasMany(Ejemplare::class,'id_libro');
    }

     //relacion uno a muchos con ejemplares

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }

    //relacion polimorfica con archivo

    public function archivo(){
        return $this->morphOne(Archivo::class, 'imageable');
    }

}
