<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ejemplare;
use Illuminate\Http\Request;

class EjemplarController extends Controller
{

    public function listarEjemplares()
    {
        $ejemplares = Ejemplare::all();

        return response()->json([
            'data' => $ejemplares
        ]);
    }

    public function agregarEjemplar(Request $request)
    {
        try {

            $ejemplar = Ejemplare::create([
                'id_libro' => $request->id_libro,
                'id_editorial' => $request->id_editorial,
            ]);

            return response()->json([
                'data' => $ejemplar
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

}
