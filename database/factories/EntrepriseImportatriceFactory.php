<?php

namespace Database\Factories;

use App\Models\EntrepriseImportatrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntrepriseImportatriceFactory extends Factory
{
    protected $model = EntrepriseImportatrice::class;

    public function definition(): array
    {
        return [
            'nom'             => $this->faker->company(),
            'raison_sociale'  => $this->faker->company() . ' SA',
            'pays'            => $this->faker->country(),
            'adresse'         => $this->faker->address(),
            'responsable'     => $this->faker->name(),
            'email'           => $this->faker->unique()->companyEmail(),
            'telephone'       => '+261' . $this->faker->numerify('#########'),
            'activite'        => $this->faker->sentence(8),
            'description'     => $this->faker->paragraph(),
        ];
    }
}
