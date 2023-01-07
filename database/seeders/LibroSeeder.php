<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Libro::factory(100)->create()->each(function(Libro $libros){

            $libros->autores()->attach([
                rand(5,8),
                rand(2,8)
            ]);

        });
    }
}


