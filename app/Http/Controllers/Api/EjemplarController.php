<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ejemplare;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EjemplarController extends Controller
{

    public function agregarEjemplar(Request $request)
    {
        try {

            $consulta = Ejemplare::selectRaw('COUNT(*) as total_ejemplares')
                ->join('libros', 'ejemplares.id_libro', '=', 'libros.id')
                ->where('libros.id', $request->id_libro)
                ->where('ejemplares.anio_edi_ejemplar', $request->anio_edi_ejemplar)
                ->get();

            $totalEjemplares = $consulta[0]->total_ejemplares + 1;

            $ejemplar = Ejemplare::create([
                'id_libro' => $request->id_libro,
                'id_editorial' => $request->id_editorial,
                'anio_edi_ejemplar' => $request->anio_edi_ejemplar,
                'isbn_ejemplar' => $request->isbn_ejemplar,
                'numero_pagi_ejemplar' => $request->numero_pagi_ejemplar,
                'dewey_unic_ejemplar' => $request->dewey_unic_ejemplar . ' C' . $totalEjemplares,
                'estado_ejemplar' => $request->estado_ejemplar,
            ]);

            $libro = Libro::find($request->id_libro);
            $libro->stock_libro += 1;
            $libro->save();

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

    public function listarEjemplares(Request $request)
    {

        $id = $request->id_libro;

        $ejemplares = Ejemplare::select('ejemplares.id','libros.titulo_libro','ejemplares.numero_regis_ejemplar','ejemplares.dewey_unic_ejemplar','ejemplares.anio_edi_ejemplar')
        ->join('editoriales', 'ejemplares.id_editorial', '=', 'editoriales.id')
        ->join('libros', 'ejemplares.id_libro', '=', 'libros.id')
        ->where('ejemplares.id_libro', '=', "$id")
        ->where('ejemplares.estado_ejemplar', '=', '1')
        ->groupBy('ejemplares.id','libros.titulo_libro','ejemplares.numero_regis_ejemplar','ejemplares.dewey_unic_ejemplar','ejemplares.anio_edi_ejemplar')
        ->get();

        return response()->json([
            'data' => $ejemplares
        ]);

    }

    public function eliminarEjemplar(Request $request, Ejemplare $ejemplare)
    {

        $ejemplare->update($request->all());

        return response()->json([
            'data' => $ejemplare
        ]);

    }

}
