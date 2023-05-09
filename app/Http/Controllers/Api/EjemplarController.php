<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ejemplare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EjemplarController extends Controller
{

    public function listarEjemplares(Request $request)
    {

        $id = $request->id_libro;

        $ejemplares = Ejemplare::select('ejemplares.id','libros.titulo_libro','ejemplares.numero_regis_ejemplar','ejemplares.dewey_unic_ejemplar','ejemplares.anio_edi_ejemplar')
        ->join('editoriales', 'ejemplares.id_editorial', '=', 'editoriales.id')
        ->join('libros', 'ejemplares.id_libro', '=', 'libros.id')
        ->where('ejemplares.id_libro', '=', "$id")
        ->groupBy('ejemplares.id','libros.titulo_libro','ejemplares.numero_regis_ejemplar','ejemplares.dewey_unic_ejemplar','ejemplares.anio_edi_ejemplar')
        ->get();

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
                'numero_regis_ejemplar' => $request->numero_regis_ejemplar,
                'anio_edi_ejemplar' => $request->anio_edi_ejemplar,
                'dewey_unic_ejemplar' => $request->dewey_unic_ejemplar,
                'estado_ejemplar' => $request->estado_ejemplar,
            ]);

            return response()->json([
                'data' => $ejemplar,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

}
