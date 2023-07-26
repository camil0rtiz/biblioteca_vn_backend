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
        ->with('archivos:imageable_id,url')
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
        $eventos = Evento::with('archivos')
        ->where('estado_evento', '=', '1')
        ->get();

        return response()->json([
            'data' => $eventos
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

            if ($request->hasFile('imagenesEvento')) {

                $archivos = [];
    
                foreach ($request->file('imagenesEvento') as $imagen) {

                    $filename = $imagen->getClientOriginalName();

                    $path = $imagen->storeAs('eventos', $filename, 'public');

                    $archivos[] = new Archivo(['url' => $path]);

                }
    
                $evento->archivos()->saveMany($archivos);

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
