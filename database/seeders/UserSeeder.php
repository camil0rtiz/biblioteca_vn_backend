<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::Create([
        //     'rut_usuario' => '194176163',
        //     'email_usuario' => 'camilo@gmail.com' 
        // ]);

        User::factory(99)->create();
    }
}
