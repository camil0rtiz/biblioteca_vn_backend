<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Archivo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\agregarUsuarioRequest;
use App\Http\Requests\actualizarUsuarioRequest;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{   

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
            
            $user = User::select('users.id','users.nombre_usuario', 'users.apellido_pate_usuario', 'users.apellido_mate_usuario', 'roles.tipo_rol' )
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

    public function agregarUsuario(Request $request){

        try {
    
            $data = $request->all();
            
            $usuarioExistente = User::where('rut_usuario', $data['rut_usuario'])->first();

            if ($usuarioExistente) {

                return response()->json([
                    "message" => 'El rut usuario ya se encuentra registrado',
                ], 400); // Respuesta de error con código 400 (Bad Request)
                
            }

            $user = User::create([
                'rut_usuario' => $data['rut_usuario'],
                'nombre_usuario' => $data['nombre_usuario'],
                'apellido_pate_usuario' => $data['apellido_pate_usuario'],
                'apellido_mate_usuario' => $data['apellido_mate_usuario'],
                'numero_tele_usuario' => $data['numero_tele_usuario'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'calle_usuario' => $data['calle_usuario'],
                'numero_casa_usuario' =>$data['numero_casa_usuario'],
                'fecha_naci_usuario' => $data['fecha_naci_usuario'],
                'estado_usuario' => $data['estado_usuario'],
            ]);

            $fecha_pago = date('Y-m-d');

            if($data['estado_usuario'] == 1){

                if($data['id_membresia'] == 1){

                    $fecha_vencimiento = strtotime('+12 months', strtotime($fecha_pago));
                    $fecha_vencimiento = date('Y-m-d' , $fecha_vencimiento);

                }elseif($data['id_membresia'] == 2){
    
                    $fecha_vencimiento = strtotime('+6 months', strtotime($fecha_pago));
                    $fecha_vencimiento = date('Y-m-d' , $fecha_vencimiento);
    
                }

                $user->membresias()->attach($data['id_membresia'], [
                    'fecha_pago_membresia' => $fecha_pago,
                    'fecha_venci_membresia' => $fecha_vencimiento,
                    'fecha_acti_membresia' => $fecha_pago,
                ]);

            }elseif($data['estado_usuario'] == 2){

                $user->membresias()->attach($data['id_membresia'], [
                    'fecha_pago_membresia' => $fecha_pago,
                    'fecha_venci_membresia' => $fecha_pago,
                    'fecha_acti_membresia' => $fecha_pago,
                ]);

            }

            if ($data['id_rol'] !== 'undefined') {
                $user->roles()->attach($data['id_rol']);
            }

            if($request->hasFile('comprobante1') && $request->hasFile('comprobante2')){

                $imagen1 = $request->file('comprobante1');
                $filename1 = $imagen1->getClientOriginalName();
                $path1 = $imagen1->storeAs('comprobantes', $filename1, 'public');
            
                $imagen2 = $request->file('comprobante2');
                $filename2 = $imagen2->getClientOriginalName();
                $path2 = $imagen2->storeAs('comprobantes', $filename2, 'public');
            
                $archivo1 = new Archivo(['url' => $path1]);
                $archivo2 = new Archivo(['url' => $path2]);
                $user->archivos()->saveMany([$archivo1, $archivo2]);

            }

            return response()->json([
                'data' => $user,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);
        }

    }

    public function listarUsuariosHabilitados(Request $request) {

        $text = $request->nombre;

        $users = User::select('users.id','users.nombre_usuario', 'users.rut_usuario' ,'users.apellido_pate_usuario', 'users.numero_tele_usuario' ,'users.apellido_mate_usuario', 'users.email', 'users.calle_usuario', 'users.numero_casa_usuario', 'users.fecha_naci_usuario', 'users.estado_usuario','roles.id as id_rol', 'roles.tipo_rol')
                                ->leftJoin('role_user', 'users.id', '=', 'role_user.id_usuario')
                                ->leftJoin('roles', 'roles.id', '=', 'role_user.id_rol')
                                ->whereIn('users.estado_usuario',[1, 3, 4])
                                ->where(function ($query) use ($text) {
                                    $query->where('users.nombre_usuario', 'like', "%$text%")
                                    ->orWhere('users.rut_usuario', 'like', "%$text%");
                                })
                                ->orderBy('id', 'asc')->get() ; 

        return response()->json([
            'data' => $users
        ]);

    }

    public function listarUsuariosPendientes(Request $request) {

        $text = $request->nombre;

        $users = User::select('users.id', 'users.nombre_usuario', 'users.rut_usuario', 'users.apellido_pate_usuario', 'users.numero_tele_usuario', 'users.apellido_mate_usuario', 'users.email', 'users.calle_usuario', 'users.numero_casa_usuario', 'users.fecha_naci_usuario', 'users.estado_usuario', 'roles.id as id_rol', 'roles.tipo_rol')
                        ->leftJoin('role_user', 'users.id', '=', 'role_user.id_usuario')
                        ->leftJoin('roles', 'roles.id', '=', 'role_user.id_rol')
                        ->leftJoin('archivos', function ($join) {
                            $join->on('users.id', '=', 'archivos.imageable_id')
                                ->where('archivos.imageable_type', '=', 'App\Models\User');
                        })
                        ->select('users.id', 'users.nombre_usuario', 'users.rut_usuario', 'users.apellido_pate_usuario', 'users.numero_tele_usuario', 'users.apellido_mate_usuario', 'users.email', 'users.calle_usuario', 'users.numero_casa_usuario', 'users.fecha_naci_usuario', 'users.estado_usuario', 'roles.id as id_rol', 'roles.tipo_rol')
                        ->with(['archivos' => function($query) {
                            $query->select('id', 'imageable_id');
                        }])
                        ->where('users.estado_usuario', '=', '2')
                        ->where(function ($query) use ($text) {
                            $query->where('users.nombre_usuario', 'like', "%$text%")
                            ->orWhere('users.rut_usuario', 'like', "%$text%");
                        })
                        ->groupBy('users.id', 'users.nombre_usuario', 'users.rut_usuario', 'users.apellido_pate_usuario', 'users.numero_tele_usuario', 'users.apellido_mate_usuario', 'users.email', 'users.calle_usuario', 'users.numero_casa_usuario', 'users.fecha_naci_usuario', 'users.estado_usuario', 'roles.id', 'roles.tipo_rol')
                        ->orderBy('users.id', 'asc')
                        ->get();

        return response()->json([
            'data' => $users
        ]);

    }
    
    public function actualizarUsuario(actualizarUsuarioRequest $request, User $user){

        try {

            $user->update($request->all());

            if($request->id_rol){
                $user->roles()->sync($request->id_rol);
            }else{
                $user->roles()->detach();
            }

            return response()->json([
                'data' => $user,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }

    }

    public function eliminarUsuario(Request $request, User $user){
        
        try {
            
            $user->update(['estado_usuario' => $request->estado_usuario]);

            return response()->json([
                'data' => $user
            ]);
            
        }
        catch (\Exception $e)
        {
            return response()->json(["error" => $e]);
        }

    }

    public function habilitarUsuario(Request $request, User $user){

        try {

            $user->update(['estado_usuario' => $request->estado_usuario]);

            return response()->json([
                'data' => $user
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }

    }

    public function rechazarComprobante(Request $request, User $user){

        try {

            $user->update(['estado_usuario' => $request->estado_usuario]);

            return response()->json([
                'data' => $user
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }

    }

    public function renovarComprobante(Request $request, User $user){

        try {

            $user->update(['estado_usuario' => $request->estado_usuario]);

            $fecha_pago = date('Y-m-d');

            $fecha_vencimiento = null;

            if($request->id_membresia == 1){

                $fecha_vencimiento = strtotime('+12 months', strtotime($fecha_pago));
                $fecha_vencimiento = date('Y-m-d' , $fecha_vencimiento);

            }elseif($request->id_membresia == 2){

                $fecha_vencimiento = strtotime('+6 months', strtotime($fecha_pago));
                $fecha_vencimiento = date('Y-m-d' , $fecha_vencimiento);

            }

            $user->membresias()->sync([$request->id_membresia => [
                'fecha_pago_membresia' => $fecha_pago,
                'fecha_venci_membresia' => $fecha_vencimiento,
                'fecha_acti_membresia' => $fecha_pago,
            ]]);

            return response()->json([
                'data' => $user
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }

    }

    public function verificarExistenciaUsuario($registroRut)
    {
        $usuario = User::where('rut_usuario', $registroRut)->first();

        if ($usuario) {
            // El usuario está registrado en la base de datos
            return response()->json(['data' => true]);
        } else {
            // El usuario no está registrado en la base de datos
            return response()->json(['data' => false]);
        }
    }

    public function descargarComprobante($id){

        try {

            $rutaArchivo = Archivo::findOrFail($id)->url;
            $urlArchivo = public_path('storage/' . $rutaArchivo);

            return response()->download($urlArchivo);
            
        }
        catch(\Exception $e){

            return response()->json(['error' => 'Error al obtener el archivo.'], 500);

        }
    
    }

     // public function eliminarUsuario(User $user){
        
    //     try {
    //         $ifexist = User::where('id', $user->id)->first();
    //         if ($ifexist != null){
    //             $usuarios = User::find($user->id)->delete();
    //             return response()->json(["data" => $usuarios], 200);
    //         }
    //         return response()->json(["msg" => "El id del usuario que intenta eliminar no existe"], 401);
    //     }
    //     catch (\Exception $e)
    //     {
    //         return response()->json(["error" => $e]);
    //     }

    // }

}
