<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ejemplare;

class Prestamo extends Model
{
    use HasFactory;

     //Relación uno a muchos inversa con usuario

    // public function user(){
    //     $this->belongsTo(User::class);
    // }

    public function vecino(){
        return $this->belongsTo(User::class, 'id_vecino');
    }

    public function bibliotecario(){
        return $this->belongsTo(User::class, 'id_bibliotecario');
    }

    //Relacion uno a muchos inversa con ejemplar

    public function ejemplar(){
        return $this->belongsTo(Ejemplare::class);
    }
}
