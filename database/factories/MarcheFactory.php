<?php

namespace Database\Factories;

use App\Models\Marche;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarcheFactory extends Factory
{
    protected $model = Marche::class;

    public function definition(): array
    {
        return [
            'date'          => $this->faker->dateTimeBetween('-12 months', 'now')->format('Y-m-d'),
            'produit_id'    => Produit::inRandomOrder()->value('id') ?? Produit::factory()->create()->id,
            'marche'        => $this->faker->randomElement(['Analakely','Sambava','Toamasina','Mahajanga']),
            'monnaie'       => 'MGA',
            'source'        => $this->faker->randomElement(['DGCI','Enquête terrain','Déclaration opérateur']),
            'prix'          => $this->faker->randomFloat(2, 5000, 250000),
            'disponibilite' => $this->faker->numberBetween(0, 5000),
        ];
    }
}
