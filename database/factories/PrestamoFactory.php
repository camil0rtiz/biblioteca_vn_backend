<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ejemplare;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_vecino' => User::all()->random()->id,
            'id_bibliotecario'=> User::all()->random()->id,
            'id_ejemplar' =>  Ejemplare::all()->random()->id,
            'fecha_prestamo' => $this->faker->dateTime(),
            'fecha_rece_prestamo' => $this->faker->dateTime(),
            'fecha_entrega_prestamo' => $this->faker->dateTime(),
            'observaciones' => $this->faker->paragraph(),
            'estado_prestamo' => $this->faker->word(5),
        ];
    }
}
