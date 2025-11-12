<?php

namespace Database\Seeders;

use App\Models\EntrepriseExportatrice;
use Illuminate\Database\Seeder;

class EntrepriseExportatriceSeeder extends Seeder
{
    public function run(): void
    {
        EntrepriseExportatrice::factory()->count(20)->create();
    }
}
