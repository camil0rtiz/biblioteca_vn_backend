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

            $usuario = User::find($request->id_vecino);

            if (!$usuario || $usuario->estado_usuario !== 1) {
                
                return response()->json([
                    "message" => 'Usuario no esta habilitado para prestar libro',
                ], 400); 
                
            }

            $cant_ejem_reser = count($request->id_ejemplar);

            $num_de_presta = Prestamo::where('id_vecino', $request->id_vecino)
            ->where('estado_prestamo', 1)
            ->count();

            if($cant_ejem_reser > ( 2 - $num_de_presta)) {

                return response()->json([
                    "message" => 'Ya tienes ejemplares prestados',
                ], 400); 

            }

            foreach ($request->id_ejemplar as $id_ejemplar) {
                
                $ejemplar = Ejemplare::find($id_ejemplar);
        
                if ($ejemplar && $ejemplar->estado_ejemplar == 2) {
                    
                    return response()->json(['error' => 'El ejemplar "' . $ejemplar->dewey_unic_ejemplar . '" no está disponible para prestamo'], 400);
                
                } 
            }
        
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
                'data' => $prestamo
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

            $prestamos = Prestamo::select('prestamos.id', 'prestamos.id_vecino', 'prestamos.id_ejemplar', 'users.rut_usuario', 'users.nombre_usuario', 'libros.id AS id_libro', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entre_prestamo', 'prestamos.estado_prestamo')
            ->join('users', 'prestamos.id_vecino', '=', 'users.id')
            ->leftJoin('ejemplares', 'prestamos.id_ejemplar', '=', 'ejemplares.id')
            ->join('libros', 'libros.id', '=', 'ejemplares.id_libro')
            ->where('users.rut_usuario', '=', $text)
            ->where('prestamos.estado_prestamo', '1')
            ->groupBy('prestamos.id', 'prestamos.id_vecino', 'prestamos.id_ejemplar', 'users.rut_usuario', 'users.nombre_usuario', 'libros.id', 'libros.titulo_libro', 'ejemplares.dewey_unic_ejemplar', 'prestamos.fecha_prestamo', 'prestamos.fecha_entre_prestamo', 'prestamos.estado_prestamo')
            ->with(['ejemplar' => function($query) {
                $query->select('ejemplares.*', 'libros.titulo_libro')
                    ->join('libros', 'ejemplares.id_libro', '=', 'libros.id');
            }])
            ->orderBy('prestamos.id', 'asc')
            ->get();

            $prestamos->map(function ($prestamo) {
                $prestamo->ejemplares = [$prestamo->ejemplar->toArray()];
                unset($prestamo->ejemplar);
                return $prestamo;
            });

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
