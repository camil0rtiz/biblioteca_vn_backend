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
        $libros = Libro::select('libros.id','libros.titulo_libro','libros.dewey_libro','libros.isbn_libro','libros.resena_libro','libros.numero_pagi_libro','libros.categoria_libro','libros.fecha_publi_libro')
        ->leftJoin('autor_libro', 'libros.id', '=', 'autor_libro.id_libro')
        ->leftJoin('autores', 'autores.id', '=', 'autor_libro.id_autor')
        ->selectRaw('GROUP_CONCAT(autor_libro.id_autor) as idAutor')
        ->selectRaw('GROUP_CONCAT(autores.nombre_autor) as nombreAutor')
        ->groupBy('libros.id','libros.titulo_libro','libros.dewey_libro','libros.isbn_libro','libros.resena_libro','libros.numero_pagi_libro','libros.categoria_libro','libros.fecha_publi_libro')
        ->get();

        $nuevoConjunto = [];

        foreach($libros as $clave => $libro) {
            $nuevoConjunto[$clave] = [
                "id" => $libro->id,
                "titulo_libro" => $libro->titulo_libro,
                "dewey_libro" => $libro->dewey_libro,
                "isbn_libro" => $libro->isbn_libro,
                "resena_libro" => $libro->resena_libro,
                "numero_pagi_libro" => $libro->numero_pagi_libro,
                "categoria_libro" => $libro->categoria_libro,
                "fecha_publi_libro" => $libro->fecha_publi_libro,
                "autor" => [
                    "value" => explode(",", $libro->idAutor), 
                    "label" => explode(",", $libro->nombreAutor)
                ], 
            ];
        }

        return response()->json([
            'data' => $nuevoConjunto,
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

            $libro->autores()->sync($request->id_autor);
            
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
