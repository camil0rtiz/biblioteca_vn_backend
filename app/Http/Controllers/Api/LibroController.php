<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;
use App\Http\Requests\agregarLibroRequest;

class LibroController extends Controller
{
    
    public function listarLibros()
    {
        $libros = Libro::all();

        return response()->json([
            'data' => $libros
        ]);
    }

    public function agregarLibro(agregarLibroRequest $request)
    {
        try {

            $libro = Libro::create([
                'titulo_libro' => $request->titulo_libro,
                'isbn_libro' => $request->isbn_libro,
                'dewey_libro' => $request->dewey_libro,
                'resena_libro' => $request->resena_libro,
                'numero_pagi_libro' => $request->numero_pagi_libro,
                'categoria_libro' => $request->categoria_libro,
                'fecha_publi_libro' => $request->fecha_publi_libro,
                'estado_libro' => $request->estado_libro,
            ]);

            $libro->autores()->attach($request->id_autor);

            return response()->json([
                'data' => $libro,
            ]);

        }catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador',
                'error' => $e
            ]);
        
        }
    }

    public function actualizarLibro(Request $request, Libro $libro)
    {
        try {

            $libro->update($request->all());

            return response()->json([
                'data' => $libro
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }
    }

    public function eliminarLibro(Libro $libro)
    {
        //
    }
}
