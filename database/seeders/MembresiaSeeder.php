<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Membresia;


class MembresiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $membresia = new Membresia();

        $membresia->tipo_membresia = 'Anual';

        $membresia->save();

        $membresia = new Membresia();

        $membresia->tipo_membresia = 'Semestral';

        $membresia->save();
    }
}
