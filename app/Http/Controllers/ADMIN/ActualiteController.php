<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\ActualiteRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActualiteController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Actualite::query();

                return DataTables::of($query)
                    ->addColumn('action', function ($row) {
                        $encryptedId = Crypt::encryptString($row->id);

                        $editBtn = '<button type="button"
                            class="btn btn-outline-primary btn-sm btn-inline me-1"
                            title="' . __('form.edit') . '"
                            data-id="' . $encryptedId . '"
                            id="btn-edit-actualite">
                            <i class="fa fa-edit"></i>
                        </button>';

                        $viewBtn = '<button type="button"
                            class="btn btn-outline-warning btn-sm btn-inline me-1"
                            title="' . __('form.seen') . '"
                            data-id="' . $encryptedId . '"
                            id="btn-show-actualite">
                            <i class="fa fa-eye"></i>
                        </button>';

                        $deleteBtn = '';
                        if (Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin()) {
                            $deleteBtn = '<button type="button"
                                class="btn btn-outline-danger btn-sm btn-inline"
                                title="' . __('form.delete') . '"
                                data-id="' . $encryptedId . '"
                                id="btn-delete-actualite-confirm">
                                <i class="fa fa-trash"></i>
                            </button>';
                        }

                        return '<div class="d-flex justify-content-center">' .
                            $viewBtn . $editBtn . $deleteBtn .
                            '</div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.actualites.index');
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur lors du chargement des actualités.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            abort(500, 'Erreur lors du chargement des actualités.');
        }
    }

    public function store(ActualiteRequest $request)
    {
        try {
            $data = $request->validated();

            // Checkbox ala_une
            $data['ala_une'] = $request->boolean('ala_une');

            // Image
            if($request->hasFile('image')){
                $image_url = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $image_url->getClientOriginalExtension();
                $image_url->move(public_path('images/actualites'), $imageName);
                $data['image'] = $imageName;
            }

            $actualite = Actualite::create($data);

            return response()->json([
                'status'  => true,
                'message' => 'Actualité créée avec succès.',
                'data'    => $actualite,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la création de l’actualité.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $encryptedId): JsonResponse
    {
        try {
            $actualiteId = Crypt::decryptString($encryptedId);
            $actualite = Actualite::findOrFail($actualiteId);

            return response()->json($actualite);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Actualité introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors du chargement de l’actualité.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(ActualiteRequest $request, string $encryptedId): JsonResponse
    {
        try {
            $actualiteId = Crypt::decryptString($encryptedId);
            $actualite   = Actualite::findOrFail($actualiteId);

            $data = $request->validated();
            $data['ala_une'] = $request->boolean('ala_une');

            // Nouvelle image ?
            // Gérer l'image si elle existe
            if ($request->hasFile('image')) {

                if($actualite->image){
                    $oldPath = public_path('images/actualites/' . $actualite->image);
                    if (file_exists($oldPath))unlink($oldPath);
                }

                $image = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/actualites'), $imageName);

                $data['image'] = $imageName;
            }

            $actualite->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'Actualité mise à jour avec succès.',
                'data'    => $actualite,
            ]);
        } catch (DecryptException $e) {
            return response()->json(['status' => false, 'message' => 'Identifiant invalide.'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Actualité introuvable.'], 404);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la mise à jour de l’actualité.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $encryptedId)
    {
        try {
            $actualiteId = Crypt::decryptString($encryptedId);
            $actualite = Actualite::findOrFail($actualiteId);

            if($actualite->image){
                $oldPath = public_path('images/actualites/' . $actualite->image);
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $actualite->delete();

            return response()->json([
                'status' => true,
                'message' => 'Actualité supprimée avec succès.',
            ]);
        } catch (DecryptException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Identifiant invalide.',
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Actualité introuvable.',
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
