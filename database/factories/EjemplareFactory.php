<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Libro;
use App\Models\Editoriale;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ejemplare>
 */
class EjemplareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_libro' => Libro::all()->random()->id,
            'id_editorial' => Editoriale::all()->random()->id,
            'fecha_edi_ejemplar' => $this->faker->dateTime(),
            'estado_ejemplar' =>  $this->faker->word(5), 
        ];
    }
}
