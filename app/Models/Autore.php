<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro;

class Autore extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con libros

    public function libros(){
        return $this->belongsToMany(Libro::class, 'autor_libro', 'id_libro', 'id_autor' ); 
    }

}
