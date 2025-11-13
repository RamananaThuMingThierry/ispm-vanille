<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnonceFactory extends Factory
{
    protected $model = Annonce::class;

    public function definition(): array
    {
        $categorie = $this->faker->randomElement(['offre', 'demande']);

        return [
            'categorie'     => $categorie,
            'produit_id'    => Produit::inRandomOrder()->value('id') ?? Produit::factory()->create()->id,
            'quantite'      => $this->faker->randomFloat(2, 50, 5000),
            'prix_unitaire' => $this->faker->randomFloat(2, 2000, 200000),
            'commune'       => $this->faker->city(),
            'district'      => $this->faker->word(),
            'region'        => $this->faker->randomElement(['Analamanga', 'Sava', 'Atsinanana', 'Boeny']),
            'contact' =>  '+261' . $this->faker->numerify('#########'),
        ];
    }
}
