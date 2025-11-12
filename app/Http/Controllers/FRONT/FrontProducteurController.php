<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Models\Producteur;
use Illuminate\Http\Request;

class FrontProducteurController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable','string','max:100'],
            'region' => ['nullable','string','max:100'],
            'district' => ['nullable','string','max:100'],
            'commune' => ['nullable','string','max:100'],
            'min_quantite' => ['nullable','numeric','min:0'],
        ]);

        $query = Producteur::query()
            ->when($validated['q'] ?? null, function($q, $val) {
                $q->where(function($qq) use ($val) {
                    $qq->where('nom', 'like', "%{$val}%")
                       ->orWhere('prenom', 'like', "%{$val}%")
                       ->orWhere('adresse', 'like', "%{$val}%")
                       ->orWhere('fokontany', 'like', "%{$val}%")
                       ->orWhere('commune', 'like', "%{$val}%")
                       ->orWhere('district', 'like', "%{$val}%")
                       ->orWhere('region', 'like', "%{$val}%");
                });
            })
            ->when($validated['region'] ?? null, fn($q, $val) => $q->where('region', $val))
            ->when($validated['district'] ?? null, fn($q, $val) => $q->where('district', $val))
            ->when($validated['commune'] ?? null, fn($q, $val) => $q->where('commune', $val))
            ->when(isset($validated['min_quantite']), fn($q) => $q->where('quantite', '>=', request('min_quantite')))
            ->latest();

        $perPage = 12;
        $producteurs = $query->paginate($perPage)->appends($validated);

        // Filtres distincts
        $regions = Producteur::whereNotNull('region')->distinct()->orderBy('region')->pluck('region');
        $districts = Producteur::whereNotNull('district')->distinct()->orderBy('district')->pluck('district');
        $communes = Producteur::whereNotNull('commune')->distinct()->orderBy('commune')->pluck('commune');

        return view('frontoffice.producteurs.index', compact('producteurs','regions','districts','communes'));
    }
}
