<?php

namespace Database\Seeders;

use App\Models\Producteur;
use Illuminate\Database\Seeder;

class ProducteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producteur::factory()->count(20)->create();
    }
}
