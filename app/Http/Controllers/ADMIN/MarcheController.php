<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarcheRequest;
use App\Models\Marche;
use App\Models\Produit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MarcheController extends Controller
{
    public function index(Request $request)
    {
        // Pour le select dans le modal
        $produits = Produit::orderBy('nom')->get(['id', 'nom']);

        try {
            if ($request->ajax()) {

                $marches = Marche::query()
                    ->with('produit:id,nom,unite')
                    ->orderByDesc('date');

                return DataTables::of($marches)
                    // Produit = nom du produit
                    ->addColumn('produit', function ($row) {
                        return optional($row->produit)->nom;
                    })
                    // Date affichée en d-m-Y dans le tableau
                    ->editColumn('date', function ($row) {
                        return $row->date ? $row->date->format('d-m-Y') : '';
                    })
                    // Prix affiché dans le tableau (sans MGA, tu peux l’ajouter si tu veux)
                    ->editColumn('prix', function ($row) {
                        return $row->prix;
                    })
                    // Boutons action
                    ->addColumn('action', function ($row) {
                        $id = $row->id; // si tu veux chiffrer: encrypt($row->id)

                        return '
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button"
                                        class="btn btn-info btn-sm"
                                        id="btn-show-marche"
                                        data-id="'.$id.'">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        id="btn-edit-marche"
                                        data-id="'.$id.'">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button type="button"
                                        class="btn btn-danger btn-sm"
                                        id="btn-delete-marche-confirm"
                                        data-id="'.$id.'">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.marches.index', compact('produits'));

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while fetching the data.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function store(MarcheRequest $request): JsonResponse
    {
        try {
            $marche = Marche::create($request->validated());
            $marche->load('produit:id,nom,unite');

            return response()->json([
                'status'  => true,
                'message' => 'Enregistrement marché créé.',
                'data'    => $marche,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la création.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $marche = Marche::with('produit:id,nom,unite')->find($id);

        if (!$marche) {
            return response()->json([
                'status'  => false,
                'message' => 'Marché introuvable.',
            ], 404);
        }

        return response()->json([
            'id'             => $marche->id,
            // Pour input type="date"
            'date'           => $marche->date ? $marche->date->format('Y-m-d') : null,
            // Pour affichage dans le modal "show" (si tu veux)
            'date_formatted' => $marche->date ? $marche->date->format('d-m-Y') : null,

            'produit_id'     => $marche->produit_id,
            'produit'        => $marche->produit?->nom,
            'unite'          => $marche->produit?->unite,

            // brut pour édition
            'prix'           => (float) $marche->prix,
            // formaté pour affichage
            'prix_formatted' => number_format($marche->prix, 2, ',', ' ') . ' MGA',

            'disponibilite'  => $marche->disponibilite,
        ]);
    }

    public function update(MarcheRequest $request, string $id): JsonResponse
    {
        try {
            $marche = Marche::find($id);

            if (!$marche) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Enregistrement introuvable.',
                ], 404);
            }

            $marche->update($request->validated());
            $marche->load('produit:id,nom,unite');

            return response()->json([
                'status'  => true,
                'message' => 'Enregistrement marché mis à jour.',
                'data'    => $marche,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la mise à jour.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $marche = Marche::find($id);

            if (!$marche) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Enregistrement introuvable.',
                ], 404);
            }

            $marche->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Enregistrement supprimé.',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la suppression.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
