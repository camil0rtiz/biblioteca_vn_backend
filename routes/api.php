<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\MembresiaController;
use App\Http\Controllers\Api\LibroController;

Route::post('usuarios/agregar', [AuthController::class, 'agregarUsuario']);
Route::post('usuarios/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('usuarios')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('listar', [AuthController::class, 'listarUsuarios']);
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
});