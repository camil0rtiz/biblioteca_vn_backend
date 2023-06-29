<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Ejemplare;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{

    public function prestarLibro(Request $request)
    {
        
        try {

            foreach($request->id_ejemplar as $ejemplar){
                
                $prestamo = Prestamo::create([
                    'id_vecino' => $request->id_vecino,
                    'id_bibliotecario' => $request->id_bibliotecario, 
                    'id_ejemplar'=> $ejemplar,
                    'fecha_prestamo' => date('Y-m-d'),
                    'fecha_entre_prestamo' => date('Y-m-d', strtotime('+7 days')),
                    'estado_prestamo' => $request->estado_prestamo,
                ]);

                $ejemplar = Ejemplare::find($ejemplar);
    
                $ejemplar->estado_ejemplar = 2;
                
                $ejemplar->save();

            }

            return response()->json([
                'data' => $request->all()
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

            $prestamos = Prestamo::select('prestamos.id','prestamos.id_vecino', 'prestamos.id_ejemplar','users.rut_usuario', 'users.nombre_usuario', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entre_prestamo', 'prestamos.estado_prestamo')
            ->join('users', 'prestamos.id_vecino', '=', 'users.id')
            ->join('ejemplares', 'prestamos.id_ejemplar', '=', 'ejemplares.id')
            ->join('libros', 'libros.id', '=', 'ejemplares.id_libro')
            ->where('prestamos.estado_prestamo', '1')
            ->groupBy('prestamos.id','prestamos.id_vecino', 'prestamos.id_ejemplar','users.rut_usuario', 'users.nombre_usuario', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entre_prestamo', 'prestamos.estado_prestamo')
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
