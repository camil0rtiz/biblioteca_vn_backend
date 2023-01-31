<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;

Route::post('usuarios/agregar', [AuthController::class, 'agregarUsuario']);
Route::post('usuarios/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->prefix('usuarios')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('listar', [AuthController::class, 'listarUsuarios']);
    Route::put('actualizar/{user}', [AuthController::class, 'actualizarUsuario']);
});

Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('listar', [RoleController::class, 'listarRoles']);
});