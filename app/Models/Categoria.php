<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;

class Categoria extends Model
{
    use HasFactory;

    //relacion uno a muchos con eventos

    public function eventos(){
        return $this->hasMany(Evento::class);
    }

}
