<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ResgisterController;
use App\Http\Controllers\Api\RoleController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [ResgisterController::class, 'store'])->name('register');
Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

// Route::apiResource('/roles', RoleController::class);