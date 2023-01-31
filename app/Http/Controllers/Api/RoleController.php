<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function obtenerRoles()
    {
        $roles = Role::all();

        return $roles;
    }

}
