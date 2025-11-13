<?php

namespace Database\Factories;

use App\Models\EntrepriseExportatrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntrepriseExportatriceFactory extends Factory
{
    protected $model = EntrepriseExportatrice::class;

    public function definition(): array
    {
        return [
            'nom'            => $this->faker->company(),
            'raison_sociale' => $this->faker->company() . ' SARL',
            'pays'           => $this->faker->country(),
            'adresse'        => $this->faker->address(),
            'responsable'    => $this->faker->name(),
            'email'          => $this->faker->unique()->companyEmail(),
            'telephone'      =>  '+261' . $this->faker->numerify('#########'),
            'activite'       => $this->faker->sentence(8),
            'description'    => $this->faker->paragraph(),
        ];
    }
}
