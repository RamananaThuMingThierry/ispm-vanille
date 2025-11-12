<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MarcheSeeder;
use Database\Seeders\ActualiteSeeder;
use App\Models\EntrepriseExportatrice;
use Database\Seeders\ProducteurSeeder;
use Database\Seeders\EntrepriseImportatriceSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProducteurSeeder::class,
            MarcheSeeder::class,
            EntrepriseExportatriceSeeder::class,
            EntrepriseImportatriceSeeder::class,
            ActualiteSeeder::class,
        ]);
    }
}
