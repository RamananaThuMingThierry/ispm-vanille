<?php

namespace Database\Factories;

use App\Models\Marche;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarcheFactory extends Factory
{
    protected $model = Marche::class;

    public function definition(): array
    {
        return [
            'date'          => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'produit'       => $this->faker->randomElement(['Vanille', 'Café', 'Cacao', 'Litchi', 'Poivre']),
            'prix'          => $this->faker->randomFloat(2, 1, 5000),
            'disponibilite' => $this->faker->optional()->numberBetween(0, 10000),
        ];
    }
}
