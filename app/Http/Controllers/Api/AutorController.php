<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autore;
use Illuminate\Http\Request;
use App\Http\Requests\agregarAutorRequest;
use App\Http\Requests\actualizarAutorRequest;

class AutorController extends Controller
{

    public function listarAutores()
    {
        $autores = Autore::all();

        return response()->json([
            'data' => $autores
        ]);
    }

    public function buscarAutor(Request $request)
    {

        $text = $request->nombre;

        $autores = Autore::select('id','nombre_autor')->where('nombre_autor','like',"%$text%")->get();

        return response()->json([
            'data' => $autores,
        ]);

    }

    public function agregarAutor(agregarAutorRequest $request)
    {
        try {

            $autor = Autore::create([
                'nombre_autor' => $request->nombre_autor,
                'estado_autor' => $request->estado_autor
            ]);

            return response()->json([
                'data' => $autor
            ]);

        }catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

    public function actualizarAutor(Request $request, Autore $autore)
    {
        try {

            $autore->update($request->all());

            return response()->json([
                'data' => $autore
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }
    }

    public function eliminarAutor(Request $request, Autore $autore)
    {
        try {

            $autore->update($request->all());

            return response()->json([
                'data' => $autore
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }
    }
}
