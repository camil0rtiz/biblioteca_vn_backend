<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\agregarUsuarioRequest;
use App\Http\Requests\actualizarUsuarioRequest;

class AuthController extends Controller
{   
    public function agregarUsuario(agregarUsuarioRequest $request){

        try {
            $user = User::create([
                'rut_usuario' =>   $request->rut_usuario, 
                'nombre_usuario'=>  $request->nombre_usuario, 
                'apellido_pate_usuario'=>  $request->apellido_pate_usuario, 
                'apellido_mate_usuario'=>  $request->apellido_mate_usuario,
                'numero_tele_usuario' => $request->numero_tele_usuario,
                'email' =>   $request->email, 
                'password' => Hash::make($request->password),
                'numero_casa_usuario' =>  $request->numero_casa_usuario,
                'calle_usuario' =>  $request->calle_usuario,             
                'fecha_naci_usuario' =>  $request->fecha_naci_usuario,
                'estado_usuario' => $request->estado_usuario 
            ]);

            if($request->id_membresia){
                $user->membresias()->attach($request->id_membresia, [
                    'fecha_pago_paga' => today(),
                    'fecha_venci_paga' => today(),
                    'fecha_acti_paga' => today(),
                ]);
            }

            if($request->id_rol){
                $user->roles()->attach($request->id_rol);
            }
    
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
        
        $users = User::select('users.id','users.nombre_usuario', 'users.rut_usuario' ,'users.apellido_pate_usuario', 'users.numero_tele_usuario' ,'users.apellido_mate_usuario', 'users.email', 'users.calle_usuario', 'users.numero_casa_usuario', 'users.fecha_naci_usuario','roles.id as id_rol', 'roles.tipo_rol')
                                ->leftJoin('role_user', 'users.id', '=', 'role_user.id_usuario')
                                ->leftJoin('roles', 'roles.id', '=', 'role_user.id_rol')->orderBy('id', 'asc')->get() ; 

        return response()->json([
            'data' => $users
        ]);

    }
    
    public function actualizarUsuario(actualizarUsuarioRequest $request, User $user){

        try {

            $user->update($request->all());

            if($request->id_rol){
                $user->roles()->sync($request->id_rol);
            }

            return response()->json([
                'data' => $user
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }

    }

    public function eliminarUsuario(User $user){
        
        try {
            $ifexist = User::where('id', $user->id)->first();
            if ($ifexist != null){
                $usuarios = User::find($user->id)->delete();
                return response()->json(["data" => $usuarios], 200);
            }
            return response()->json(["msg" => "El id del usuario que intenta eliminar no existe"], 401);
        }
        catch (\Exception $e)
        {
            return response()->json(["error" => $e]);
        }

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
