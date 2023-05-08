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

Route::post('usuarios/agregar', [AuthController::class, 'agregarUsuario']);
Route::post('usuarios/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('usuarios')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('listar', [AuthController::class, 'listarUsuarios']);
    Route::put('actualizar/{user}', [AuthController::class, 'actualizarUsuario']);
    Route::put('habilitar/{user}', [AuthController::class, 'habilitarUsuario']);
    Route::delete('eliminar/{user}', [AuthController::class,'eliminarUsuario']);
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
});

Route::middleware(['auth:sanctum'])->prefix('autores')->group(function () {
    Route::post('agregar', [AutorController::class, 'agregarAutor']);
    Route::get('listar', [AutorController::class, 'listarAutores']);
    Route::put('actualizar/{autore}', [AutorController::class, 'actualizarAutor']);
});

Route::middleware(['auth:sanctum'])->prefix('editoriales')->group(function () {
    Route::post('agregar', [EditorialController::class, 'agregarEditorial']);
    Route::get('listar', [EditorialController::class, 'listarEditoriales']);
    Route::get('buscar', [EditorialController::class, 'buscarEditorial']);
    Route::put('actualizar/{editoriale}', [EditorialController::class, 'actualizarEditorial']);
});

Route::middleware(['auth:sanctum'])->prefix('ejemplares')->group(function () {
    Route::post('agregar', [EjemplarController::class, 'agregarEjemplar']);
    Route::get('listar', [EjemplarController::class, 'listarEjemplares']);
});

Route::get('eventos/listarEventosHome', [EventoController::class, 'listarEventosHome']);

Route::middleware(['auth:sanctum'])->prefix('eventos')->group(function () {
    Route::post('agregar', [EventoController::class, 'agregarEvento']);
    Route::get('listar', [EventoController::class, 'listarEventos']);
});

Route::middleware(['auth:sanctum'])->prefix('categorias')->group(function () {
    Route::get('listar', [CategoriaController::class, 'listarCategorias']);
});

Route::middleware(['auth:sanctum'])->prefix('prestamos')->group(function () {
    Route::post('reservar', [PrestamoController::class, 'reservarLibro']);
});