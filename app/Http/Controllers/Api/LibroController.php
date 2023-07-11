<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use App\Models\Archivo;
use Illuminate\Http\Request;
use App\Http\Requests\agregarLibroRequest;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
    public function listarLibros(Request $request)
    {

        $cantidad = intval($request->per_page);
        $text = $request->nombre;

        $libros = Libro::select('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro', 'libros.stock_libro','archivos.url')
        ->leftJoin('autor_libro', 'libros.id', '=', 'autor_libro.id_libro')
        ->leftJoin('autores', 'autores.id', '=', 'autor_libro.id_autor')
        ->leftJoin('archivos', function ($join) {
            $join->on('libros.id', '=', 'archivos.imageable_id')
                ->where('archivos.imageable_type', '=', 'App\Models\Libro');
        })
        ->with(['ejemplares' => function($query) {
            $query->select('ejemplares.*', 'libros.titulo_libro')
                ->join('libros', 'ejemplares.id_libro', '=', 'libros.id');
        }])
        ->selectRaw('GROUP_CONCAT(autor_libro.id_autor) as idAutor')
        ->selectRaw('GROUP_CONCAT(autores.nombre_autor) as nombreAutor')
        ->where('libros.titulo_libro','like',"%$text%")
        ->groupBy('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro','libros.stock_libro','archivos.url')
        ->paginate($cantidad);

        $nuevoConjunto = [];

        foreach($libros as $clave => $libro) {
            $nuevoConjunto[$clave] = [
                "id" => $libro->id,
                "titulo_libro" => $libro->titulo_libro,
                "dewey_libro" => $libro->dewey_libro,
                "resena_libro" => $libro->resena_libro,
                "anio_publi_libro" => $libro->anio_publi_libro,
                "stock_libro" => $libro->stock_libro,
                "ejemplares" => $libro->ejemplares,
                "url" =>  $libro->url,
                "autor" => [
                    "value" => explode(",", $libro->idAutor), 
                    "label" => explode(",", $libro->nombreAutor)
                ],
            ];
        }

        return response()->json([
            'data' => $nuevoConjunto,
            'data2' => $libros,
        ]);
    }

    public function listarMasReservados(Request $request)
    {

        return response()->json([
            'data' => $request,
        ]);
    }

    public function listarUltimosAgregados(Request $request)
    {

        

        return response()->json([
            'data' => $request,
        ]);
    }


    public function buscarLibroPorId(Request $request)
    {

        $id = $request->id_libro;

        $libros = Libro::select('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro','libros.stock_libro','archivos.url')
        ->leftJoin('autor_libro', 'libros.id', '=', 'autor_libro.id_libro')
        ->leftJoin('autores', 'autores.id', '=', 'autor_libro.id_autor')
        ->leftJoin('archivos', 'libros.id', '=', 'archivos.imageable_id')
        ->selectRaw('GROUP_CONCAT(autor_libro.id_autor) as idAutor')
        ->selectRaw('GROUP_CONCAT(autores.nombre_autor) as nombreAutor')
        ->where('libros.id','=',"$id")
        ->groupBy('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro','libros.stock_libro','archivos.url')
        ->get();

        $nuevoConjunto = [];

        foreach($libros as $libro) {
            $nuevoConjunto= [
                "id" => $libro->id,
                "titulo_libro" => $libro->titulo_libro,
                "dewey_libro" => $libro->dewey_libro,
                "resena_libro" => $libro->resena_libro,
                "anio_publi_libro" => $libro->anio_publi_libro,
                "stock_libro" => $libro->stock_libro,
                "url" =>  $libro->url,
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
    
    public function agregarLibro(Request $request)
    {
        try {

            $data = $request->all(); 

            $libro = Libro::create([
                'titulo_libro' => $data['titulo_libro'],
                'dewey_libro' => $data['dewey_libro'],
                'anio_publi_libro' => $data['anio_publi_libro'],
                'resena_libro' => $data['resena_libro'],
                'estado_libro' => $data['estado_libro'],
            ]);

            $libro->autores()->attach($data['id_autor']);
        
            if($request->hasFile('portada')){

                $portada = $request->file('portada');
                $filename = $portada->getClientOriginalName();
                $url = $portada->storeAs('portadas', $filename, 'public');

                $file = new Archivo([
                    'url' => $url,
                ]);
                
                $libro->archivo()->save($file);
        
            }

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

    public function eliminarLibro(Request $request, Libro $libro)
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
}
