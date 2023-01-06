<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Membresia extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con usuario

    public function users(){
        return $this->belongsToMany(User::class); 
    }
}
