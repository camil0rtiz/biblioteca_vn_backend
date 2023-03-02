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
            'data' => $editoriales
        ]);
    }

    public function agregarEditorial(agregarEditorialRequest $request)
    {
        try {

            $editorial = Editoriale::create([
                'nombre_editorial' => $request->nombre_editorial,
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

    public function show(Editoriale $editoriale)
    {
        //
    }

    public function edit(Editoriale $editoriale)
    {
        //
    }

    public function update(Request $request, Editoriale $editoriale)
    {
        //
    }
    
    public function destroy(Editoriale $editoriale)
    {
        //
    }
}
