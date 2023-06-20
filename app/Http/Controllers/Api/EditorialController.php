<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Editoriale;
use Illuminate\Http\Request;
use App\Http\Requests\agregarEditorialRequest;
use App\Http\Requests\actualizarEditorialRequest;

class EditorialController extends Controller
{
    
    public function listarEditoriales()
    {

        $editoriales = Editoriale::all();

        return response()->json([
            'data' => $editoriales,   
        ]);
    }

    public function buscarEditorial(Request $request)
    {

        $text = $request->nombre;

        $editoriales = Editoriale::select('id','nombre_editorial')->where('nombre_editorial','like',"%$text%")->get();

        return response()->json([
            'data' => $editoriales,
        ]);
    }

    public function agregarEditorial(agregarEditorialRequest $request)
    {
        try {

            $editorial = Editoriale::create([
                'nombre_editorial' => $request->nombre_editorial,
                'estado_editorial' => $request->estado_editorial
            ]);

            return response()->json([
                'data' => $editorial
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }

    public function actualizarEditorial(actualizarEditorialRequest $request, Editoriale $editoriale )
    {
        try {

            $editoriale->update($request->all());

            return response()->json([
                'data' => $editoriale
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador'
            ]);

        }
    }

    public function eliminarEditorial(Request $request, Editoriale $editoriale)
    {
        try {

            $editoriale->update($request->all());

            return response()->json([
                'data' => $editoriale
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "error" => $e,
                "message" => 'Por favor hable con el Administrador'
            ]);
        
        }
    }
}
