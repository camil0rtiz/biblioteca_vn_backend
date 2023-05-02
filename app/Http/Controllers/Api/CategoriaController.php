<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function listarCategorias()
    {
        $categorias = Categoria::all();

        return response()->json([
            'data' => $categorias
        ]);
    }
}
