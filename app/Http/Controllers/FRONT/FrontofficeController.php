<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Models\Producteur;
use App\Models\EntrepriseExportatrice;
use App\Models\EntrepriseImportatrice;
use App\Models\Marche;
use App\Models\Actualite;

class FrontofficeController extends Controller
{
    public function __invoke()
    {
        // Slides hero (statique ou DB)
        $slides = [
            ['image' => asset(config('public_path.public_path').'images/V6.jpg'), 'title' => 'Des marchés plus lisibles', 'subtitle' => 'Suivez les prix et disponibilités en temps réel.', 'badge' => 'Transparence'],
            ['image' => asset(config('public_path.public_path').'images/V7.jpg'), 'title' => 'Reliez l’offre et la demande', 'subtitle' => 'Mettez en relation producteurs et entreprises.', 'badge' => 'Connexion'],
        ];

        // Listes
        $marches       = Marche::orderByDesc('date')->limit(6)->get();
        $producteurs   = Producteur::latest()->limit(6)->get();
        $exportatrices = EntrepriseExportatrice::latest()->limit(3)->get();
        $importatrices = EntrepriseImportatrice::latest()->limit(3)->get();
        $actualites    = Actualite::latest()->limit(6)->get();

        $metrics = [
            'producteurs'   => Producteur::count(),
            'marches'       => Marche::count(),
            'exportatrices' => EntrepriseExportatrice::count(),
            'importatrices' => EntrepriseImportatrice::count(),
        ];

        return view('frontoffice.index', compact(
            'slides','marches','producteurs','exportatrices','importatrices','actualites','metrics'
        ));
    }
}
