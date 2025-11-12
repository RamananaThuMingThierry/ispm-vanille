<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Models\EntrepriseExportatrice;
use App\Models\EntrepriseImportatrice;
use Illuminate\Http\Request;

class FrontEntrepriseController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'type' => ['nullable','in:all,export,import'],
            'pays' => ['nullable','string','max:100'],
            'q' => ['nullable','string','max:100'],
        ]);

        $type = $validated['type'] ?? 'all';
        $pays = $validated['pays'] ?? null;
        $q    = $validated['q'] ?? null;

        $exports = EntrepriseExportatrice::query()
            ->when($pays, fn($q, $val) => $q->where('pays', $val))
            ->when($q, function($query, $val) {
                $query->where(function($qq) use ($val) {
                    $qq->where('nom','like',"%{$val}%")->orWhere('description','like',"%{$val}%")->orWhere('responsable','like',"%{$val}%");
                });
            })
            ->latest();

        $imports = EntrepriseImportatrice::query()
            ->when($pays, fn($q, $val) => $q->where('pays', $val))
            ->when($q, function($query, $val) {
                $query->where(function($qq) use ($val) {
                    $qq->where('nom','like',"%{$val}%")->orWhere('description','like',"%{$val}%")->orWhere('responsable','like',"%{$val}%");
                });
            })
            ->latest();

        $perPage = 12;

        $exportatrices = in_array($type, ['all','export']) ? $exports->paginate($perPage, ['*'], 'export_page')->appends($validated) : collect();
        $importatrices = in_array($type, ['all','import']) ? $imports->paginate($perPage, ['*'], 'import_page')->appends($validated) : collect();

        // Options pays
        $paysList = collect()
            ->merge(EntrepriseExportatrice::whereNotNull('pays')->distinct()->pluck('pays'))
            ->merge(EntrepriseImportatrice::whereNotNull('pays')->distinct()->pluck('pays'))
            ->unique()->sort()->values();

        return view('frontoffice.entreprises.index', compact('exportatrices','importatrices','paysList','type'));
    }
}
