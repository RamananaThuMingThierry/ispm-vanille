<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Annonce;
use App\Models\EntrepriseExportatrice;
use App\Models\EntrepriseImportatrice;
use App\Models\Marche;
use App\Models\Producteur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- Compteurs globaux (tous les enregistrements)
        $producteursCount   = Producteur::count();
        $exportatricesCount = EntrepriseExportatrice::count();
        $importatricesCount = EntrepriseImportatrice::count();
        $marchesCount       = Marche::count();
        $actualitesCount    = Actualite::count();

        // --- Filtres année / mois
        $currentYear   = now()->year;
        $selectedYear  = (int) $request->input('year', $currentYear);
        $selectedMonth = $request->input('month'); // null ou 1..12

        // Liste des années (ex: sur 5 ans en arrière)
        $years = range($currentYear, $currentYear - 5);

        // Liste des mois pour le select
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->locale('fr')->translatedFormat('F');
        }

        // --- PÉRIODE COMMUNE (début/fin) POUR TOUS LES FILTRES
        if (empty($selectedMonth)) {
            // Toute l'année sélectionnée
            $startPeriod = Carbon::create($selectedYear, 1, 1)->startOfDay();
            $endPeriod   = Carbon::create($selectedYear, 12, 31)->endOfDay();
        } else {
            // Mois précis
            $startPeriod = Carbon::create($selectedYear, $selectedMonth, 1)->startOfDay();
            $endPeriod   = (clone $startPeriod)->endOfMonth()->endOfDay();
        }

        // ==========================
        // 1) GRAPHIQUE MARCHÉS
        // ==========================

        $labels    = [];
        $data      = [];
        $chartMode = empty($selectedMonth) ? 'months' : 'days';

        if ($chartMode === 'months') {
            // graph par mois
            $monthly = Marche::whereBetween('date', [$startPeriod->toDateString(), $endPeriod->toDateString()])
                ->selectRaw('MONTH(date) as month, COUNT(*) as count')
                ->groupBy('month')
                ->pluck('count', 'month'); // [1 => x, 2 => y, ...]

            for ($i = 1; $i <= 12; $i++) {
                $labels[] = Carbon::create()->month($i)->locale('fr')->translatedFormat('F');
                $data[]   = (int) ($monthly[$i] ?? 0);
            }
        } else {
            // graph par jour du mois
            $daily = Marche::whereBetween('date', [$startPeriod->toDateString(), $endPeriod->toDateString()])
                ->selectRaw('DAY(date) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day'); // [1 => a, 2 => b, ...]

            $daysInMonth = $startPeriod->daysInMonth;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = str_pad($d, 2, '0', STR_PAD_LEFT); // "01", "02", ...
                $data[]   = (int) ($daily[$d] ?? 0);
            }
        }

        // ==========================
        // 2) OFFRES / DEMANDES (ANNONCES)
        // ==========================

        $annoncesQuery = Annonce::whereBetween('created_at', [$startPeriod, $endPeriod]);

        $offresCount   = (clone $annoncesQuery)->where('categorie', 'offre')->count();
        $demandesCount = (clone $annoncesQuery)->where('categorie', 'demande')->count();

        $annonceLabels = ['Offres', 'Demandes'];
        $annonceData   = [(int) $offresCount, (int) $demandesCount];

        // ==========================
        // 3) DERNIÈRES ENTRÉES MARCHÉS (LISTE)
        // ==========================

        $lastMarches = Marche::with('produit:id,nom,unite')
            ->whereBetween('date', [$startPeriod->toDateString(), $endPeriod->toDateString()])
            ->orderByDesc('date')
            ->take(10)
            ->get();

        return view('backoffice.dashboard.index', [
            // données graph marchés
            'labels'    => $labels,
            'data'      => $data,
            'chartMode' => $chartMode,

            // compteurs globaux
            'producteursCount'   => $producteursCount,
            'exportatricesCount' => $exportatricesCount,
            'importatricesCount' => $importatricesCount,
            'marchesCount'       => $marchesCount,
            'actualitesCount'    => $actualitesCount,

            // liste marchés filtrée
            'lastMarches'        => $lastMarches,

            // graph Offres vs Demandes filtré
            'annonceLabels'      => $annonceLabels,
            'annonceData'        => $annonceData,

            // filtres
            'years'        => $years,
            'months'       => $months,
            'selectedYear' => $selectedYear,
            'selectedMonth'=> $selectedMonth,
        ]);
    }
}
