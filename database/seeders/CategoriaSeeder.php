<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new Categoria();

        $categoria->tipo_categoria = 'Evento';

        $categoria->save();

        $categoria = new Categoria();;

        $categoria->tipo_categoria = 'Noticia';

        $categoria->save();

    }
}
