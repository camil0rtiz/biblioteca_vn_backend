<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{

    public function prestarLibro(Request $request)
    {
        
        try {

            foreach($request->id_ejemplar as $ejemplar){
                
                $prestamo = Prestamo::create([
                    'id_vecino' => $request->id_vecino,
                    'id_ejemplar'=> $ejemplar,
                    'estado_prestamo' => $request->estado_prestamo,
                ]);

            }

            return response()->json([
                'data' => $prestamo
            ]);

        }catch (Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador',
                'error' => $e
            ]);
        
        }
    }

}
