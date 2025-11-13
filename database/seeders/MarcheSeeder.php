<?php

namespace Database\Seeders;

use App\Models\Marche;
use App\Models\Produit;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\ProduitSeeder;

class MarcheSeeder extends Seeder
{
    public function run(): void
    {
        $produits = Produit::inRandomOrder()->take(3)->get();
        $marches  = ['Analakely','Sambava','Toamasina'];

        foreach ($produits as $prod) {
            $d = Carbon::now()->startOfMonth()->subMonths(11);
            for ($i=0; $i<12; $i++) {
                foreach ($marches as $m) {
                    Marche::factory()->create([
                        'date'       => $d->copy()->endOfMonth()->toDateString(),
                        'produit_id' => $prod->id,
                        'marche'     => $m,
                    ]);
                }
                $d->addMonth();
            }
        }

        Marche::factory()->count(20)->create();
    }
}
