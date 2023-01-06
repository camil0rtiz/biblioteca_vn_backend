<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Evento extends Model
{
    use HasFactory;

    //Relación uno a muchos inversa con usuario

    public function user(){
        $this->belongsTo(User::class);
    }

     //Relación uno a muchos inversa con categoria

    public function categoria(){
        $this->belongsTo(Categoria::class);
    }


}
