<?php

namespace Database\Factories;

use App\Models\Producteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producteur>
 */
class ProducteurFactory extends Factory
{
    protected $model = Producteur::class;

    public function definition(): array
    {
        return [
            'nom'       => $this->faker->lastName(),
            'prenom'    => $this->faker->firstName(),
            'adresse'   => $this->faker->address(),
            'quantite'  => $this->faker->randomFloat(2, 0, 10000),
            'telephone' =>  '+261' . $this->faker->numerify('#########'),
            'email'     => $this->faker->unique()->safeEmail(),
            'fokontany' => $this->faker->word(),
            'commune'   => $this->faker->city(),
            'district'  => $this->faker->city(),
            'region'    => $this->faker->state(),
        ];
    }
}
