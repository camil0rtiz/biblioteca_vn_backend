<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_rol'];

    //Relacion muchos a muchos con usuario

    public function users(){
        return $this->belongsToMany(User::class, 'role_user', 'id_rol', 'id_usuario');
    }

}
