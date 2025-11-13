<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Models\Marche;
use Illuminate\Http\Request;

class FrontMarcheController extends Controller
{
    public function index(Request $request)
    {
        $q = Marche::with('produit')
            ->when($request->q, function ($query, $q) {
                $query->whereHas('produit', fn($p) => $p->where('nom', 'like', "%{$q}%"));
            })
            ->when($request->produit, fn($query, $produitId) => $query->where('produit_id', $produitId))
            ->when($request->date_from, fn($query, $from) => $query->whereDate('date', '>=', $from))
            ->when($request->date_to, fn($query, $to) => $query->whereDate('date', '<=', $to))
            ->when($request->min_prix, fn($query, $min) => $query->where('prix', '>=', $min))
            ->when($request->max_prix, fn($query, $max) => $query->where('prix', '<=', $max))
            ->when($request->disponibilite_min, fn($query, $min) => $query->where('disponibilite', '>=', $min))
            ->orderByDesc('date');

        $marches = $q->paginate(12);

        // liste des produits à partir des marchés
        $produits = Marche::join('produits', 'produits.id', '=', 'marches.produit_id')->distinct()->orderBy('produits.nom')->pluck('produits.nom', 'produits.id');

        return view('frontoffice.marche.index', compact('marches', 'produits'));
    }
}
