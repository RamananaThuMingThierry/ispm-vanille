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
            'nom'         => $this->faker->company(),
            'pays'        => $this->faker->country(),
            'adresse'     => $this->faker->address(),
            'email'       => $this->faker->unique()->companyEmail(),
            'telephone'   => $this->faker->phoneNumber(),
            'responsable' => $this->faker->name(),
            'description' => $this->faker->sentence(10),
        ];
    }
}
