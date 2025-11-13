<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProduitRequest;
use App\Models\Produit;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Produit::latest()->get();

                $data->map(function ($item) {
                    $item->encrypted_id = Crypt::encryptString($item->id);
                    unset($item->id);
                    return $item;
                });

                return DataTables::of($data)
                    ->addColumn('action', function ($row) {
                        return '
                            <button type="button" class="btn btn-outline-primary btn-sm me-1"
                                id="btn-show-produit" data-id="'.$row->encrypted_id.'">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm me-1"
                                id="btn-edit-produit" data-id="'.$row->encrypted_id.'">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                id="btn-delete-produit-confirm" data-id="'.$row->encrypted_id.'">
                                <i class="fa fa-trash"></i>
                            </button>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.produits.index');

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Erreur lors du chargement des produits.',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            abort(500, 'Erreur lors du chargement des produits.');
        }
    }

    public function store(ProduitRequest $request): JsonResponse
    {
        try {
            $produit = Produit::create($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Produit créé avec succès.',
                'data'    => $produit,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la création du produit.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $realId = Crypt::decryptString($id);
            $produit = Produit::findOrFail($realId);

            return response()->json($produit, 200);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Produit introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erreur lors du chargement.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(ProduitRequest $request, string $id): JsonResponse
    {
        try {
            $realId = Crypt::decryptString($id);
            $produit = Produit::findOrFail($realId);

            $produit->update($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Produit mis à jour avec succès.',
                'data'    => $produit,
            ]);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Produit introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erreur lors de la mise à jour.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $encryptedId): JsonResponse
    {
        try {
            $realId = Crypt::decryptString($encryptedId);

            $produit = Produit::findOrFail($realId);

            $produit->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Produit supprimé avec succès.',
            ]);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Produit introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erreur lors de la suppression.', 'error' => $e->getMessage()], 500);
        }
    }
}
