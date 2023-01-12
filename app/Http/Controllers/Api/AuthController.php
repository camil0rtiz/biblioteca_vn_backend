<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{   
    public function registro(Request $requets){

        $requets->validate([
            'rut_usuario' => 'required|string|max:11',
            'nombre_usuario'=>'required|string|max:45',
            'apellido_pate_usuario'=>'required|string|max:45',
            'apellido_mate_usuario'=>'required|string|max:45',
            'email_usuario' => 'required|string|email|max:45',
            // 'password_usuario' => 'required|string|min:8|confirmed',
            'calle_usuario' => 'required',
            'fecha_naci_usuario' => 'required',

        ]);

        $user = new User();
        $user->rut_usuario = $requets->rut_usuario; 
        $user->nombre_usuario = $requets->nombre_usuario; 
        $user->apellido_pate_usuario = $requets->apellido_pate_usuario; 
        $user->apellido_mate_usuario = $requets->apellido_mate_usuario; 
        $user->email_usuario = $requets->email_usuario; 
        $user->password_usuario = bcrypt( $requets->password_usuario);
        $user->numero_casa_usuario = $requets->numero_casa_usuario;
        $user->calle_usuario = $requets->calle_usuario; 
        $user->fecha_naci_usuario = $requets->fecha_naci_usuario; 
        $user->estado_usuario = 'registrado';

        $user->save();
        // $user = User::create($request->all());
        // $token = $user->createToken('auth_token')->plainTextToken;

        // return $user;

        return response()->json([
            // 'access_token' => $token,
            // 'token_type' => 'Bearer',
            'data' => $user
        ]);
    }

}
