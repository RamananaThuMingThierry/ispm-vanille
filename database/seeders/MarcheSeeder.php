<?php

namespace Database\Seeders;

use App\Models\Marche;
use Illuminate\Database\Seeder;

class MarcheSeeder extends Seeder
{
    public function run(): void
    {
        Marche::factory()->count(20)->create();
    }
}
