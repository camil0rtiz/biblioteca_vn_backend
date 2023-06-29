<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\MembresiaController;
use App\Http\Controllers\Api\LibroController;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\EditorialController;
use App\Http\Controllers\Api\EjemplarController;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\PrestamoController;
use App\Http\Controllers\Api\ReservaController;

Route::post('usuarios/agregar', [AuthController::class, 'agregarUsuario']);
Route::post('usuarios/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('usuarios')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('listarHabilitados', [AuthController::class, 'listarUsuariosHabilitados']);
    Route::get('listarPendientes', [AuthController::class, 'listarUsuariosPendientes']);
    Route::put('actualizar/{user}', [AuthController::class, 'actualizarUsuario']);
    Route::delete('eliminar/{user}', [AuthController::class,'eliminarUsuario']);
    Route::put('habilitar/{user}', [AuthController::class, 'habilitarUsuario']);
    Route::get('comprobante/{user}', [AuthController::class, 'descargarComprobante']);
});

Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('listar', [RoleController::class, 'listarRoles']);
});

Route::middleware(['auth:sanctum'])->prefix('membresias')->group(function () {
    Route::get('listar', [MembresiaController::class, 'listarMembresias']);
});

Route::prefix('libros')->group(function () {
    Route::post('agregar', [LibroController::class, 'agregarLibro']);
    Route::get('listar', [LibroController::class, 'listarLibros']);
    Route::get('buscarId', [LibroController::class, 'buscarLibroPorId']);
    Route::put('actualizar/{libro}', [LibroController::class, 'actualizarLibro']);
    Route::put('eliminar/{libro}', [LibroController::class, 'actualizarLibro']);
});

Route::middleware(['auth:sanctum'])->prefix('autores')->group(function () {
    Route::post('agregar', [AutorController::class, 'agregarAutor']);
    Route::get('listar', [AutorController::class, 'listarAutores']);
    Route::get('buscar', [AutorController::class, 'buscarAutor']);
    Route::put('actualizar/{autore}', [AutorController::class, 'actualizarAutor']);
    Route::put('eliminar/{autore}', [AutorController::class, 'eliminarAutor']);
});

Route::middleware(['auth:sanctum'])->prefix('editoriales')->group(function () {
    Route::post('agregar', [EditorialController::class, 'agregarEditorial']);
    Route::get('listar', [EditorialController::class, 'listarEditoriales']);
    Route::get('buscar', [EditorialController::class, 'buscarEditorial']);
    Route::put('actualizar/{editoriale}', [EditorialController::class, 'actualizarEditorial']);
    Route::put('eliminar/{editoriale}', [EditorialController::class, 'eliminarEditorial']);
});

Route::middleware(['auth:sanctum'])->prefix('ejemplares')->group(function () {
    Route::post('agregar', [EjemplarController::class, 'agregarEjemplar']);
    Route::get('listar', [EjemplarController::class, 'listarEjemplares']);
});

Route::get('eventos/listarEventosHome', [EventoController::class, 'listarEventosHome']);

Route::middleware(['auth:sanctum'])->prefix('eventos')->group(function () {
    Route::post('agregar', [EventoController::class, 'agregarEvento']);
    Route::get('listar', [EventoController::class, 'listarEventos']);
    Route::put('actualizar/{evento}', [EventoController::class, 'actualizarEvento']);
    Route::put('eliminar/{evento}', [EventoController::class, 'eliminarEvento']);
});

Route::middleware(['auth:sanctum'])->prefix('categorias')->group(function () {
    Route::get('listar', [CategoriaController::class, 'listarCategorias']);
});

Route::middleware(['auth:sanctum'])->prefix('reservas')->group(function () {
    Route::post('reservar', [ReservaController::class, 'reservarLibro']);
    Route::get('listar', [ReservaController::class, 'listarReservas']);
    Route::put('eliminar/{reserva}', [ReservaController::class, 'eliminarReserva']);
});

Route::middleware(['auth:sanctum'])->prefix('prestamos')->group(function () {
    Route::post('prestar', [PrestamoController::class, 'prestarLibro']);
    Route::get('listar', [PrestamoController::class, 'listarPrestamos']);
    Route::put('devolver/{prestamo}', [PrestamoController::class, 'devolverPrestamos']);
    
});