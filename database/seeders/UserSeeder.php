<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('users')->insertGetId([
            'rut_usuario' => '11111111-1',
            'password' => Hash::make('123456789'),
            'nombre_usuario' => 'Admin',
            'apellido_pate_usuario' => 'Admin',
            'email' => 'admin@gmail.com',
            'estado_usuario' => 1
        ]);

        DB::table('role_user')->insert([
            'id_rol' => $userId,
            'id_usuario' => 1,
        ]);
    }
}
