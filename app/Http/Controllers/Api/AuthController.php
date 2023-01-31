<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\agregarUsuarioRequest;

class AuthController extends Controller
{   
    public function agregarUsuario(agregarUsuarioRequest $request){

        try {
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
    
            return response()->json([
                'data' => $user
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);
        }

    }

    public function listarUsuarios() {
        
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

    public function login(Request $request){

        try {
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
                ->leftJoin('role_user', 'users.id', '=', 'role_user.id_usuario')
                ->leftJoin('roles', 'roles.id', '=', 'role_user.id_rol')    
                ->where('rut_usuario', $request['rut_usuario'])->get()->firstOrFail();
    
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'data' => $user
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);
        }
    }
        
    public function logout(Request $request){
        
        $request->user()->currentAccessToken()->delete;
        return response()->json(['message' => 'Token eliminado correctamente'], 200);

    }
}
