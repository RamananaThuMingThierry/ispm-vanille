<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Producteur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\ProducteurRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProducteurController extends Controller
{
    /**
     * Liste des producteurs (DataTables AJAX) ou vue.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {

                $producteurs = Producteur::query();

                return DataTables::of($producteurs)
                    ->addColumn('action', function ($row) {
                        $encryptedId = Crypt::encryptString($row->id);

                        $editBtn = '<button type="button"
                            class="btn btn-outline-primary btn-sm btn-inline me-1"
                            title="' . __('form.edit') . '"
                            data-id="' . $encryptedId . '"
                            id="btn-edit-producteur">
                            <i class="fa fa-edit"></i>
                        </button>';

                        $viewBtn = '<button type="button"
                            class="btn btn-outline-warning btn-sm btn-inline me-1"
                            title="' . __('form.seen') . '"
                            data-id="' . $encryptedId . '"
                            id="btn-show-producteur">
                            <i class="fa fa-eye"></i>
                        </button>';

                        $deleteBtn = '';
                        if (Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin()) {
                            $deleteBtn = '<button type="button"
                                class="btn btn-outline-danger btn-sm btn-inline"
                                title="' . __('form.delete') . '"
                                data-id="' . $encryptedId . '"
                                id="btn-delete-producteur-confirm">
                                <i class="fa fa-trash"></i>
                            </button>';
                        }

                        return '<div class="d-flex justify-content-center">'
                            . $viewBtn . $editBtn . $deleteBtn .
                            '</div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.producteurs.index');

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'An error occurred while fetching the data.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            abort(500, 'Erreur lors du chargement des producteurs.');
        }
    }

    /**
     * Création d'un producteur.
     */
    public function store(ProducteurRequest $request): JsonResponse
    {
        $producteur = Producteur::create($request->validated());

        return response()->json([
            'message' => 'Producteur créé avec succès.',
            'data' => $producteur,
        ], 201);
    }

    /**
     * Afficher un producteur (ID chiffré).
     */
    public function show(string $id): JsonResponse
    {
        try {
            $producteurId = Crypt::decryptString($id);
            $producteur = Producteur::findOrFail($producteurId);

            return response()->json($producteur, 200);
        } catch (DecryptException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Identifiant invalide.',
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Producteur introuvable.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Une erreur est survenue lors du chargement.',
            ], 500);
        }
    }

    /**
     * Mise à jour d'un producteur (ID chiffré).
     */
    public function update(ProducteurRequest $request, string $id): JsonResponse
    {
        $producteurId = Crypt::decryptString($id);
        $producteur = Producteur::findOrFail($producteurId);

        $producteur->update($request->validated());

        return response()->json([
            'message' => 'Producteur mis à jour avec succès.',
            'data' => $producteur,
        ]);
    }

    /**
     * Suppression d'un producteur (ID chiffré).
     */
public function destroy(string $encryptedId): JsonResponse
{
    try {
        $producteurId = Crypt::decryptString($encryptedId);

        $producteur = Producteur::findOrFail($producteurId);

        $producteur->delete();

        return response()->json([
            'status' => true,
            'message' => 'Producteur supprimé avec succès.',
        ], 200);

    } catch (DecryptException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Identifiant invalide.',
            'error' => $e->getMessage(),
        ], 400);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Producteur introuvable.',
        ], 404);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Une erreur est survenue lors de la suppression.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
