<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Libro;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function reservarLibro(Request $request)
    {
        
        try {

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

        $text = $request->nombre;

        $reservas = Reserva::select('reservas.id', 'reservas.id_libro' , 'reservas.id_usuario', 'reservas.fecha_reserva', 'reservas.estado_reserva','users.rut_usuario' ,'users.nombre_usuario', 'users.apellido_pate_usuario','libros.titulo_libro')
        ->join('users', 'reservas.id_usuario', '=', 'users.id')
        ->join('libros', 'reservas.id_libro', '=', 'libros.id')
        ->where('reservas.estado_reserva', '1')
        ->where('users.nombre_usuario','like',"%$text%")
        ->groupBy('reservas.id', 'reservas.id_libro' , 'reservas.id_usuario', 'reservas.fecha_reserva', 'reservas.estado_reserva' ,'users.rut_usuario', 'users.nombre_usuario',  'users.apellido_pate_usuario', 'libros.titulo_libro')
        ->orderBy('reservas.id', 'asc')
        ->get();

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
