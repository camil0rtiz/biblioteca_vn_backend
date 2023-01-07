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

        User::factory(99)->create()->each(function(User $user){

            $user->roles()->attach([
                rand(5,8),
                rand(2,8)
            ]);

        });

        User::factory(100)->create()->each(function(User $user){
        
            $user->membresias()->attach([
                rand(5,8),
                rand(2,8),], [
                    'fecha_pago_paga' => today(),
                    'fecha_venci_paga' => today(),
                    'fecha_acti_paga' => today(),
                ],
            );

        });
    }
}
