<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reserva;
use App\Models\Libro;
use App\Models\Ejemplare;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function reservarLibro(Request $request)
    {
        
        try {

            $usuario = User::find($request->id_usuario);

            if (!$usuario || $usuario->estado_usuario !== 1) {
                
                return response()->json([
                    "message" => 'Usuario no esta habilitado para reservar libro',
                ], 400); 
                
            }

            $cant_libros_reser = count($request->id_libro);

            $num_de_reser = Reserva::where('id_usuario', $request->id_usuario)
                                    ->where('estado_reserva', 1)
                                    ->count();

            if($cant_libros_reser >= ( 2 - $num_de_reser )) {

                return response()->json([
                    "message" => 'Ya tienes libros reservados',
                ], 400); 

            }

            foreach ($request->id_libro as $id_libro) {
                
                $libro = Libro::find($id_libro);
        
                if ($libro && $libro->stock_libro <= 0) {
                    
                    return response()->json(['error' => 'El libro "' . $libro->titulo_libro . '" no tiene stock disponible para reserva'], 400);
                
                } 
            }
        
            foreach($request->id_libro as $libro){
                
                $reserva = Reserva::create([
                    'id_usuario' => $request->id_usuario,
                    'id_libro'=> $libro,
                    'fecha_reserva' => date('Y-m-d'),
                    'estado_reserva' => $request->estado_reserva,
                ]);

                $libro = Libro::find($libro);
                $libro->stock_libro -= 1;
                $libro->save();

            }

            return response()->json([
                'data' => $reserva,
            ]);

        }catch (Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador',
                'error' => $e
            ]);
        
        }
    }

    public function listarReservas(Request $request)
    {

        $text = $request->rut;

        $reservas = Reserva::select('reservas.id', 'reservas.id_libro' , 'reservas.id_usuario', 'reservas.fecha_reserva', 'reservas.estado_reserva','users.rut_usuario' ,'users.nombre_usuario', 'users.apellido_pate_usuario','libros.titulo_libro')
        ->join('users', 'reservas.id_usuario', '=', 'users.id')
        ->join('libros', 'reservas.id_libro', '=', 'libros.id')
        ->join('ejemplares', 'libros.id', '=', 'ejemplares.id_libro')
        ->where('reservas.estado_reserva', '1')
        ->where('users.rut_usuario', '=', $text)
        ->groupBy('reservas.id', 'reservas.id_libro' , 'reservas.id_usuario', 'reservas.fecha_reserva', 'reservas.estado_reserva' ,'users.rut_usuario', 'users.nombre_usuario',  'users.apellido_pate_usuario', 'libros.titulo_libro')
        ->orderBy('reservas.id', 'asc')
        ->get();

        foreach ($reservas as $reserva) {
            $reserva->ejemplares = Ejemplare::where('id_libro', $reserva->id_libro)
            ->where('estado_ejemplar', 1)
            ->get();
        }

        return response()->json([
            'data' => $reservas
        ]);

    }

    public function eliminarReserva(Request $request, Reserva $reserva)
    {
        
        $reserva->update($request->all());

        $libroId = $reserva->id_libro;

        $libro = Libro::find($libroId);
        $libro->stock_libro += 1;
        $libro->save();

        return response()->json([
            'data' => $reserva  
        ]);

    }

}
