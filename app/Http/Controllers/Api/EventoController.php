<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function listarEventos()
    {
        $eventos = Evento::all();

        return response()->json([
            'data' => $eventos
        ]);
    }

    public function agregarEvento(Request $request)
    {
        try {

            $evento = Evento::create([
                'id_categoria' => $request->id_categoria,
                'id_usuario' => $request->id_usuario,
                'titulo_evento' => $request->titulo_evento,
                'descripcion_evento' => $request->descripcion_evento,
                'estado_evento' => $request->estado_evento
            ]);

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
