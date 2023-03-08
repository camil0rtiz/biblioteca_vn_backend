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

    protected $fillable = [
        'id_libro',
        'id_editorial'
    ];

    //Relación uno a muchos inversa con libro

    public function libro(){
        return $this->belongsTo(Libro::class);
    }

    //Relación uno a muchos inversa con editorial

    public function editorial(){
        return $this->belongsTo(Editoriale::class, 'id_editorial');
    }

    //Relacion uno a muchos 

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }
}
