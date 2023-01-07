<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_categoria' => Categoria::all()->random()->id,
            'id_usuario' => User::all()->random()->id,
            'nombre_evento' => $this->faker->word(10),
            'fecha_evento' => $this->faker->dateTime(),
            'fecha_publi_evento' => $this->faker->dateTime(),
            'estado_evento' => $this->faker->word(5)  
        ];
    }
}
