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

Route::post('usuarios/agregar', [AuthController::class, 'agregarUsuario']);
Route::post('usuarios/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('usuarios')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('listar', [AuthController::class, 'listarUsuarios']);
    Route::get('listarBibliotecarios', [AuthController::class, 'listarBibliotecarios']);
    Route::put('actualizar/{user}', [AuthController::class, 'actualizarUsuario']);
    Route::delete('eliminar/{user}', [AuthController::class,'eliminarUsuario']);
});

Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('listar', [RoleController::class, 'listarRoles']);
});

Route::middleware(['auth:sanctum'])->prefix('membresias')->group(function () {
    Route::get('listar', [MembresiaController::class, 'listarMembresias']);
});

Route::middleware(['auth:sanctum'])->prefix('libros')->group(function () {
    Route::post('agregar', [LibroController::class, 'agregarLibro']);
    Route::get('listar', [LibroController::class, 'listarLibros']);
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
    Route::put('actualizar/{editoriale}', [EditorialController::class, 'actualizarEditorial']);
});

Route::middleware(['auth:sanctum'])->prefix('ejemplares')->group(function () {
    Route::post('agregar', [EjemplarController::class, 'agregarEjemplar']);
    Route::get('listar', [EjemplarController::class, 'listarEjemplares']);
});