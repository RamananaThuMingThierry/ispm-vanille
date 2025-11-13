<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MarcheSeeder;
use Database\Seeders\ProduitSeeder;
use Database\Seeders\ActualiteSeeder;
use Database\Seeders\ProducteurSeeder;
use Database\Seeders\EntrepriseExportatriceSeeder;
use Database\Seeders\EntrepriseImportatriceSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProducteurSeeder::class,
            ProduitSeeder::class,
            MarcheSeeder::class,
            EntrepriseExportatriceSeeder::class,
            EntrepriseImportatriceSeeder::class,
            ActualiteSeeder::class,
        ]);
    }
}
