<?php

namespace App\Http\Controllers\ADMIN;

use Carbon\Carbon;
use App\Models\Producteur;
use App\Models\EntrepriseExportatrice;
use App\Models\EntrepriseImportatrice;
use App\Models\Marche;
use App\Models\Actualite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Compteurs
        $producteursCount   = Producteur::count();
        $exportatricesCount = EntrepriseExportatrice::count();
        $importatricesCount = EntrepriseImportatrice::count();
        $marchesCount       = Marche::count();
        $actualitesCount    = Actualite::count();

        // --- Série mensuelle (ex: nombre d'entrées marché par mois de l'année courante)
        $currentYear = now()->year;

        // Retourne un tableau [mois => count]
        $monthlyMarches = Marche::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->whereYear('date', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month'); // ex: [1 => 10, 2 => 5, ...]

        $labels = [];
        $data   = [];

        // Libellés FR des 12 mois + données
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->locale('fr')->translatedFormat('F'); // janvier, février, ...
            $data[]   = (int) ($monthlyMarches[$i] ?? 0);
        }

        // --- Dernières entrées du marché (pour le tableau)
        $lastMarches = Marche::orderByDesc('date')->take(10)->get();

        return view('backoffice.dashboard.index', [
            'labels'             => json_encode($labels, JSON_UNESCAPED_UNICODE),
            'data'               => json_encode($data),
            'producteursCount'   => $producteursCount,
            'exportatricesCount' => $exportatricesCount,
            'importatricesCount' => $importatricesCount,
            'marchesCount'       => $marchesCount,
            'actualitesCount'    => $actualitesCount,
            'lastMarches'        => $lastMarches,
        ]);
    }
}
