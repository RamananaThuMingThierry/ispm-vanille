<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnonceRequest;
use App\Models\Annonce;
use App\Models\Produit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        // DataTables (AJAX)
        if ($request->ajax()) {
            $annonces = Annonce::with('produit:id,nom,unite')
                ->when($request->get('categorie'), fn($q, $cat) => $q->where('categorie', $cat))
                ->when($request->get('produit_id'), fn($q, $pid) => $q->where('produit_id', $pid))
                ->when($request->get('region'), fn($q, $reg) => $q->where('region', $reg))
                ->latest();

            return DataTables::of($annonces)
                ->addColumn('produit_nom', function ($row) {
                    return optional($row->produit)->nom;
                })
                ->addColumn('quantite_unite', function ($row) {
                    if ($row->quantite === null) {
                        return '';
                    }
                    $unit = optional($row->produit)->unite;
                    return $row->quantite . ($unit ? ' ' . $unit : '');
                })
                ->editColumn('prix_unitaire', function ($row) {
                    return $row->prix_formatted;
                })
                ->addColumn('localisation', function ($row) {
                    $parts = array_filter([$row->commune, $row->district, $row->region]);
                    return implode(' - ', $parts);
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;

                    return '
                        <button type="button" class="btn btn-outline-info btn-sm me-1"
                            id="btn-show-annonce" data-id="'.$id.'">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm me-1"
                            id="btn-edit-annonce" data-id="'.$id.'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            id="btn-delete-annonce-confirm" data-id="'.$id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // pour le formulaire (select produit)
        $produits = Produit::orderBy('nom')->get(['id', 'nom', 'unite']);

        return view('backoffice.annonces.index', compact('produits'));
    }

    public function store(AnnonceRequest $request): JsonResponse
    {
        try {
            $annonce = Annonce::create($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Annonce créée avec succès.',
                'data'    => $annonce->load('produit:id,nom,unite'),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>'Erreur lors de la création.',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    public function show(Annonce $annonce): JsonResponse
    {
        return response()->json($annonce->load('produit:id,nom,unite'));
    }

    public function update(AnnonceRequest $request, Annonce $annonce): JsonResponse
    {
        try {
            $annonce->update($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Annonce mise à jour avec succès.',
                'data'    => $annonce->fresh()->load('produit:id,nom,unite'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>'Erreur lors de la mise à jour.',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    public function destroy(Annonce $annonce): JsonResponse
    {
        try {
            $annonce->delete();

            return response()->json([
                'status'=>true,
                'message'=>'Annonce supprimée.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>'Erreur lors de la suppression.',
                'error'=>$e->getMessage()
            ],500);
        }
    }
}
