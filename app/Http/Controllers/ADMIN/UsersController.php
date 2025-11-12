<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UsersController extends Controller
{
    use AuthorizesRequests;

    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = $this->userService->getAllUsers();

            $users->map(function ($user) {
                $user->encrypted_id = Crypt::encryptString($user->id);
                return $user;
            });

            return DataTables::of($users)
                ->addColumn('avatar', function ($user) {
                    $src = $user->avatar
                        ? asset(config('public_path.public_path').'images/users/' . $user->avatar)
                        : asset(config('public_path.public_path').'images/avatars/default.png');
                    return '<img src="' . $src . '" class="rounded-circle" width="30" height="30" alt="Avatar">';
                })
                ->addColumn('action', function ($user) {
                    $showBtn = '<button type="button"
                        class="btn btn-outline-warning btn-sm me-1"
                        data-id="' . $user->encrypted_id . '"
                        id="btn-show-user">
                        <i class="fa fa-eye"></i>
                    </button>';
                    $edit = $delete = '';
                    if (Auth::user()->isAdmin() && Auth::user()->id != $user->id) {
                        $edit = '<button class="btn btn-sm btn-outline-primary me-1" data-id="'.$user->encrypted_id.'" data-role="'.$user->role.'" data-status="'.$user->status.'" id="btn-edit-user">
                            <i class="fa fa-edit"></i>
                        </button>';
                        $delete = '<button class="btn btn-sm btn-danger"
                            data-id="'.$user->id.'"
                            id="btn-delete-user">
                            <i class="fa fa-trash"></i>
                        </button>';
                    }
                    return '<div class="d-flex justify-content-center">'. $showBtn . $edit . $delete . '</div>';
                })
                ->rawColumns(['avatar', 'action'])
                ->make(true);
        }

        return view('backoffice.users.index');
    }
    /**
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try{
            $id = Crypt::decryptString($encrypted_id);

            $user = $this->userService->getUserById($id);

            $user->avatar_url = $user->avatar ? asset(config('public_path.public_path').'images/users/' . $user->avatar) : asset(config('public_path.public_path').'images/avatars/default.png');

            return response()->json([
                'status' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.delete_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $encrypted_id)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
        ]);

        try{
            $id = Crypt::decryptString($encrypted_id);

            $user = $this->userService->getUserById($id);

            $user->update([
                'role' => $request->role,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('Utilisateur mis à jour avec succès.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.delete_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($encrypted_id)
    {
        try {
            $id = Crypt::decryptString($encrypted_id);

            $user = $this->userService->getUserById($id);

            if (auth()->id() == $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Vous ne pouvez pas vous supprimer vous-même.'
                ], 403);
            }

            if ($user->avatar && file_exists(public_path('images/users/' . $user->avatar))) {
                unlink(public_path('images/users/' . $user->avatar));
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Utilisateur supprimé avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.delete_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
