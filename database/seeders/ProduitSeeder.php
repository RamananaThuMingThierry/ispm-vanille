<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nom' => 'Vanille',      'unite' => 'kg'],
            ['nom' => 'Clou de girofle','unite' => 'kg'],
            ['nom' => 'Poivre',       'unite' => 'kg'],
            ['nom' => 'Litchi',       'unite' => 'kg'],
            ['nom' => 'Riz',          'unite' => 'kg'],
            ['nom' => 'Cacao',        'unite' => 'kg'],
        ];

        foreach ($data as $row) {
            Produit::updateOrCreate(['nom' => $row['nom']], $row);
        }

        Produit::factory()->count(10)->create();
    }
}
