<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntrepriseExportatriceRequest;
use App\Models\EntrepriseExportatrice;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class EntrepriseExportatriceController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = EntrepriseExportatrice::latest()->get();

                $data->map(function ($item) {
                    $item->encrypted_id = Crypt::encryptString($item->id);
                    unset($item->id);
                    return $item;
                });

                return DataTables::of($data)
                    ->addColumn('action', function ($row) {
                        return '
                            <button type="button" class="btn btn-outline-warning btn-sm me-1 btn-show-entreprise"
                                data-id="'.$row->encrypted_id.'" title="'.__('form.seen').'">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm me-1 btn-edit-entreprise"
                                data-id="'.$row->encrypted_id.'" title="'.__('form.edit').'">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete-entreprise-confirm"
                                data-id="'.$row->encrypted_id.'" title="'.__('form.delete').'">
                                <i class="fa fa-trash"></i>
                            </button>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.entreprises_exportatrices.index');

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Erreur lors du chargement des entreprises exportatrices.',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            abort(500, 'Erreur lors du chargement des entreprises exportatrices.');
        }
    }

    public function store(EntrepriseExportatriceRequest $request): JsonResponse
    {
        try {
            $entreprise = EntrepriseExportatrice::create($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Entreprise exportatrice créée avec succès.',
                'data'    => $entreprise,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la création de l’entreprise exportatrice.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $realId    = Crypt::decryptString($id);
            $entreprise = EntrepriseExportatrice::findOrFail($realId);

            return response()->json($entreprise, 200);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Entreprise exportatrice introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erreur lors du chargement.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(EntrepriseExportatriceRequest $request, string $id): JsonResponse
    {
        try {
            $realId    = Crypt::decryptString($id);
            $entreprise = EntrepriseExportatrice::findOrFail($realId);

            $entreprise->update($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Entreprise exportatrice mise à jour avec succès.',
            ]);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Entreprise exportatrice introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erreur lors de la mise à jour.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $realId    = Crypt::decryptString($id);
            $entreprise = EntrepriseExportatrice::findOrFail($realId);

            $entreprise->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Entreprise exportatrice supprimée avec succès.',
            ]);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Entreprise exportatrice introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Erreur lors de la suppression.', 'error' => $e->getMessage()], 500);
        }
    }
}
