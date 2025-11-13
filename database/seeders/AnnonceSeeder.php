<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Produit;
use Illuminate\Database\Seeder;

class AnnonceSeeder extends Seeder
{
    public function run(): void
    {
        if (Produit::count() === 0) {
            \App\Models\Produit::factory()->count(5)->create();
        }

        // Exemples manuels
        Annonce::updateOrCreate([
            'categorie'  => 'offre',
            'produit_id' => Produit::first()->id,
            'region'     => 'Sava',
        ], [
            'quantite'      => 500,
            'prix_unitaire' => 85000,
            'commune'       => 'Sambava',
            'district'      => 'Sambava',
            'contact'       => '+261 32 12 345 67',
        ]);

        // Annonces aléatoires
        Annonce::factory()->count(15)->create();
    }
}
