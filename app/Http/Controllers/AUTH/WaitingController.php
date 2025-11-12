<?php

namespace App\Http\Controllers\AUTH;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class WaitingController extends Controller
{
    public function waiting()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->isInactive()){
                return view('auth.waiting');
            }else{
                return redirect()->route('admin.dashboard');
            }

        }else{
            return redirect()->route('login');
        }
    }
}
