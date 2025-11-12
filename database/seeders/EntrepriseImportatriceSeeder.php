<?php

namespace Database\Seeders;

use App\Models\EntrepriseImportatrice;
use Illuminate\Database\Seeder;

class EntrepriseImportatriceSeeder extends Seeder
{
    public function run(): void
    {
        EntrepriseImportatrice::factory()->count(20)->create();
    }
}
