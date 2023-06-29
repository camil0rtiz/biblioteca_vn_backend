<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{

    public function prestarLibro(Request $request)
    {
        
        try {

            foreach($request->id_ejemplar as $ejemplar){
                
                $prestamo = Prestamo::create([
                    'id_vecino' => $request->id_vecino,
                    'id_ejemplar'=> $ejemplar,
                    'estado_prestamo' => $request->estado_prestamo,
                ]);

            }

            return response()->json([
                'data' => $prestamo
            ]);

        }catch (Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador',
                'error' => $e
            ]);
        
        }
    }

    public function listarPrestamos()
    {
    
        try {

            $prestamos = Prestamo::select('prestamos.id','prestamos.id_vecino', 'prestamos.id_ejemplar','users.rut_usuario', 'users.nombre_usuario', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entrega_prestamo', 'prestamos.estado_prestamo')
            ->join('users', 'prestamos.id_vecino', '=', 'users.id')
            ->join('ejemplares', 'prestamos.id_ejemplar', '=', 'ejemplares.id')
            ->join('libros', 'libros.id', '=', 'ejemplares.id_libro')
            ->where('prestamos.estado_prestamo', '1')
            ->groupBy('prestamos.id','prestamos.id_vecino', 'prestamos.id_ejemplar','users.rut_usuario', 'users.nombre_usuario', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entrega_prestamo', 'prestamos.estado_prestamo')
            ->orderBy('prestamos.id', 'asc')
            ->get();
    
            return response()->json([
                'data' => $prestamos  
            ]);

        }catch (Exception $e) {

            return response()->json([
                "message" => 'Por favor hable con el Administrador',
                'error' => $e
            ]);
        
        }
    }

}
