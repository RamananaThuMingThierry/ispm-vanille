<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualiteRequest;
use App\Models\Actualite;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ActualiteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $actualites = Actualite::with('auteur:id,pseudo,email')
                ->when($request->get('q'), function ($q, $search) {
                    $q->where('titre', 'like', "%{$search}%");
                })
                ->when($request->get('statut'), function ($q, $statut) {
                    $q->where('statut', $statut);
                })
                ->orderByDesc('created_at');

            return DataTables::of($actualites)
                ->addColumn('action', function ($row) {
                    $id = $row->id;

                    return '
                        <button type="button" class="btn btn-outline-info btn-sm me-1"
                            id="btn-show-actualite" data-id="'.$id.'">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm me-1"
                            id="btn-edit-actualite" data-id="'.$id.'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            id="btn-delete-actualite-confirm" data-id="'.$id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.actualites.index');
    }

    public function store(ActualiteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // statut par défaut
            if (empty($data['statut'])) {
                $data['statut'] = 'publie';
            }

            // date de publication par défaut si publié
            if ($data['statut'] === 'publie' && empty($data['publie_le'])) {
                $data['publie_le'] = now();
            }

            // booléen à la une
            $data['ala_une'] = $request->boolean('ala_une');

            // slug auto
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['titre'] . '-' . uniqid());
            }

            // upload image
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

                $destination = public_path(config('public_path.public_path') . 'images/actualites');
                if (!is_dir($destination)) {
                    @mkdir($destination, 0775, true);
                }
                $file->move($destination, $filename);

                $data['image'] = $filename;
            }

            // auteur par défaut = user connecté
            if (empty($data['auteur_id']) && auth()->check()) {
                $data['auteur_id'] = auth()->id();
            }

            $actu = Actualite::create($data);

            return response()->json([
                'status'  => true,
                'message' => 'Actualité créée avec succès.',
                'data'    => $actu,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la création.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Actualite $actualite): JsonResponse
    {
        return response()->json($actualite->load('auteur:id,pseudo,email'));
    }

    public function update(ActualiteRequest $request, Actualite $actualite): JsonResponse
    {
        try {
            $data = $request->validated();

            if (empty($data['statut'])) {
                $data['statut'] = $actualite->statut ?? 'publie';
            }

            if ($data['statut'] === 'publie' && empty($data['publie_le'])) {
                $data['publie_le'] = $actualite->publie_le ?? now();
            }

            $data['ala_une'] = $request->boolean('ala_une');

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['titre'] . '-' . uniqid());
            }

            // Image : ne changer que si nouveau fichier
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

                $destination = public_path(config('public_path.public_path') . 'images/actualites');
                if (!is_dir($destination)) {
                    @mkdir($destination, 0775, true);
                }
                $file->move($destination, $filename);

                $data['image'] = $filename;
            } else {
                unset($data['image']);
            }

            $actualite->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'Actualité mise à jour avec succès.',
                'data'    => $actualite->fresh(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Erreur lors de la mise à jour.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Actualite $actualite): JsonResponse
    {
        try {
            $actualite->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Actualité supprimée.',
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
