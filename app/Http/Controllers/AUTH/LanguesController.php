<?php

namespace App\Http\Controllers\AUTH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguesController extends Controller
{
    public function changeLanguage($lang)
    {
        if (in_array($lang, ['en', 'fr', 'de','es'])) {
            session(['locale' => $lang]);

            if (request()->ajax()) {
                return response()->json(['status' => 'success', 'locale' => $lang]);
            }
        }

        if (request()->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Langue invalide'], 400);
        }
    
        return redirect()->back();
    }
}
