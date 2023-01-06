<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Autore;
use App\Models\Ejemplare;

class Libro extends Model
{
    use HasFactory;

     //Relacion muchos a muchos con autores

    public function autores(){
        return $this->belongsToMany(Autore::class); 
    }

    //relacion uno a muchos con ejemplares

    public function ejemplares(){
        return $this->hasMany(Ejemplare::class);
    }

}
