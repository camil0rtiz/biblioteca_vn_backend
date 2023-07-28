<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use App\Models\Ejemplare;
use App\Models\Libro;
use App\Models\User;
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

                if($request->descontar_stock == 1){


                    $ejem = Ejemplare::find($ejemplar);
                    $libro = Libro::find($ejem->id_libro);
                    $libro->stock_libro -= 1;
                    $libro->save();

                }

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

    public function listarPrestamos(Request $request)
    {
        try {

            $text = $request->rut;

            $prestamos = Prestamo::select('prestamos.id','prestamos.id_vecino', 'prestamos.id_ejemplar','users.rut_usuario', 'users.nombre_usuario', 'libros.id AS id_libro', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entre_prestamo', 'prestamos.estado_prestamo')
            ->join('users', 'prestamos.id_vecino', '=', 'users.id')
            ->join('ejemplares', 'prestamos.id_ejemplar', '=', 'ejemplares.id')
            ->join('libros', 'libros.id', '=', 'ejemplares.id_libro')
            ->where('users.rut_usuario', '=', $text)
            ->where('prestamos.estado_prestamo', '1')
            ->groupBy('prestamos.id','prestamos.id_vecino', 'prestamos.id_ejemplar','users.rut_usuario', 'users.nombre_usuario', 'libros.id', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entre_prestamo', 'prestamos.estado_prestamo')
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

    public function devolverPrestamos(Request $request, $id)
    {
    
        try {

            $prestamo = Prestamo::findOrFail($id);
            $prestamo->estado_prestamo = 2;
            $prestamo->fecha_rece_prestamo = date('Y-m-d');
            $prestamo->save();

            $ejemplar = Ejemplare::findOrFail($request->id_ejemplar);
            $ejemplar->estado_ejemplar = 1;
            $ejemplar->save();

            $libro = Libro::find($request->id_libro);
            $libro->stock_libro += 1;
            $libro->save();

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

    public function renovarPrestamo(Request $request, $id)
    {
    
        try {

            $prestamo = Prestamo::findOrFail($id);
            $prestamo->fecha_prestamo = date('Y-m-d');
            $prestamo->fecha_entre_prestamo = date('Y-m-d', strtotime('+7 days'));
            $prestamo->fecha_rece_prestamo = null;
            $prestamo->save();

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


}
