<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('registrarUsuario', [AuthController::class, 'registrarUsuario']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('obtenerUsuarios', [AuthController::class, 'obtenerUsuarios']);
    Route::put('actualizarUsuario/{user}', [AuthController::class, 'actualizarUsuario']);
});


// Route::apiResource('/roles', RoleController::class);

//prefix sirve para ordenar las rutas segun su tipo ejemplo: rutas que tengan que ver con usuario, rutas que tengan que ver con libros

Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});