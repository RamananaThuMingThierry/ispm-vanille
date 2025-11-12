<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;

class FrontActualiteController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable','string','max:100'],
            'ala_une' => ['nullable','in:0,1'],
        ]);

        $actus = Actualite::query()
            ->when($validated['q'] ?? null, function($q, $val) {
                $q->where(function($qq) use ($val) {
                    $qq->where('titre','like',"%{$val}%")->orWhere('contenu','like',"%{$val}%");
                });
            })
            ->when(isset($validated['ala_une']), fn($q) =>
                $q->where('ala_une', (bool) request('ala_une'))
            )
            ->latest()
            ->paginate(12)
            ->appends($validated);

        return view('frontoffice.actualites.index', compact('actus'));
    }

    public function show(Actualite $actualite)
    {
        $recentes = Actualite::latest()->where('id','!=',$actualite->id)->limit(6)->get();
        return view('frontoffice.actualites.show', compact('actualite','recentes'));
    }
}
