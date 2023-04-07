<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Membresia;
use App\Models\Evento;
use App\Models\Prestamo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'rut_usuario',
        'nombre_usuario',
        'apellido_pate_usuario',
        'apellido_mate_usuario',
        'numero_tele_usuario',
        'email',
        'password',
        'numero_casa_usuario',
        'calle_usuario',
        'fecha_naci_usuario',
        'estado_usuario',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Relacion muchos a muchos con roles
    
    public function roles(){
        return $this->belongsToMany(Role::class, 'role_user', 'id_usuario', 'id_rol');
    }
    
    //Relacion muchos a muchos con membresia
    
    public function membresias(){
        return $this->belongsToMany(Membresia::class, 'membresia_user', 'id_usuario', 'id_membresia');
    }

    //relacion uno a muchos con eventos

    public function eventos(){
        return $this->hasMany(Evento::class);
    }

    //Relacion uno a muchos 

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }
}
