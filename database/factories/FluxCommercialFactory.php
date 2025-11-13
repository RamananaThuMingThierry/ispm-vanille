<?php

namespace Database\Factories;

use App\Models\FluxCommercial;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class FluxCommercialFactory extends Factory
{
    protected $model = FluxCommercial::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['import', 'export']);
        return [
            'type'       => $type,
            'produit_id' => Produit::inRandomOrder()->value('id') ?? Produit::factory()->create()->id,
            'annee'      => $this->faker->numberBetween(2018, date('Y')),
            'quantite'   => $this->faker->randomFloat(2, 100, 100000),
            'valeur'     => $this->faker->randomFloat(2, 1000000, 200000000),
        ];
    }
}
