<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
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

        $libros = Libro::select('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro', 'libros.stock_libro','archivos.url', 'archivos.id as id_portada',
            DB::raw('(SELECT COUNT(*) FROM ejemplares WHERE ejemplares.id_libro = libros.id AND ejemplares.estado_ejemplar IN (1, 2)) as cantidad_ejemplares'),
            DB::raw('(SELECT COUNT(*) FROM reservas WHERE reservas.id_libro = libros.id AND reservas.estado_reserva = 1) as cantidad_reservas'
        ))
        ->leftJoin('autor_libro', 'libros.id', '=', 'autor_libro.id_libro')
        ->leftJoin('autores', 'autores.id', '=', 'autor_libro.id_autor')
        ->leftJoin('archivos', function ($join) {
            $join->on('libros.id', '=', 'archivos.imageable_id')
                ->where('archivos.imageable_type', '=', 'App\Models\Libro');
        })
        ->with(['ejemplares' => function($query) {
            $query->select('ejemplares.*', 'libros.titulo_libro')
                ->join('libros', 'ejemplares.id_libro', '=', 'libros.id')
                ->whereIn('ejemplares.estado_ejemplar', [1, 2]);
        }])
        ->selectRaw('GROUP_CONCAT(autor_libro.id_autor) as idAutor')
        ->selectRaw('GROUP_CONCAT(autores.nombre_autor) as nombreAutor')
        ->where(function ($query) use ($text) {
            $query->where('libros.titulo_libro', 'like', "%$text%")
            ->orWhere('libros.dewey_libro', 'like', "%$text%");
        })
        ->groupBy('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro','libros.stock_libro','archivos.url', 'archivos.id')
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
                "id_portada" =>  $libro->id_portada,
                "cantidad_ejemplares" =>  $libro->cantidad_ejemplares,
                "cantidad_reservas" =>  $libro->cantidad_reservas,
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

    public function listarMasReservados()
    {

        $libros = Libro::select('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro', 'libros.stock_libro','archivos.url', \DB::raw('COUNT(reservas.id) as reservas_count'))
        ->join('reservas', 'libros.id', '=', 'reservas.id_libro')
        ->leftJoin('autor_libro', 'libros.id', '=', 'autor_libro.id_libro')
        ->leftJoin('autores', 'autores.id', '=', 'autor_libro.id_autor')
        ->leftJoin('archivos', function ($join) {
            $join->on('libros.id', '=', 'archivos.imageable_id')
                ->where('archivos.imageable_type', '=', 'App\Models\Libro');
        })
        ->selectRaw('GROUP_CONCAT(autor_libro.id_autor) as idAutor')
        ->selectRaw('GROUP_CONCAT(autores.nombre_autor) as nombreAutor')
        ->groupBy('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro', 'libros.stock_libro','archivos.url')
        ->orderBy('reservas_count', 'DESC')
        ->take(10)
        ->get();

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
        ]);
    }

    public function listarUltimosAgregados()
    {

        $libros = Libro::select('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro', 'libros.stock_libro','archivos.url')
        ->leftJoin('autor_libro', 'libros.id', '=', 'autor_libro.id_libro')
        ->leftJoin('autores', 'autores.id', '=', 'autor_libro.id_autor')
        ->leftJoin('archivos', function ($join) {
            $join->on('libros.id', '=', 'archivos.imageable_id')
                ->where('archivos.imageable_type', '=', 'App\Models\Libro');
        })
        ->selectRaw('GROUP_CONCAT(autor_libro.id_autor) as idAutor')
        ->selectRaw('GROUP_CONCAT(autores.nombre_autor) as nombreAutor')
        ->groupBy('libros.id','libros.titulo_libro','libros.dewey_libro','libros.resena_libro','libros.anio_publi_libro','libros.stock_libro','archivos.url')
        ->orderBy('libros.id', 'DESC')
        ->take(10)
        ->get();

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
            
            $libroExistente = Libro::where('dewey_libro', $data['dewey_libro'])->first();

            if($libroExistente) {

                return response()->json([
                    "message" => 'El código dewey libro ya se encuentra registrado',
                ], 400); // Respuesta de error con código 400 (Bad Request)

            }

            $libro = Libro::create([
                'titulo_libro' => $data['titulo_libro'],
                'dewey_libro' => $data['dewey_libro'],
                'anio_publi_libro' => $data['anio_publi_libro'],
                'resena_libro' => $data['resena_libro'],
                'estado_libro' => $data['estado_libro'],
            ]);

            $idAutores = explode(',', $data['id_autor']);

            $libro->autores()->attach($idAutores);
        
            if($request->hasFile('portada')){

                $portada = $request->file('portada');
                $filename = $portada->getClientOriginalName();
                $url = $portada->store('portadas','public');

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

    public function actualizarPortadaLibro(Request $request)
    {
        try {

            $idLibro = $request->input('id_libro');
            $urlImagen = $request->file('portada')->store('portadas', 'public');
    
            // Obtener el libro al que deseas cambiar la portada
            $libro = Libro::findOrFail($idLibro);

            if ($request->hasFile('portada')) {

                $portada = $request->file('portada');
                $filename = $portada->getClientOriginalName();
                $url = $portada->store('portadas','public');

                $file = new Archivo([
                    'url' => $url,
                ]);
                
                if ($libro->archivo) {
                    $libro->archivo->delete();
                }
                
                $libro->archivo()->save($file);

            }

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
