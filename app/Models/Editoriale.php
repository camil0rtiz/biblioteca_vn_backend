<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ejemplare;

class Editoriale extends Model
{
    use HasFactory;

    //Relacion uno a muchos 

    public function ejemplares(){
        return $this->hasMany(Ejemplare::class);
    }
}
