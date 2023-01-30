<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();

        $role->tipo_rol = 'Admin';

        $role->save();

        $role = new Role();

        $role->tipo_rol = 'Voluntario';

        $role->save();
    }
}
