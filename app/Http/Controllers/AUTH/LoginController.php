<?php

namespace App\Http\Controllers\AUTH;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->status == 'inactive') {
                return redirect()->route('status.not.approuved');
            } else {
                return redirect()->route('admin.dashboard');
            }
        } else {
            // Retourne la vue de login avec des en-têtes pour empêcher le cache
            return response()->view('auth.login')
                        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }
    }

    public function login(LoginRequest $request)
    {
        // Tente de se connecter avec les données fournies
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => true], 200);
        }

        return response()->json([
            'errors' => [
                'email' => [__('login.invalid_credentials')]
                ]
            ], 401);
    }
}
