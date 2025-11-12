<?php

namespace Database\Factories;

use App\Models\Actualite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActualiteFactory extends Factory
{
    protected $model = Actualite::class;

    public function definition(): array
    {
        return [
            'titre'    => $this->faker->sentence(6),
            'contenu'  => $this->faker->paragraphs(3, true),
            'image'    => null,
            'ala_une'  => $this->faker->boolean(20),
        ];
    }
}
