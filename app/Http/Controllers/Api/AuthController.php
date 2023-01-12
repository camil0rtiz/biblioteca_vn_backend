<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{   
    public function registro(Request $request){

        $request->validate([
            'rut_usuario' => 'required|string|max:11',
            'nombre_usuario'=>'required|string|max:45',
            'apellido_pate_usuario'=>'required|string|max:45',
            'apellido_mate_usuario'=>'required|string|max:45',
            'email' => 'required|string|email|max:45',
            // 'password_usuario' => 'required|string|min:8|confirmed',
            'calle_usuario' => 'required',
            'fecha_naci_usuario' => 'required',

        ]);

        $user = User::create([
            'rut_usuario' =>   $request->rut_usuario, 
            'nombre_usuario'=>  $request->nombre_usuario, 
            'apellido_pate_usuario'=>  $request->apellido_pate_usuario, 
            'apellido_mate_usuario'=>  $request->apellido_mate_usuario, 
            'email' =>   $request->email, 
            'password' => Hash::make( $request->password),
            'numero_casa_usuario' =>  $request->numero_casa_usuario,
            'calle_usuario' =>  $request->calle_usuario,             
            'fecha_naci_usuario' =>  $request->fecha_naci_usuario, 
            'estado_usuario' => 'registrado',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user
        ]);

    }
    public function login(Request $request){

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
}
