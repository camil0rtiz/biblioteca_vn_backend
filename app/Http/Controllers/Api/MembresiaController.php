<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiaController extends Controller
{

    public function listarMembresias()
    {
        $membresias = Membresia::all();

        return response()->json([
            'data' => $membresias
        ]);
    }

}
