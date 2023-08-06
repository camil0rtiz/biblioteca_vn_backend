<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Archivo;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function listarEventos(Request $request)
    {

        $text = $request->nombre;

        $eventos = Evento::select('eventos.id', 'eventos.titulo_evento', 'eventos.descripcion_evento', 'categorias.id as id_categoria', 'categorias.tipo_categoria')
        ->with('archivo:id,imageable_id,url')
        ->join('categorias', 'eventos.id_categoria', '=', 'categorias.id')
        ->where('estado_evento','=','1')
        ->where('titulo_evento','like',"%$text%")
        ->get();
        
        return response()->json([
            'data' => $eventos
        ]);
    }

    public function listarEventosHome()
    {
        $eventos = Evento::with('archivo')
                ->where('id_categoria', 1)
                ->where('estado_evento', 1)
                ->get();

        $noticias = Evento::with('archivo')
                ->where('id_categoria', 2)
                ->where('estado_evento', 1)
                ->get();

        $eventosHome = [
            'eventos' => $eventos,
            'noticias' => $noticias,
        ];

        return response()->json([
            'data' => $eventosHome
        ]);
    }

    public function agregarEvento(Request $request)
    {
        try {

            $data = $request->all(); 

            $evento = Evento::create([
                'id_categoria' => $data['id_categoria'],
                'id_usuario' => $data['id_usuario'],
                'titulo_evento' => $data['titulo_evento'],
                'descripcion_evento' => $data['descripcion_evento'],
                'estado_evento' => $data['estado_evento']
            ]);

            if ($request->hasFile('eventoImagen')) {

                $eventoImagen = $request->file('eventoImagen');

                $filename = $eventoImagen->getClientOriginalName();

                $url = $eventoImagen->store('eventos', 'public');

                $file = new Archivo([
                    'url' => $url,
                ]);
                
                $evento->archivo()->save($file);

            }

            return response()->json([
                'data' => $evento
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

    public function actualizarEvento(Request $request, Evento $evento)
    {
        try {

            $evento->update($request->all());

            return response()->json([
                'data' => $evento
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

    public function actualizarPortadaEvento(Request $request)
    {
        try {
            
            $idEvento = $request->input('id_evento');
            $urlImagen = $request->file('portada')->store('eventos', 'public');
    
            $evento = Evento::findOrFail($idEvento);

            if ($request->hasFile('portada')) {

                $eventoImagen = $request->file('portada');

                $filename = $eventoImagen->getClientOriginalName();

                $url = $eventoImagen->store('eventos','public');

                $file = new Archivo([
                    'url' => $url,
                ]);
                
                if ($evento->archivo) {
                    $evento->archivo->delete();
                }
                
                $evento->archivo()->save($file);

            }

            return response()->json([
                'data' => $evento
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

    public function eliminarEvento(Request $request, Evento $evento)
    {
        try {

            $evento->update($request->all());

            return response()->json([
                'data' => $evento
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

}

