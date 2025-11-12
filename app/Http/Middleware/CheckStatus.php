<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ← C'est ce qu'il te manquait

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isInactive()) {
                return redirect()->route('status.not.approuved');
            }

            if ($user->isActive()) {
                return $next($request);
            }

            return redirect()->route('login');
        }else{
            return redirect()->route('frontoffice');
        }


    }
}
