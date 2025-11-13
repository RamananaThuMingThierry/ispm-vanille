<?php

namespace Database\Seeders;

use App\Models\FluxCommercial;
use App\Models\Produit;
use Illuminate\Database\Seeder;

class FluxCommercialSeeder extends Seeder
{
    public function run(): void
    {
        if (Produit::count() === 0) {
            Produit::factory()->count(5)->create();
        }

        $produits = Produit::all();

        foreach ($produits as $produit) {
            foreach (range(date('Y') - 5, date('Y')) as $annee) {
                foreach (['import', 'export'] as $type) {
                    FluxCommercial::updateOrCreate(
                        ['type' => $type, 'produit_id' => $produit->id, 'annee' => $annee],
                        [
                            'quantite' => rand(100, 10000),
                            'valeur'   => rand(500000, 10000000),
                        ]
                    );
                }
            }
        }

        FluxCommercial::factory()->count(10)->create();
    }
}
