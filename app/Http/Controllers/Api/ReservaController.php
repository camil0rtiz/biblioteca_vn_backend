<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
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
                    'estado_reserva' => $request->estado_reserva,
                ]);

            }

            return response()->json([
                'data' => $reserva  
            ]);

        }catch (Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador',
                'error' => $e
            ]);
        
        }
    }

}
