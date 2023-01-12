<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();

        return $roles;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_rol' => 'required|max:10'
        ]);

        $role = Role::create($request->all());

        return $role;
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'tipo_rol' => 'required|max:10'
        ]);

        $role->update($request->all());

        return $role;

    }

    public function destroy(Role $role)
    {
        //
    }
}
