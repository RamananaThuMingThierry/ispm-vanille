<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Models\Marche;
use Illuminate\Http\Request;

class FrontMarcheController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable','string','max:100'],
            'produit' => ['nullable','string','max:100'],
            'date_from' => ['nullable','date'],
            'date_to' => ['nullable','date','after_or_equal:date_from'],
            'min_prix' => ['nullable','numeric','min:0'],
            'max_prix' => ['nullable','numeric','gte:min_prix'],
            'disponibilite_min' => ['nullable','integer','min:0'],
        ]);

        $marche = Marche::query()
            ->when($validated['q'] ?? null, fn($q, $val) =>
                $q->where(function($qq) use ($val) {
                    $qq->where('produit', 'like', "%{$val}%");
                })
            )
            ->when($validated['produit'] ?? null, fn($q, $val) =>
                $q->where('produit', 'like', "%{$val}%")
            )
            ->when($validated['date_from'] ?? null, fn($q, $val) =>
                $q->whereDate('date', '>=', $val)
            )
            ->when($validated['date_to'] ?? null, fn($q, $val) =>
                $q->whereDate('date', '<=', $val)
            )
            ->when(isset($validated['min_prix']), fn($q) =>
                $q->where('prix', '>=', request('min_prix'))
            )
            ->when(isset($validated['max_prix']), fn($q) =>
                $q->where('prix', '<=', request('max_prix'))
            )
            ->when(isset($validated['disponibilite_min']), fn($q) =>
                $q->where('disponibilite', '>=', request('disponibilite_min'))
            )
            ->orderByDesc('date');

        $perPage = 12;
        $marches = $marche->paginate($perPage)->appends($validated);

        // Options UI (produits distincts)
        $produits = Marche::select('produit')->distinct()->orderBy('produit')->pluck('produit');

        return view('frontoffice.marche.index', compact('marches', 'produits'));
    }
}
