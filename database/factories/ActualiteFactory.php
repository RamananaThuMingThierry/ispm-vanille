<?php

namespace Database\Factories;

use App\Models\Actualite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActualiteFactory extends Factory
{
    protected $model = Actualite::class;

    public function definition()
    {
        $titre = $this->faker->sentence(6);

        return [
            'titre'      => $titre,
            'slug'       => Str::slug($titre) . '-' . Str::random(5),
            'contenu'    => $this->faker->paragraphs(3, true),
            'image'      => $this->faker->imageUrl(800, 600, 'news'),
            'statut'     => $this->faker->randomElement(['brouillon', 'publie']),
            'publie_le'  => $this->faker->optional()->dateTime(),
            'ala_une'    => $this->faker->boolean(20),
            'auteur_id'  => User::factory(),
        ];
    }
}
