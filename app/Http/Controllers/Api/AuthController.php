<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{   
    public function registrarUsuario(Request $request){

        $request->validate([
            'rut_usuario' => 'required|string|max:11',
            'nombre_usuario'=>'required|string|max:45',
            'apellido_pate_usuario'=>'required|string|max:45',
            'apellido_mate_usuario'=>'required|string|max:45',
            'email' => 'required|string|email|max:45',
            'password' => 'required|string|min:8|confirmed',
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
            'rut_usuario' => ['required'],
            'password' => ['required'],
        ]);

        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = User::where('rut_usuario', $request['rut_usuario'])->firstOrFail();
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        $user = User::select('users.nombre_usuario', 'users.apellido_pate_usuario', 'users.apellido_mate_usuario', 'roles.tipo_rol' )
            ->join('role_user', 'users.id', '=', 'role_user.id_usuario')
            ->join('roles', 'roles.id', '=', 'role_user.id_rol')    
            ->where('rut_usuario', $request['rut_usuario'])->get()->firstOrFail();

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'data' => $user
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete;
        return response()->json(['message' => 'Token eliminado correctamente'], 200);
    }

    public function obtenerUsuarios() {
        
        $users = User::all();

        return response()->json([
            'data' => $users
        ]);
    }

    public function actualizarUsuario(Request $request, User $user){

        $user->update($request->all());

        return response()->json([
            'data' => $user
        ]);

    }
}
