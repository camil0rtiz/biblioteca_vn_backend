<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'titulo_libro' => $this->faker->name(),
            'isbn_libro' => $this->faker->word(5),  
            'dewey_libro' => $this->faker->word(5),  
            'resena_libro' => $this->faker->paragraph(),
            'numero_pagi_libro' => $this->faker->randomDigit(),
            'categoria_libro' => $this->faker->word(5),
            'fecha_publi_libro' => $this->faker->dateTime(),
            'estado_libro' => $this->faker->word(5), 
        ];
    }
}
