<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ResgisterController extends Controller
{
    public function store(Request $requets){
        $requets->validate([
            'rut_usuario' => 'required|string|max:11',
            'nombre_usuario'=>'required|string|max:45',
            'apellido_pate_usuario'=>'required|string|max:45',
            'apellido_mate_usuario'=>'required|string|max:45',
            'email_usuario' => 'required|string|email|max:45',
            'password_usuario' => 'required|string|min:8|confirmed',
            'calle_usuario' => 'required',
            'fecha_naci_usuario' => 'required',
            'estado_usuario' => 'required'
        ]);

        $user = User::create($requets->all());

        return response($user, 200);
    }
}
