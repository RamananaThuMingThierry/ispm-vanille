<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarcheRequest;
use App\Models\Marche;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class MarcheController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Marche::query()->latest('date');

                return DataTables::of($query)
                    ->addColumn('action', function ($row) {
                        $encryptedId = Crypt::encryptString($row->id);

                        return '
                            <button type="button" class="btn btn-outline-warning btn-sm me-1"
                                id="btn-show-marche" data-id="' . $encryptedId . '"
                                title="' . __('form.seen') . '">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm me-1"
                                id="btn-edit-marche" data-id="' . $encryptedId . '"
                                title="' . __('form.edit') . '">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                id="btn-delete-marche-confirm" data-id="' . $encryptedId . '"
                                title="' . __('form.delete') . '">
                                <i class="fa fa-trash"></i>
                            </button>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.marches.index');
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Erreur lors du chargement des marchés.',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            abort(500, 'Erreur lors du chargement des marchés.');
        }
    }

    public function store(MarcheRequest $request): JsonResponse
    {
        try {
            $marche = Marche::create($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Marché créé avec succès.',
                'data'    => $marche,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la création du marché.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $marcheId = Crypt::decryptString($id);
            $marche   = Marche::findOrFail($marcheId);

            return response()->json($marche, 200);
        } catch (DecryptException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Identifiant invalide.',
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Marché introuvable.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors du chargement du marché.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(MarcheRequest $request, string $id): JsonResponse
    {
        try {
            $marcheId = Crypt::decryptString($id);
            $marche   = Marche::findOrFail($marcheId);

            $marche->update($request->validated());

            return response()->json([
                'status'  => true,
                'message' => 'Marché mis à jour avec succès.',
                'data'    => $marche,
            ]);
        } catch (DecryptException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Identifiant invalide.',
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Marché introuvable.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la mise à jour du marché.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $marcheId = Crypt::decryptString($id);
            $marche   = Marche::findOrFail($marcheId);

            $marche->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Marché supprimé avec succès.',
            ]);
        } catch (DecryptException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Identifiant invalide.',
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Marché introuvable.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la suppression du marché.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
