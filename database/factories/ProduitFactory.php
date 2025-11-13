<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        // Quelques unités possibles
        $unites = ['kg', 'tonne', 'sac', 'boîte'];

        return [
            'nom'       => ucfirst($this->faker->unique()->word()),
            'unite'     => $this->faker->randomElement($unites),
        ];
    }
}
