<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),  // Nombre aleatorio
            'description' => $this->faker->sentence(), // Descripción aleatoria
            'price' => $this->faker->numberBetween(1000, 50000), // Precio entre 1000 y 50000
        ];
    }
}