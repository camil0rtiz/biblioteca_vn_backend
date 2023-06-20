<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ejemplare;

class Editoriale extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_editorial',
        'estado_editorial',
    ];

    //Relacion uno a muchos 

    public function ejemplares(){
        return $this->hasMany(Ejemplare::class, 'id_articulo');
    }
}
