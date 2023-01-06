<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro;
use App\Models\Editoriale;
use App\Models\Prestamo;

class Ejemplare extends Model
{
    use HasFactory;

    //Relación uno a muchos inversa con libro

    public function libro(){
        $this->belongsTo(Libro::class);
    }

    //Relación uno a muchos inversa con editorial

    public function editorial(){
        $this->belongsTo(Editoriale::class);
    }

    //Relacion uno a muchos 

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }
}
