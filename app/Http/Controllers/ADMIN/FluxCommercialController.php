<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\FluxCommercialRequest;
use App\Models\FluxCommercial;
use App\Models\Produit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FluxCommercialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $flux = FluxCommercial::with('produit:id,nom,unite')
                ->when($request->get('type'), fn($q, $type) => $q->where('type', $type))
                ->when($request->get('produit_id'), fn($q, $pid) => $q->where('produit_id', $pid))
                ->when($request->get('annee'), fn($q, $year) => $q->where('annee', $year))
                ->orderByDesc('annee');

            return DataTables::of($flux)
                ->addColumn('produit_nom', function ($row) {
                    return optional($row->produit)->nom;
                })
                ->editColumn('quantite', function ($row) {
                    return $row->quantite !== null
                        ? number_format($row->quantite, 2, ',', ' ')
                        : '';
                })
                ->editColumn('valeur', function ($row) {
                    return $row->valeur !== null
                        ? number_format($row->valeur, 2, ',', ' ') . ' MGA'
                        : '';
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;

                    return '
                        <button type="button" class="btn btn-outline-info btn-sm me-1"
                            id="btn-show-flux" data-id="'.$id.'">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm me-1"
                            id="btn-edit-flux" data-id="'.$id.'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            id="btn-delete-flux-confirm" data-id="'.$id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $produits = Produit::orderBy('nom')->get(['id', 'nom', 'unite']);

        return view('backoffice.flux_commerciaux.index', compact('produits'));
    }

    public function store(FluxCommercialRequest $request): JsonResponse
    {
        try {
            $flux = FluxCommercial::create($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Flux commercial créé avec succès.',
                'data'    => $flux->load('produit:id,nom,unite'),
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
        $flux_commercial = FluxCommercial::find($id);
        return response()->json($flux_commercial->load('produit:id,nom,unite'));
    }

    public function update(FluxCommercialRequest $request, string $id): JsonResponse
    {
        try {
            $flux_commercial = FluxCommercial::find($id);
            $flux_commercial->update($request->validated());
            return response()->json([
                'status'  => true,
                'message' => 'Flux commercial mis à jour avec succès.',
                'data'    => $flux_commercial->fresh()->load('produit:id,nom,unite'),
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
            $flux_commercial = FluxCommercial::find($id);
            $flux_commercial->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Flux commercial supprimé.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la suppression.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
