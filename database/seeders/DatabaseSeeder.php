<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Membresia;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Autore;
use App\Models\Editoriale;
use App\Models\Ejemplare;
use App\Models\Prestamo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // User::factory(100)->create();
        
        // \App\Models\User::factory(10)->create(); //otra forma de hacer
        
        $this->call(RoleSeeder::class);
        $this->call(MembresiaSeeder::class);
        $this->call(CategoriaSeeder::class);

        // Role::factory(100)->create();
        // Membresia::factory(100)->create();
        // $this->call(UserSeeder::class);
        // Categoria::factory(100)->create();
        // Evento::factory(100)->create();
        // Autore::factory(100)->create();
        // $this->call(LibroSeeder::class);
        // Editoriale::factory(100)->create();
        // Ejemplare::factory(100)->create();
        // Prestamo::factory(100)->create();
    }

}
