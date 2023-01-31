<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;

Route::post('registrarUsuario', [AuthController::class, 'registrarUsuario']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('obtenerUsuarios', [AuthController::class, 'obtenerUsuarios']);
    Route::put('actualizarUsuario/{user}', [AuthController::class, 'actualizarUsuario']);
});

Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('obtenerRoles', [RoleController::class, 'obtenerRoles']);
});